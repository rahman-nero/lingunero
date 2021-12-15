<?php


namespace App\Services;


use App\DTO\Words\WordDTO;
use App\Models\Words;
use App\Modules\PracticeWords\PracticeWordFacade;

final class WordsService
{
    private PracticeWordFacade $wordFacade;

    public function __construct(PracticeWordFacade $wordFacade)
    {
        $this->wordFacade = $wordFacade;
    }

    protected function getModel(): string
    {
        return Words::class;
    }

    public function create(int $libraryId, WordDTO $dto): int
    {
        $model = (new Words)->newQuery();
        $result = $model->create(
            [
                'library_id' => $libraryId,
                'word' => $dto->word,
                'translation' => $dto->translation,
                'description' => $dto->description
            ]
        );

        return $result->id;
    }


    public function calcPracticeWords(int $libraryId, array $words): int|bool
    {
        return $this->wordFacade->process(
            libraryId: $libraryId,
            words: $words
        );
    }

    public function storeWords(int $libraryId, array $data): bool
    {
        /** @var WordDTO $wordDto */
        foreach ($data as $wordDto) {
            $add = $this->create($libraryId, $wordDto);
            if (!$add) {
                return false;
            }
        }
        return true;
    }
}
