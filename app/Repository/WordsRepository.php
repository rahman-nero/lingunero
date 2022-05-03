<?php


namespace App\Repository;


use App\Models\Library;
use App\Models\Words;
use Illuminate\Support\Collection;

/**
 * @method Words model()
 */
final class WordsRepository extends CoreRepository
{
    private LibraryRepository $libraryRepository;

    public function __construct(LibraryRepository $libraryRepository)
    {
        parent::__construct();
        $this->libraryRepository = $libraryRepository;
    }

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

    public function getWordsByLibraryIdWithPaginate(int $libraryId, int $perPage): object
    {
        $columns = ['id', 'word', 'translation', 'description'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy('created_at')
            ->paginate($perPage);
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

    /**
     * Принадлежит ли это слово пользователю, т.е имеется ли это слово в библиотеках пользователя
    */
    public function isUserWord(int $userId, int $wordId): bool
    {
        $word = $this->model()->find($wordId);

        if (!$word) {
            return false;
        }

        return $this->libraryRepository->isUserLibrary($word->library_id, $userId);
    }

}
