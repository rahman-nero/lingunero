<?php


namespace App\Services;


use App\Modules\PracticeWords\PracticeWordFacade;

final class WordsService
{
    private PracticeWordFacade $wordFacade;

    public function __construct(PracticeWordFacade $wordFacade)
    {
        $this->wordFacade = $wordFacade;
    }

    public function calcPracticeWords(int $libraryId, array $words): int|bool
    {
        return $this->wordFacade->process(
            libraryId: $libraryId,
            words: $words
        );
    }

}
