<?php

namespace App\Repository;

use App\Models\Sentence;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder model()
 */
final class SentencesRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return Sentence::class;
    }

    /**
     * Получение всех предложений из библиотеки
    */
    public function getSentencesByLibraryId(int $libraryId, $orderBy = 'created_at'): Collection
    {
        $columns = ['id', 'sentence', 'translation'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy($orderBy)
            ->toBase()
            ->get();
    }

    /**
     * Получение всех предложений из библиотеки с помощью пагинации
    */
    public function getSentencesByLibraryIdWithPaginate(int $libraryId, int $limit): object
    {
        $columns = ['id', 'sentence', 'translation'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
//            ->orderBy('created_at')
            ->toBase()
            ->paginate($limit);
    }

    /**
     * Проверка, относится ли предложение к библиотеке
    */
    public function isBelongsToLibrary(int $sentenceId, int $libraryId): bool
    {
        return $this->model()
            ->where('id', $sentenceId)
            ->where('library_id', $libraryId)
            ->toBase()
            ->get()
            ->isNotEmpty();
    }

}
