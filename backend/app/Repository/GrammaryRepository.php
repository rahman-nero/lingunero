<?php

namespace App\Repository;

use App\Models\Grammary;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Builder model()
 */
final class GrammaryRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return Grammary::class;
    }

    /**
     * Получение всех тем по грамматике с пагинацией
     */
    public function getAllWithPaginate(int $perPage = 10): LengthAwarePaginator
    {
        $columns = ['id', 'name', 'content', 'created_at', 'updated_at'];

        return $this->model()
            ->select($columns)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Получение темы по грамматике по ID
     */
    public function getById(int $id): ?Model
    {
        return $this->model()
            ->where('id', $id)
            ->first();
    }
}
