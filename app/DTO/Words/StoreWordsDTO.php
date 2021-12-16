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
                $word['word'],
                $word['translation'],
                $word['description'],
            );
        }

        return $wordsDto;
    }

}
