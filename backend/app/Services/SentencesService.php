<?php

namespace App\Services;

use App\DTO\Sentences\SentenceDTO;
use App\Models\Sentence;
use App\Modules\PracticeSentences\PracticeSentenceFacade;
use Exception;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Log\LogManager;
use RuntimeException;

final class SentencesService
{
    private PracticeSentenceFacade $sentenceFacade;
    private ConnectionInterface $connection;
    private LogManager $log;

    public function __construct(
        ConnectionInterface    $connection,
        LogManager             $logManager,
        PracticeSentenceFacade $sentenceFacade
    )
    {
        $this->sentenceFacade = $sentenceFacade;
        $this->connection = $connection;
        $this->log = $logManager;
    }

    protected function getModel(): Builder
    {
        return Sentence::query();
    }

    /**
     * Добавить новое предложение в библиотеку
     */
    public function create(int $libraryId, SentenceDTO $dto): int
    {
        $result = $this->getModel()->create([
            'library_id' => $libraryId,
            'sentence' => $dto->sentence,
            'translation' => $dto->translation,
        ]);

        return $result->id;
    }

    /**
     * Редактирование предложения
     */
    public function edit(int $id, SentenceDTO $dto): bool
    {
        return $this->getModel()->find($id)
            ->update([
                'sentence' => $dto->sentence,
                'translation' => $dto->translation,
            ]);
    }

    /**
     * Множественно обновление предложений
     */
    public function editSentences(int $libraryId, array $data): bool
    {
        try {
            $this->connection->beginTransaction();

            foreach ($data as $sentence) {
                $hasWord = $this->getModel()
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
                    throw new RuntimeException();
                }
            }

            $this->connection->commit();
        } catch (Exception) {
            $this->connection->rollBack();
            $this->log->error(
                'Ошибка во время редактирования предложения, library_id:' . $libraryId,
                (array)$sentenceDTO
            );

            return false;
        }

        return true;
    }

    /**
     * Множественное добавление предложений
     */
    public function storeSentences(int $libraryId, array $data): bool
    {
        try {
            $this->connection->beginTransaction();

            /** @var SentenceDTO $sentenceDTO */
            foreach ($data as $sentenceDTO) {
                $add = $this->create($libraryId, $sentenceDTO);
                if (!$add) {
                    throw new RuntimeException();
                }
            }

            $this->connection->commit();
        } catch (Exception) {
            $this->connection->rollBack();
            $this->log->error(
                'Ошибка во время добавления предложения, library_id:' . $libraryId,
                (array)$sentenceDTO
            );

            return false;
        }

        return true;
    }

    /**
     * Импортирование предложений
     */
    public function importSentences(int $libraryId, array $data): bool
    {
        try {
            $this->connection->beginTransaction();

            /** @var SentenceDTO $dto */
            foreach ($data as $sentence) {
                $dto = new SentenceDTO(
                    sentence: $sentence['sentence'],
                    translation: $sentence['translation'],
                );

                $add = $this->create(libraryId: $libraryId, dto: $dto);
                if (!$add) {
                    throw new RuntimeException();
                }
            }

            $this->connection->commit();
        } catch (Exception) {
            $this->connection->rollBack();
            $this->log->error(
                'Ошибка во время импорта предложения, library_id:' . $libraryId,
                (array)$dto
            );

            return false;
        }

        return true;
    }

    /**
     * Обработка отправленного теста пользователем
     */
    public function calcPracticeSentences(int $libraryId, array $sentences): int|bool
    {
        return $this->sentenceFacade->process(
            libraryId: $libraryId,
            sentences: $sentences
        );
    }

    /**
     * Удаление предложения
     */
    public function delete(int $wordId): bool
    {
        return $this->getModel()
            ->find($wordId)
            ->delete();
    }
}
