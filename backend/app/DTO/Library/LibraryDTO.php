<?php


namespace App\DTO\Library;


final class LibraryDTO
{
    public function __construct(
        public string  $title,
        public ?string $description,
    )
    {
    }
}
