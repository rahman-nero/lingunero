<?php


namespace App\Repository;


use App\Models\Words;
use Illuminate\Support\Collection;

/**
 * @method Words model()
 */
final class WordsRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return Words::class;
    }

    public function getWordsByLibraryId(int $libraryId): Collection
    {
        $columns = ['id', 'word', 'translation', 'description'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy('created_at')
            ->toBase()
            ->get();
    }

    public function getWordsByLibraryIdWithPaginate(int $libraryId, int $limit): object
    {
        $columns = ['id', 'word', 'translation', 'description'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy('created_at')
            ->toBase()
            ->paginate($limit);
    }

    public function isBelongsToLibrary(int $wordId, int $libraryId): bool
    {
        return $this->model()
            ->where('id', $wordId)
            ->where('library_id', $libraryId)
            ->toBase()
            ->get()
            ->isNotEmpty();
    }

}
