<?php


namespace App\Http\Controllers\Library\Sentences;


use App\DTO\Sentences\StoreSentencesDTO;
use App\Http\Requests\Sentences\EditSentencesRequest;
use App\Http\Requests\Sentences\StoreSentenceRequest;
use App\Repository\LibraryRepository;
use App\Repository\SentencesRepository;
use App\Services\SentencesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

final class ManageController
{
    private LibraryRepository $libraryRepository;
    private SentencesRepository $sentencesRepository;
    private SentencesService $sentencesService;

    public function __construct(
        LibraryRepository $libraryRepository,
        SentencesRepository $sentencesRepository,
        SentencesService $sentencesService
    )
    {
        $this->libraryRepository = $libraryRepository;
        $this->sentencesService = $sentencesService;
        $this->sentencesRepository = $sentencesRepository;
    }

    public function create(int $libraryId)
    {
        if (!Gate::allows('can-studying-words', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $library = $this->libraryRepository->getLibrary($libraryId, Auth::id());

        return view('site.sentence.add', compact('libraryId', 'library'));
    }

    public function store(StoreSentenceRequest $data, int $libraryId)
    {
        if (!Gate::allows('can-studying-words', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $dto = StoreSentencesDTO::fromTo($data->input('sentences'));

        $result = $this->sentencesService->storeSentences($libraryId, $dto);

        if (!$result) {
            throw new ServiceUnavailableHttpException();
        }

        return 'Ok';
    }


    public function show(int $libraryId)
    {
        if (!Gate::allows('can-studying-words', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $sentences = $this->sentencesRepository->getSentencesByLibraryIdWithPaginate($libraryId, 10);

        return view('site.sentence.edit', compact('libraryId', 'sentences'));
    }


    public function update(EditSentencesRequest $request, $libraryId)
    {
        // TODO: у тебя везде can-studying-words, просто сделай вместо этого has-library
        if (!Gate::allows('can-studying-words', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $data = $request->input('sentences');

        $result = $this->sentencesService->editSentences($libraryId, $data);

        if (!$result) {
            throw new ServiceUnavailableHttpException();
        }

        return 'Ok';
    }


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

}
