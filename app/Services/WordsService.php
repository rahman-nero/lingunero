<?php

namespace App\Services;

use App\DTO\Words\WordDTO;
use App\Models\Words;
use App\Modules\PracticeWords\PracticeWordFacade;
use Exception;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Log\LogManager;
use RuntimeException;

final class WordsService
{
    private PracticeWordFacade $wordFacade;
    private ConnectionInterface $connection;
    private LogManager $log;

    public function __construct(
        ConnectionInterface $connection,
        LogManager          $log,
        PracticeWordFacade  $wordFacade
    ) {
        $this->connection = $connection;
        $this->log = $log;
        $this->wordFacade = $wordFacade;
    }

    protected function getModel()
    {
        return Words::query();
    }

    /**
     * Создание нового слова
     */
    public function create(int $libraryId, WordDTO $dto): int
    {
        $result = $this->getModel()->create([
            'library_id' => $libraryId,
            'word' => $dto->word,
            'translation' => $dto->translation,
            'description' => $dto->description,
        ]);

        return $result->id;
    }

    /**
     * Редактирование слова
     */
    public function edit(int $id, WordDTO $dto): bool
    {
        $model = $this->getModel();

        return $model->find($id)
            ->update([
                'word' => $dto->word,
                'translation' => $dto->translation,
                'description' => $dto->description,
            ]);
    }

    /**
     * Обработка теста по словам
     */
    public function calcPracticeWords(int $libraryId, array $words): int|bool
    {
        return $this->wordFacade->process(
            libraryId: $libraryId,
            words: $words
        );
    }

    /**
     * Множественное добавление слов
     */
    public function storeWords(int $libraryId, array $data): bool
    {
        try {
            $this->connection->beginTransaction();

            /** @var WordDTO $wordDto */
            foreach ($data as $wordDto) {
                $add = $this->create($libraryId, $wordDto);
                if (!$add) {
                    throw new RuntimeException();
                }
            }

            $this->connection->commit();
        } catch (Exception) {
            $this->connection->rollback();
            $this->log->warning(
                'Ошибка во время добавления слова в библиотеку, library_id:' . $libraryId,
                (array)$wordDto
            );

            return false;
        }

        return true;
    }

    /**
     * Импортирование слов в библиотеку
     */
    public function importWords(int $libraryId, array $data): bool
    {
        try {
            $this->connection->beginTransaction();

            /** @var WordDTO $dto */
            foreach ($data as $word) {
                $dto = new WordDTO(
                    word: $word['word'],
                    translation: $word['translation'],
                    description: null
                );

                $add = $this->create($libraryId, $dto);
                if (!$add) {
                    throw new RuntimeException();
                }
            }

            $this->connection->commit();
        } catch (Exception) {
            $this->connection->rollback();
            $this->log->warning(
                'Ошибка во время импортирования слова в библиотеку, library_id:' . $libraryId,
                (array)$dto
            );

            return false;
        }

        return true;
    }


    /**
     * Множественное редактирование слов
    */
    public function editWords(int $libraryId, array $data): bool
    {
        try {
            $this->connection->beginTransaction();

            foreach ($data as $word) {
                $hasWord = $this->getModel()
                    ->where('id', '=', $word['id'])
                    ->where('library_id', '=', $libraryId)
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
                    throw new RuntimeException();
                }
            }

            $this->connection->commit();
        } catch (Exception) {
            $this->connection->rollback();
            $this->log->warning(
                'Ошибка во время множественного редактирования слов в библиотеке, library_id:' . $libraryId,
                (array)$wordDto
            );

            return false;
        }

        return true;
    }

    /**
     * Удаление слова
    */
    public function delete(int $wordId): bool
    {
        return $this->getModel()
            ->find($wordId)
            ->delete();
    }
}
