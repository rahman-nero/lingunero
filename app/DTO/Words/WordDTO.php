<?php


namespace App\DTO\Words;


final class WordDTO
{
    public function __construct(
        public string $word,
        public string $translation,
        public ?string $description,
    )
    {
    }

}
