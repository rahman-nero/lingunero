<?php


namespace App\Modules\PracticeWords\Processors;


use App\Modules\PracticeWords\Contracts\ProcessorContract;
use App\Repository\WordsRepository;
use App\Services\WordsStatisticsService;

final class EnglishWords implements ProcessorContract
{
    private int|bool $statisticId;

    private WordsRepository $wordsRepository;
    private WordsStatisticsService $statisticsService;

    public function __construct(WordsRepository $wordsRepository,
                                WordsStatisticsService $statisticsService)
    {
        $this->wordsRepository = $wordsRepository;
        $this->statisticsService = $statisticsService;
    }

    public function process(int $libraryId, array $words): bool
    {
        $fails = 0;
        $success = 0;

        $dbWords = $this->wordsRepository->getWordsByLibraryId($libraryId);

        if (!$this->validateDate($dbWords->toArray(), $words)) {
            return false;
        }

        foreach ($words as $wordId => $word) {
            $currentWord = $dbWords->where('id', $wordId)
                ->first()
                ->translation;

            if ($this->clearString($currentWord) === $this->clearString($word)) {
                $success++;
            } else {
                $fails++;
            }
        }


        return $this->saveStatistics($libraryId, $dbWords->count(), $fails, $success);
    }

    private function saveStatistics(int $libraryId, int $countWords, int $countFails, int $countSuccess): bool
    {
        $id = $this->statisticsService->create(
            libraryId: $libraryId,
            countWords: $countWords,
            countFails: $countFails,
            countSuccess: $countSuccess
        );

        if (!$id) {
            return false;
        }

        $this->statisticId = $id;
        return true;
    }

    private function validateDate(array $dbWords, array $words)
    {
        $dbWordsIds = array_column($dbWords, 'id');

        foreach ($words as $wordId => $word) {
            if (!in_array($wordId, $dbWordsIds)) {
                return false;
            }
        }

        return true;
    }

    private function clearString(string $string): string
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
