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

    public function getLibrary(int $libraryId, int $userId): object
    {
        $columns = ['id', 'title', 'description', 'created_at'];

        return $this->model()
            ->newQuery()
            ->select($columns)
            ->where('id', $libraryId)
            ->where('user_id', $userId)
            ->limit(1)
            ->get();
    }
}
