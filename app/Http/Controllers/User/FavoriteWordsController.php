<?php

namespace App\Http\Controllers\User;

use App\Repository\FavoriteWordsRepository;
use Illuminate\Support\Facades\Auth;

class FavoriteWordsController
{
    private FavoriteWordsRepository $repository;

    public function __construct(FavoriteWordsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получение всех
    */
    public function index()
    {
        $userId = Auth::id();

        $favoriteWords = $this->repository->getUserFavoriteWords($userId);

        return view('site.user.favorite.index', compact('favoriteWords'));
    }
}
