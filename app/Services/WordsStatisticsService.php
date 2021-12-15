<?php


namespace App\Services;


use App\Models\WordsStatistics;

final class WordsStatisticsService
{
    public function create(int $libraryId, int $countWords, int $countFails, int $countSuccess): int|bool
    {
        $model = new WordsStatistics();
        $result = $model->newQuery()
            ->create([
                'library_id' => $libraryId,
                'count_words' => $countWords,
                'count_wrong' => $countFails,
                'count_true' => $countSuccess,
            ]);

        return $result->id;
    }
}
