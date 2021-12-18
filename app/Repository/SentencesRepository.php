<?php


namespace App\Repository;


use App\Models\Sentence;
use Illuminate\Support\Collection;

/**
 * @method Sentence model()
 */
final class SentencesRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return Sentence::class;
    }

    public function getSentencesByLibraryId(int $libraryId): Collection
    {
        $columns = ['id', 'sentence', 'translation'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy('created_at')
            ->toBase()
            ->get();
    }

    public function getSentencesByLibraryIdWithPaginate(int $libraryId, int $limit): object
    {
        $columns = ['id', 'sentence', 'translation'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy('created_at')
            ->toBase()
            ->paginate($limit);
    }

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
