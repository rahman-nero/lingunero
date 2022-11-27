<?php


namespace App\DTO\Sentences;


final class SentenceDTO
{
    public function __construct(
        public string $sentence,
        public string $translation,
    )
    {
    }
}
