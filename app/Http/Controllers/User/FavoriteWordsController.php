<?php

namespace App\Http\Controllers\User;

use App\Repository\FavoriteWordsRepository;
use App\Services\FavoriteWordsService;
use Illuminate\Support\Facades\Auth;

class FavoriteWordsController
{
    private FavoriteWordsRepository $repository;
    private FavoriteWordsService $service;

    public function __construct(
        FavoriteWordsRepository $repository,
        FavoriteWordsService $service
    )
    {
        $this->repository = $repository;
        $this->service = $service;
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

    /**
     * Добавление слова в избранные
     * */
    public function add()
    {

    }

    /**
     * Удаление избранного слова
    */
    public function delete(int $id)
    {
        $userId = Auth::id();

        if (!$this->repository->isUserFavoriteWord($id, $userId)) {
            return back()
                    ->withErrors(['message' => 'Невозможно удалить не существующее избранное слово']);
        }

        $result = $this->service->removeFavorite($id);

        if (!$result) {
            return back()
                ->withErrors(['message' => 'Произошла ошибка во время удаления, пожалуйста, обратитесь к поддержке']);
        }

        return back()
            ->with('success', 'Избранное слово успешно удалено');
    }
}
