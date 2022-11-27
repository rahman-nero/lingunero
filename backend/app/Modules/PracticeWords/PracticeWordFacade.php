<?php


namespace App\Modules\PracticeWords;


use App\Modules\PracticeWords\Processors\EnglishWords;

final class PracticeWordFacade
{
    private EnglishWords $processor;

    public function __construct(EnglishWords $processor)
    {
        $this->processor = $processor;
    }

    public function process(int $libraryId, array $words): int|bool
    {
        $result = $this->processor
            ->process($libraryId, $words);

        if (!$result) {
            return false;
        }

        return $this->processor->getId();
    }
}
