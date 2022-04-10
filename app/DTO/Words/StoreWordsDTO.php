<?php


namespace App\DTO\Words;


final class StoreWordsDTO
{
    /**
     * Преобразование массива слов, в массива с словами-объектами типа WordDTO
     */
    public static function fromTo(array $words): array
    {
        $wordsDto = [];

        foreach ($words as $word) {
            $wordsDto[] = new WordDTO(
                trim($word['word']),
                trim($word['translation']),
                trim($word['description']),
            );
        }

        return $wordsDto;
    }

}
