<?php


namespace App\Repository;


use App\Models\Library;
use App\Models\Words;

/**
 * @method Words model()
 */
final class LibraryRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return Library::class;
    }

    public function getAllLibraries(int $userId): object
    {
        $columns = ['id', 'title', 'created_at'];

        return $this->model()
            ->newQuery()
            ->select($columns)
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

}
