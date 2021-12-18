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

//    public function storeWords(int $libraryId, array $data): bool
//    {
//        /** @var WordDTO $wordDto */
//        foreach ($data as $wordDto) {
//            $add = $this->create($libraryId, $wordDto);
//            if (!$add) {
//                return false;
//            }
//        }
//        return true;
//    }


    // Обновление слов
//    public function editWords(int $libraryId, array $data): bool
//    {
//
//        foreach ($data as $word) {
//            $hasWord = Words::query()
//                ->where('id', $word['id'])
//                ->where('library_id', $libraryId)
//                ->toBase()
//                ->get();
//
//            if (!$hasWord) {
//                return false;
//            }
//
//            $wordDto = new WordDTO(
//                word: $word['word'],
//                translation: $word['translation'],
//                description: $word['description']
//            );
//            $edit = $this->edit($word['id'], $wordDto);
//
//            if (!$edit) {
//                return false;
//            }
//        }
//
//        return true;
//    }
//
//    public function delete(int $wordId): bool
//    {
//        $model = (new Words)
//            ->newQuery()
//            ->find($wordId);
//
//        return $model->delete();
//    }
}
