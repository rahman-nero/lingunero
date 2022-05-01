<?php


namespace App\Services;


use App\DTO\Library\LibraryDTO;
use App\Models\Library;
use App\Models\Words;
use Illuminate\Database\Eloquent\Builder;

final class LibraryService
{

    protected function getModel(): Builder
    {
        return (new Library())->newQuery();
    }

    /**
     * Creating a new library
    */
    public function create(LibraryDTO $dto, int $userId): int
    {
        $result = $this->getModel()->create(
            [
                'user_id' => $userId,
                'title' => $dto->title,
                'description' => $dto->description
            ]
        );

        return $result->id;
    }

    /**
     * Edite selected library
    */
    public function edit(int $libraryId, LibraryDTO $dto): bool
    {
        return $this->getModel()->find($libraryId)
            ->update([
                'title' => $dto->title,
                'description' => $dto->description
            ]);
    }

    /**
     * Delete library with all relations of the other tables
    */
    public function delete(int $libraryId): bool
    {
        $library = $this->getModel()
            ->find($libraryId);

        // Удаление слов
        $library->words()
            ->each(function (Words $elem) {
                // Удаляем примеры слов
                $elem->examples()->delete();

                // Удаляем само слов
                $elem->delete();
            });

        // TODO: на сервисы переведи
        // Удаление статистики тестов на слова
        $library->wordsStatistics()
            ->delete();

        // Удаление предложении
        $library->sentences()
            ->delete();

        return $library->delete();
    }


    /**
     * Remove all words of library
     * @param int $libraryId
     * @return bool
     */
    public function removeAllLibraryWords(int $libraryId): bool
    {
        // Remove words with examples
        $this->getModel()
            ->find($libraryId)
            ->words()
            ->each(function (Words $elem) {
                // Remove word's examples
                $elem->examples()->delete();

                // Remove current word
                $elem->delete();
            });

        // Remove statistic of words
        $this->getModel()
            ->find($libraryId)
            ->wordsStatistics()
            ->delete();

        return true;
    }
}
