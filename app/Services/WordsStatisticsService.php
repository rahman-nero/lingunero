<?php

namespace App\Services;

use App\Models\WordsStatistics;
use Illuminate\Database\Eloquent\Builder;

final class WordsStatisticsService
{
    /**
     * Создание статистики для слов
    */
    public function create(int $libraryId, int $countWords, int $countFails, int $countSuccess, array $result): int|bool
    {
        $result = $this->getModel()
            ->create([
                'library_id' => $libraryId,
                'count_words' => $countWords,
                'count_wrong' => $countFails,
                'count_true' => $countSuccess,
                'result' => $result
            ]);

        return $result->id;
    }

    protected function getModel(): Builder
    {
        return WordsStatistics::query();
    }
}
