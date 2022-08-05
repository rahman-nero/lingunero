<?php

namespace App\Services;

use App\Models\SentencesPractice;
use Illuminate\Database\Eloquent\Builder;

final class SentencesStatisticsService
{
    /**
     * Создание статистики для теста
     * */
    public function create(int $libraryId, int $countSentences, int $countFails, int $countSuccess, array $result): int|bool
    {
        $insert = $this->getModel()
            ->create([
                'library_id' => $libraryId,
                'count_sentences' => $countSentences,
                'count_wrong' => $countFails,
                'result' => $result,
                'count_true' => $countSuccess,
            ]);

        return $insert->id;
    }

    protected function getModel(): Builder
    {
        return SentencesPractice::query();
    }

}
