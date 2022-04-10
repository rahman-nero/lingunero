<?php


namespace App\Repository;


use App\Models\SentencesPractice;
use App\Models\WordsStatistics;

/**
 * @method SentencesPractice model()
 */
final class SentencesStatisticsRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return SentencesPractice::class;
    }

    public function findByIdAndLibraryId(int $statisticId, int $libraryId)
    {
        return $this->model()
            ->where('id', $statisticId)
            ->where('library_id', $libraryId)
            ->limit(1)
            ->get();
    }
}
