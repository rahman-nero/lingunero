<?php

namespace App\Services;

use App\Models\FavoriteWords;

final class FavoriteWordsService
{
    protected function getModel(): object
    {
        return FavoriteWords::query();
    }

}
