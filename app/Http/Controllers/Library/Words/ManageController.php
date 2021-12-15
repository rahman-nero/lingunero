<?php


namespace App\Http\Controllers\Library\Words;


use App\Repository\LibraryRepository;
use App\Repository\WordsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

final class ManageController
{
    private WordsRepository $wordsRepository;
    private LibraryRepository $libraryRepository;

    public function __construct(WordsRepository $wordsRepository,
                                LibraryRepository $libraryRepository)
    {

        $this->wordsRepository = $wordsRepository;
        $this->libraryRepository = $libraryRepository;
    }

    // Страница редактирование слов
    public function edit($libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }
        $userId = Auth::id();

        $library = $this->libraryRepository->getLibrary($libraryId, $userId);
        $words = $this->wordsRepository->getWordsByLibraryId($libraryId);

        return view('site.word.edit', [$library, $words]);
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


    public function addStore(Request $request, $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        dd($request);
    }
}
