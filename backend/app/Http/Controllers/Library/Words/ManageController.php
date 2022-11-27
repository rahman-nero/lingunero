<?php


namespace App\Http\Controllers\Library\Words;


use App\DTO\Words\StoreWordsDTO;
use App\Http\Requests\Words\EditWordsRequest;
use App\Http\Requests\Words\StoreWordsRequest;
use App\Repository\LibraryRepository;
use App\Repository\WordsRepository;
use App\Services\LibraryService;
use App\Services\WordsService;
use Illuminate\Http\Request;
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

    public function __construct(
        WordsRepository $wordsRepository,
        LibraryRepository $libraryRepository,
        WordsService $wordsService,
    ) {
        $this->wordsRepository = $wordsRepository;
        $this->libraryRepository = $libraryRepository;
        $this->wordsService = $wordsService;
    }

    /**
     * Страница добавления новых слов
     */
    public function show(int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $library = $this->libraryRepository->getLibrary($libraryId);

        $words = $this->wordsRepository->getWordsByLibraryIdWithoutModel($libraryId);

        return view('site.word.add', compact('library', 'libraryId', 'words'));
    }

    /**
     * Обработка формы добавления слов
    */
    public function store(StoreWordsRequest $request, int $libraryId)
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

    /**
    * Страница редактирование слов
   */
    public function edit($libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $library = $this->libraryRepository->getLibrary($libraryId);

        $words = $this->wordsRepository->getWordsByLibraryIdWithPaginate($libraryId, 10);

        return view('site.word.edit', compact('libraryId', 'library', 'words'));
    }

    /**
     * Обаработка формы редактирование слов
    */
    public function update(EditWordsRequest $request, int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }
        $data = $request->input('words');

        $result = $this->wordsService->editWords($libraryId, $data);

        if (!$result) {
            throw new BadRequestHttpException();
        }

        return 'Ok';
    }

    /**
     * Удаление слова из библиотеки
    */
    public function delete(int $libraryId, int $wordId)
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

    /**
     * Страница импорта слов
    */
    public function import($libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $library = $this->libraryRepository->getLibrary($libraryId);

        return view('site.word.import', compact('libraryId', 'library'));
    }

    /**
     * Обработка формы импорта слов
    */
    public function importStore(Request $request, int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $data = $request->input('words');

        $regexp = config('site.regexp.word');

        preg_match_all("${regexp}uim", $data, $matches, PREG_SET_ORDER);
        $matches = $this->clearRequest($matches);

        $result = $this->wordsService->importWords(libraryId: $libraryId, data: $matches);


        if (!$result) {
            throw new BadRequestHttpException();
        }

        return redirect()->route('manage.library.words.edit.show', $libraryId);
    }


    protected function clearRequest(array $matches): array
    {
        foreach ($matches as $key => $match) {
            foreach ($match as $stringKey => $string) {
                if (!is_string($stringKey)) {
                    unset($matches[$key][$stringKey]);
                    continue;
                }
                $matches[$key][$stringKey] = trim($matches[$key][$stringKey]);
            }
        }

        return $matches;
    }
}
