<?php

namespace App\Services;

use App\DTO\Sentences\SentenceDTO;
use App\Models\Sentence;
use App\Modules\PracticeSentences\PracticeSentenceFacade;

final class SentencesService
{
    private PracticeSentenceFacade $sentenceFacade;

    public function __construct(PracticeSentenceFacade $sentenceFacade)
    {
        $this->sentenceFacade = $sentenceFacade;
    }


    public function create(int $libraryId, SentenceDTO $dto): int
    {
        $model = (new Sentence)->newQuery();
        $result = $model->create(
            [
                'library_id' => $libraryId,
                'sentence' => $dto->sentence,
                'translation' => $dto->translation,
            ]
        );

        return $result->id;
    }

    public function edit(int $id, SentenceDTO $dto): bool
    {
        $model = (new Sentence)->newQuery();

        return $model->find($id)
            ->update([
                'sentence' => $dto->sentence,
                'translation' => $dto->translation,
            ]);
    }


    public function calcPracticeSentences(int $libraryId, array $sentences): int|bool
    {
        return $this->sentenceFacade->process(
            libraryId: $libraryId,
            sentences: $sentences
        );
    }

    public function storeSentences(int $libraryId, array $data): bool
    {
        /** @var SentenceDTO $sentenceDTO */
        foreach ($data as $sentenceDTO) {
            $add = $this->create($libraryId, $sentenceDTO);
            if (!$add) {
                return false;
            }
        }
        return true;
    }

    public function importWords(int $libraryId, array $data)
    {
        /** @var SentenceDTO $dto */
        foreach ($data as $sentence) {

            $dto = new SentenceDTO(
                sentence: $sentence['sentence'],
                translation: $sentence['translation'],
            );

            $add = $this->create(libraryId: $libraryId, dto: $dto);
            if (!$add) {
                return false;
            }
        }
        return true;
    }


    // Обновление предложении
    public function editSentences(int $libraryId, array $data): bool
    {

        foreach ($data as $sentence) {
            $hasWord = Sentence::query()
                ->where('id', $sentence['id'])
                ->where('library_id', $libraryId)
                ->toBase()
                ->get();

            if (!$hasWord) {
                return false;
            }

            $sentenceDTO = new SentenceDTO(
                sentence: $sentence['sentence'],
                translation: $sentence['translation'],
            );
            $edit = $this->edit($sentence['id'], $sentenceDTO);

            if (!$edit) {
                return false;
            }
        }

        return true;
    }

    public function delete(int $wordId): bool
    {
        $model = (new Sentence)
            ->newQuery()
            ->find($wordId);

        return $model->delete();
    }
}
