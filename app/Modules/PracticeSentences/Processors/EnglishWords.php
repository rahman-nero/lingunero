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

    public function __construct(SentencesRepository $sentencesRepository,
                                SentencesStatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
        $this->sentencesRepository = $sentencesRepository;
    }

    public function process(int $libraryId, array $sentences): bool
    {
        $fails = 0;
        $success = 0;

        $dbSentences = $this->sentencesRepository->getSentencesByLibraryId($libraryId);

        if (!$this->validateDate($dbSentences->toArray(), $sentences)) {
            return false;
        }

        foreach ($sentences as $sentenceId => $sentence) {
            $currentSentence = $dbSentences->where('id', $sentenceId)
                ->first()
                ->translation;

            if ($this->clearString($currentSentence) === $this->clearString($sentence)) {
                $success++;
            } else {
                $fails++;
            }
        }


        return $this->saveStatistics($libraryId, $dbSentences->count(), $fails, $success);
    }

    private function saveStatistics(int $libraryId, int $countSentences, int $countFails, int $countSuccess): bool
    {
        $id = $this->statisticsService->create(
            libraryId: $libraryId,
            countSentences: $countSentences,
            countFails: $countFails,
            countSuccess: $countSuccess
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
