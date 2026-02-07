<?php

namespace App\Repository;

use App\Models\GrammaryPractice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Builder model()
 */
final class GrammaryPracticeRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return GrammaryPractice::class;
    }

    /**
     * Получение всех практик по теме грамматики (grammary_id).
     *
     * @param int $grammaryId Идентификатор темы грамматики
     * @return Collection<int, GrammaryPractice>
     */
    public function getByGrammaryId(int $grammaryId): Collection
    {
        return $this->model()
            ->where('grammary_id', $grammaryId)
            ->orderBy('union_id')
            ->orderBy('id')
            ->get();
    }
}
