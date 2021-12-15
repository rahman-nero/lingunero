<?php


namespace App\Http\Controllers\Library\Words;


use App\DTO\Words\StoreWordsDTO;
use App\Http\Requests\Words\StoreWordsRequest;
use App\Repository\LibraryRepository;
use App\Repository\WordsRepository;
use App\Services\WordsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

final class ManageController
{
    private WordsService $wordsService;
    private WordsRepository $wordsRepository;
    private LibraryRepository $libraryRepository;

    public function __construct(WordsRepository $wordsRepository,
                                LibraryRepository $libraryRepository,
                                WordsService $wordsService)
    {

        $this->wordsRepository = $wordsRepository;
        $this->libraryRepository = $libraryRepository;
        $this->wordsService = $wordsService;
    }

    // Страница редактирование слов
    public function edit($libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }
        $userId = Auth::id();

        $library = $this->libraryRepository->getLibrary($libraryId, $userId);
        $words = $this->wordsRepository->getWordsByLibraryIdWithPaginate($libraryId, 20);

        return view('site.word.edit', compact('libraryId', 'library', 'words'));
    }


    public function editStore($libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

    }

    // Страница Добавление слов
    public function add($libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }
        $userId = Auth::id();

        $library = $this->libraryRepository->getLibrary($libraryId, $userId);
        $words = $this->wordsRepository->getWordsByLibraryId($libraryId);

        return view('site.word.add', compact('library', 'libraryId', 'words'));
    }


    public function addStore(StoreWordsRequest $request, $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $data = StoreWordsDTO::fromTo($request['words']);

        $result = $this->wordsService->storeWords($libraryId, $data);

        if (!$result) {
            throw new BadRequestHttpException();
        }

        return 'Ok';
    }

    public function deleteWord(int $libraryId, int $wordId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        if (!$this->wordsRepository->isBelongsToLibrary(wordId: $wordId, libraryId: $libraryId)) {
            throw new NotFoundHttpException();
        }

        $result = $this->wordsService->delete($wordId);

        if (!$result) {
            throw new ServiceUnavailableHttpException();
        }

        return 'Ok';
    }
}
