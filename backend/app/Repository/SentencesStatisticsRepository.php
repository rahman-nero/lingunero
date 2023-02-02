<?php

namespace App\Repository;

use App\Models\SentencesPractice;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder model()
 */
final class SentencesStatisticsRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return SentencesPractice::class;
    }

    /**
     * Получение статистики выполненного теста
     */
    public function findByIdAndLibraryId(int $statisticId, int $libraryId)
    {
        return $this->model()
            ->where('id', $statisticId)
            ->where('library_id', $libraryId)
            ->limit(1)
            ->get();
    }
}
