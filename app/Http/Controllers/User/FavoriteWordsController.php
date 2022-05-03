<?php

namespace App\Http\Controllers\User;

use App\Repository\FavoriteWordsRepository;
use App\Repository\WordsRepository;
use App\Services\FavoriteWordsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FavoriteWordsController
{
    private FavoriteWordsRepository $repository;
    private FavoriteWordsService $service;
    private WordsRepository $wordsRepository;

    public function __construct(
        FavoriteWordsRepository $repository,
        FavoriteWordsService $service,
        WordsRepository $wordsRepository,
    ) {
        $this->repository = $repository;
        $this->service = $service;
        $this->wordsRepository = $wordsRepository;
    }

    /**
     * Получение всех избранных слов
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
    public function add(int $wordId)
    {
        $userId = Auth::id();

        // Проверка есть ли это слово в библиотеках пользователя
        if (!$this->wordsRepository->isUserWord(wordId: $wordId, userId: $userId)) {
            return new JsonResponse(['code' => 404, 'message' => 'Невозможно добавить не существующее слово'], 404);
        }

        // Проверка есть ли это слово в избранных
        if ($this->repository->isUserFavoriteWordByWordId(wordId: $wordId, userId: $userId)) {
            return new JsonResponse(['code' => 200, 'message' => 'Слово уже добавлено в избранные'], 200);
        }

        $result = $this->service->create(wordId: $wordId, userId: $userId);

        if (!$result) {
            return new JsonResponse([
                'code' => 500,
                'message' => 'Ошибка при добавлений слова в избранные, пожалуйста, обратитесь к службу поддержки'
            ], 500);
        }

        return new JsonResponse(['code' => 200, 'message' => 'Слово успешно добавлено в избранные']);
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

    /**
     * Удаление избранного слова (для ajax запроса)
     */
    public function deleteAjax(int $wordId)
    {
        $userId = Auth::id();

        if (!$this->repository->isUserFavoriteWordByWordId($wordId, $userId)) {
            return new JsonResponse(['code' => 404, 'message' => 'Невозможно удалить не существующее избранное слово'], 404);
        }
        // Id-избранного слова
        $id = $this->repository->getUserFavoriteIdByWordId($userId, $wordId);

        $result = $this->service->removeFavorite($id);

        if (!$result) {
            return new JsonResponse(['code' => 500, 'message' => 'Произошла ошибка во время удаления, пожалуйста, обратитесь к поддержке'], 500);
        }

        return new JsonResponse(['code' => 200, 'message' => 'Избранное слово успешно удалено'], 200);
    }
}
