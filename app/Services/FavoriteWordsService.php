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
     * Удалить избранное слово
    */
    public function removeFavorite(int $id): bool
    {
        return $this->getModel()
            ->where('id', '=', $id)
            ->delete();
    }
}
