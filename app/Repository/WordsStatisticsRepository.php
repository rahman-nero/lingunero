<?php


namespace App\Repository;


use App\Models\WordsStatistics;

/**
 * @method WordsStatistics model()
 */
final class WordsStatisticsRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return WordsStatistics::class;
    }

    public function findByIdAndLibraryId(int $statisticId, int $libraryId)
    {
        return $this->model()
            ->newQuery()
            ->where('id', $statisticId)
            ->where('library_id', $libraryId)
            ->limit(1)
            ->get();
    }
}
