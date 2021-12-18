<?php


namespace App\Services;


use App\Models\SentencesPractice;

final class SentencesStatisticsService
{
    public function create(int $libraryId, int $countSentences, int $countFails, int $countSuccess): int|bool
    {
        $result = (new SentencesPractice())
            ->newQuery()
            ->create([
                'library_id' => $libraryId,
                'count_sentences' => $countSentences,
                'count_wrong' => $countFails,
                'count_true' => $countSuccess,
            ]);

        return $result->id;
    }

}
