<?php


namespace App\Modules\PracticeSentences\Processors;


use App\Modules\PracticeWords\Contracts\ProcessorContract;
use App\Repository\SentencesRepository;
use App\Repository\WordsRepository;
use App\Services\SentencesStatisticsService;
use App\Services\WordsStatisticsService;

final class EnglishWords implements ProcessorContract
{
    private int|bool $statisticId;

    private SentencesStatisticsService $statisticsService;
    private SentencesRepository $sentencesRepository;

    public function __construct(SentencesRepository        $sentencesRepository,
                                SentencesStatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
        $this->sentencesRepository = $sentencesRepository;
    }

    public function process(int $libraryId, array $sentences): bool
    {
        $statistic = [];

        $fails = 0;
        $success = 0;

        $dbSentences = $this->sentencesRepository->getSentencesByLibraryId($libraryId);

        if (!$this->validateDate($dbSentences->toArray(), $sentences)) {
            return false;
        }

        foreach ($sentences as $sentenceId => $sentence) {
            $currentSentence = $dbSentences
                ->where('id', $sentenceId)
                ->first();

            $correctlyAnswer = $currentSentence
                ->translation;


            if ($this->clearString($correctlyAnswer) === $this->clearString($sentence)) {
                $success++;

                $statistic[] = [
                    'sentence' => $currentSentence->sentence,
                    'answer' => $correctlyAnswer,
                    'is_right' => 1,
                    'user_answer' => $sentence
                ];
            } else {
                $fails++;

                $statistic[] = [
                    'sentence' => $currentSentence->sentence,
                    'answer' => $correctlyAnswer,
                    'is_right' => 0,
                    'user_answer' => $sentence
                ];
            }
        }


        return $this->saveStatistics($libraryId, $dbSentences->count(), $fails, $success, $statistic);
    }

    private function saveStatistics(int $libraryId, int $countSentences, int $countFails, int $countSuccess, array $result): bool
    {
        $id = $this->statisticsService->create(
            libraryId: $libraryId,
            countSentences: $countSentences,
            countFails: $countFails,
            countSuccess: $countSuccess,
            result: $result
        );

        if (!$id) {
            return false;
        }

        $this->statisticId = $id;
        return true;
    }

    private function validateDate(array $dbSentences, array $sentences)
    {
        $dbWordsIds = array_column($dbSentences, 'id');

        foreach ($sentences as $sentenceId => $sentence) {
            if (!in_array($sentenceId, $dbWordsIds)) {
                return false;
            }
        }

        return true;
    }

    private function clearString(?string $string): string
    {
        return strip_tags(
            mb_strtolower(trim($string))
        );
    }

    public function getId(): int|bool
    {
        return $this->statisticId;
    }
}
