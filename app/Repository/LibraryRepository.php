<?php

namespace App\Repository;

use App\Models\Library;
use App\Models\Words;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @method Words model()
 */
final class LibraryRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return Library::class;
    }

    /**
     * Получение всех библиотек по id-пользователя.
     * Получение происходит с пагинацией
    */
    public function getAllLibrariesWithPaginate(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        $columns = ['id', 'title', 'created_at'];

        return $this->model()
            ->newQuery()
            ->select($columns)
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Получение данных о библиотеке
    */
    public function getLibrary(int $libraryId): object
    {
        $columns = ['id', 'title', 'description', 'created_at'];

        return $this->model()
            ->newQuery()
            ->select($columns)
            ->where('id', $libraryId)
            ->limit(1)
            ->get();
    }

    /**
     * Проверка, созданна ли эта библиотека пользователем
    */
    public function isUserLibrary(int $libraryId, int $userId): bool
    {
        return $this->model()
            ->select(['id'])
            ->where('id', '=', $libraryId)
            ->where('user_id', '=', $userId)
            ->toBase()
            ->get()
            ->isNotEmpty();
    }
}
