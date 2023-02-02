<?php

namespace App\Services;

use App\Models\FavoriteWords;
use Illuminate\Database\Eloquent\Builder;

final class FavoriteWordsService
{
    protected function getModel(): Builder
    {
        return FavoriteWords::query();
    }

    /**
     * Добавление слов в избранные
     */
    public function create(int $userId, int $wordId): bool
    {
        $result = $this->getModel()
            ->create([
                'word_id' => $wordId,
                'user_id' => $userId
            ]);

        return (bool)$result->id;
    }

    /**
     * Удалить избранное слово
     */
    public function removeFavorite(int $id): bool
    {
        return $this->getModel()
            ->where('id', '=', $id)
            ->delete();
    }
}
