<?php

namespace App\Http\Controllers\Library\Sentences;

use App\DTO\Sentences\StoreSentencesDTO;
use App\Http\Requests\Sentences\EditSentencesRequest;
use App\Http\Requests\Sentences\StoreSentenceRequest;
use App\Repository\LibraryRepository;
use App\Repository\SentencesRepository;
use App\Services\SentencesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

final class ManageController
{
    private LibraryRepository $libraryRepository;
    private SentencesRepository $sentencesRepository;
    private SentencesService $sentencesService;

    public function __construct(
        LibraryRepository   $libraryRepository,
        SentencesRepository $sentencesRepository,
        SentencesService    $sentencesService
    )
    {
        $this->libraryRepository = $libraryRepository;
        $this->sentencesService = $sentencesService;
        $this->sentencesRepository = $sentencesRepository;
    }

    /**
     * Страница добавления новых предложений
     */
    public function create(int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $library = $this->libraryRepository->getLibrary($libraryId);

        return view('site.sentence.add', compact('libraryId', 'library'));
    }

    /**
     * Обработка формы добавления новых предложений
     */
    public function store(StoreSentenceRequest $data, int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $dto = StoreSentencesDTO::fromTo($data->input('sentences'));

        $result = $this->sentencesService->storeSentences($libraryId, $dto);

        if (!$result) {
            throw new ServiceUnavailableHttpException();
        }

        return 'Ok';
    }


    /**
     * Страница множественного редактирования предложений
     */
    public function edit(int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $sentences = $this->sentencesRepository->getSentencesByLibraryIdWithPaginate($libraryId, 10);

        return view('site.sentence.edit', compact('libraryId', 'sentences'));
    }

    /**
     * Обработка формы множественного редактирования предложений
     */
    public function update(EditSentencesRequest $request, $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $data = $request->input('sentences');

        $result = $this->sentencesService->editSentences($libraryId, $data);

        if (!$result) {
            throw new ServiceUnavailableHttpException();
        }

        return 'Ok';
    }

    /**
     * Страница иморта предложений
     */
    public function import($libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $library = $this->libraryRepository->getLibrary($libraryId);

        return view('site.sentence.import', compact('libraryId', 'library'));
    }


    /**
     * Обработка формы импорта предложений
     */
    public function importStore(Request $request, $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $data = $request->input('sentences');
        $regexp = config('site.regexp.sentence');

        preg_match_all("${regexp}uim", $data, $matches, PREG_SET_ORDER);
        $matches = $this->clearRequest($matches);

        $result = $this->sentencesService->importSentences(libraryId: $libraryId, data: $matches);

        if (!$result) {
            throw new BadRequestHttpException();
        }

        return redirect()->route('manage.library.sentences.edit.show', $libraryId);
    }

    /**
     * Удаление предложения
     */
    public function delete(int $libraryId, int $sentencesId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        if (!$this->sentencesRepository->isBelongsToLibrary(sentenceId: $sentencesId, libraryId: $libraryId)) {
            throw new NotFoundHttpException();
        }

        $result = $this->sentencesService->delete($sentencesId);

        if (!$result) {
            throw new ServiceUnavailableHttpException();
        }

        return 'Ok';
    }

    protected function clearRequest(array $matches)
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
