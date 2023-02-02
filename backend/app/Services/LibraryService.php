<?php

namespace App\Services;

use App\DTO\Library\LibraryDTO;
use App\Models\FavoriteWords;
use App\Models\Library;
use App\Models\Words;
use Exception;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Log\LogManager;
use Illuminate\Support\Facades\DB;

final class LibraryService
{
    private ConnectionInterface $connection;
    private LogManager $log;

    public function __construct(ConnectionInterface $connection, LogManager $log)
    {
        $this->connection = $connection;
        $this->log = $log;
    }

    protected function getModel(): Builder
    {
        return Library::query();
    }

    /**
     * Создание новой библиотеки
     */
    public function create(LibraryDTO $dto, int $userId): int
    {
        $result = $this->getModel()
            ->create([
                'user_id' => $userId,
                'title' => $dto->title,
                'description' => $dto->description
            ]);

        return $result->id;
    }

    /**
     * Редактирование библиотеки
     */
    public function edit(int $libraryId, LibraryDTO $dto): bool
    {
        return $this->getModel()
            ->find($libraryId)
            ->update([
                'title' => $dto->title,
                'description' => $dto->description
            ]);
    }

    /**
     * Удаление библиотеки с удалением всех остальных связей
     * Удаление слов
     * Удаление пример слов
     * Удаление статистик слов
     * Удаление предложений
     * Удаление статистик предложений
     */
    public function delete(int $libraryId): bool
    {
        $library = $this->getModel()
            ->find($libraryId);

        try {
            $this->connection->beginTransaction();

            // Удаление слов
            $library->words()
                ->each(function (Words $elem) {
                    // Удаляем примеры слов
                    $elem->examples()->delete();

                    // Удаление слова из избранных
                    if ($elem->isFavorite()) {
                        FavoriteWords::query()
                            ->where('word_id', '=', $elem->id)
                            ->delete();
                    }

                    // Удаляем само слов
                    $elem->delete();
                });

            // Удаление статистики тестов на слова
            $library->wordsStatistics()
                ->delete();

            // Удаление предложении
            $library->sentences()
                ->delete();

            // Удаление статистик предложении
            $library->sentencesStatistics()
                ->delete();

            // Удаление библиотеки
            $result = $library->delete();

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollBack();
            $this->log->error(
                sprintf('Произошла ошибка во время удаления библиотеки: %s', $e->getMessage())
            );

            return false;
        }

        return $result;
    }

    /**
     * Удаление всех слов с библиотеки
     */
    public function removeAllLibraryWords(int $libraryId): bool
    {
        // Удаление всех слов с удалением примеров
        $this->getModel()
            ->find($libraryId)
            ->words()
            ->each(function (Words $elem) {
                // Удаление примеров слов
                $elem->examples()->delete();

                // Удаление слова из избранных
                if ($elem->isFavorite()) {
                    FavoriteWords::query()
                        ->where('word_id', '=', $elem->id)
                        ->delete();
                }

                // Удаление самого слова
                $elem->delete();
            });

        // Удаление статистики слов
        $this->getModel()
            ->find($libraryId)
            ->wordsStatistics()
            ->delete();

        return true;
    }
}
