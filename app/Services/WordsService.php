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
                'description' => $dto->description,
            ]
        );

        return $result->id;
    }

    public function edit(int $id, WordDTO $dto): bool
    {
        $model = (new Words)->newQuery();

        return $model->find($id)
            ->update([
                'word' => $dto->word,
                'translation' => $dto->translation,
                'description' => $dto->description,
            ]);
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

    public function importWords(int $libraryId, array $data)
    {
        /** @var WordDTO $wordDto */
        foreach ($data as $word) {

            $dto = new WordDTO(
                word: $word['word'],
                translation: $word['translation'],
                description: null
            );

            $add = $this->create($libraryId, $dto);
            if (!$add) {
                return false;
            }
        }
        return true;
    }


    // Обновление слов
    public function editWords(int $libraryId, array $data): bool
    {

        foreach ($data as $word) {
            $hasWord = Words::query()
                ->where('id', $word['id'])
                ->where('library_id', $libraryId)
                ->toBase()
                ->get();

            if (!$hasWord) {
                return false;
            }

            $wordDto = new WordDTO(
                word: $word['word'],
                translation: $word['translation'],
                description: $word['description']
            );
            $edit = $this->edit($word['id'], $wordDto);

            if (!$edit) {
                return false;
            }
        }

        return true;
    }

    public function delete(int $wordId): bool
    {
        $model = (new Words)
            ->newQuery()
            ->find($wordId);

        return $model->delete();
    }
}
