<?php


namespace App\Services;


use App\DTO\Library\LibraryDTO;
use App\Models\Library;
use App\Models\WordsStatistics;

final class LibraryService
{
    public function create(LibraryDTO $dto, int $userId): int
    {
        $model = (new Library())->newQuery();
        $result = $model->create(
            [
                'user_id' => $userId,
                'title' => $dto->title,
                'description' => $dto->description
            ]
        );

        return $result->id;
    }

    public function edit(int $libraryId, LibraryDTO $dto): bool
    {
        $model = (new Library)->newQuery();

        return $model->find($libraryId)
            ->update([
                'title' => $dto->title,
                'description' => $dto->description
            ]);
    }

    public function delete(int $libraryId): bool
    {
        $library = (new Library)
            ->newQuery()
            ->find($libraryId);

        // Удаление слов
        $deleteWords = $library->words()
            ->each(function ($elem) {
                $elem->examples()->each(fn($elem) => $elem->delete());
                $elem->delete();
            });

        // TODO: на сервисы переведи
        $deleteStatistic = (new WordsStatistics())
            ->newQuery()
            ->where('library_id', $libraryId)
            ->get()
            ->each(function ($elem) {
                $elem->delete();
            });

        // Удаление предложении
        $deleteSentences = $library->sentences()
            ->delete();

        return $library->newQuery()->find($libraryId)->delete();
    }
}
