<?php


namespace App\DTO\Sentences;


final class StoreSentencesDTO
{
    /**
     * Преобразование массива слов, в массива с словами-объектами типа WordDTO
     */
    public static function fromTo(array $sentences): array
    {
        $sentencesDto = [];

        foreach ($sentences as $sentence) {
            $sentencesDto[] = new SentenceDTO(
                sentence: $sentence['sentence'],
                translation: $sentence['translation'],
            );
        }

        return $sentencesDto;
    }

}
