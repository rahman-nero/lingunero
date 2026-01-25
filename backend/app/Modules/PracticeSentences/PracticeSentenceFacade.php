<?php


namespace App\Modules\PracticeSentences;


use App\Modules\PracticeSentences\Processors\EnglishWords;

final class PracticeSentenceFacade
{
    private EnglishWords $processor;

    public function __construct(EnglishWords $processor)
    {
        $this->processor = $processor;
    }

    public function process(int $libraryId, array $sentences): int|bool
    {
        $result = $this->processor
            ->process(
                libraryId: $libraryId,
                sentences: $sentences
            );

        if (!$result) {
            return false;
        }

        return $this->processor->getId();
    }
}
