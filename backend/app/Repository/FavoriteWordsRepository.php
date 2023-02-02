<?php

namespace App\Repository;

use App\Models\FavoriteWords;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder model()
 */
final class FavoriteWordsRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return FavoriteWords::class;
    }

    /**
     * Получение избранных слов пользователя
     */
    public function getUserFavoriteWords(int $userId): Collection
    {
        $columns = [
            'favorite_words.id as f_id',
            'word_id',
            'library_id',
            'word',
            'translation',
            'description',
            'favorite_words.created_at'
        ];

        $result = $this->model()
            ->select($columns)
            ->where('user_id', '=', $userId)
            ->join('words', 'word_id', '=', 'words.id')
            ->toBase()
            ->get();

        return $result;
    }

    /**
     * Получение id-избранного слова, по word_id и user_id
     */
    public function getUserFavoriteIdByWordId(int $userId, int $wordId): int|false
    {
        $result = $this->model()
            ->where('user_id', '=', $userId)
            ->where('word_id', '=', $wordId)
            ->limit(1)
            ->toBase()
            ->get();

        return $result->isNotEmpty() ? $result->first()->id : false;
    }

    /**
     * Является ли переданный id-избранного слова относящимся к пользователю
     */
    public function isUserFavoriteWord(int $id, int $userId): bool
    {
        return $this->model()
            ->select(['id'])
            ->where('id', '=', $id)
            ->where('user_id', '=', $userId)
            ->toBase()
            ->get()
            ->isNotEmpty();
    }

    /**
     * Является ли переданный id-слова относящимся к пользователю
     * Проверка происходит по id-слова, а не по id-избранного слова.
     */
    public function isUserFavoriteWordByWordId(int $wordId, int $userId): bool
    {
        return $this->model()
            ->select(['id'])
            ->where('word_id', '=', $wordId)
            ->where('user_id', '=', $userId)
            ->toBase()
            ->get()
            ->isNotEmpty();
    }
}
