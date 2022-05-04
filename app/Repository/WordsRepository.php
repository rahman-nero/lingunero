<?php

namespace App\Repository;

use App\Models\Words;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder model()
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

    /**
     * Получение всех слов из библиотеки
     * Возвращается коллекция с stdClass
    */
    public function getWordsByLibraryIdWithoutModel(int $libraryId): Collection
    {
        $columns = ['id', 'word', 'translation', 'description'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy('created_at')
            ->toBase()
            ->get();
    }

    /**
     * Получение всех слов из библиотеки
     * Возвращается коллекция с моделями
     */
    public function getWordsByLibraryId(int $libraryId): Collection
    {
        $columns = ['id', 'word', 'translation', 'description'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy('created_at')
            ->get();
    }


    /**
     * Получение всех слов из библиотеки с помощью пагинации
    */
    public function getWordsByLibraryIdWithPaginate(int $libraryId, int $perPage): object
    {
        $columns = ['id', 'word', 'translation', 'description'];

        return $this->model()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy('created_at')
            ->paginate($perPage);
    }

    /**
     * Является ли это слово относящимся к указанной библиотеке
    */
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
