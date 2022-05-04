<?php

namespace App\Http\Controllers\Library\Sentences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sentences\SentencesPracticeRequest;
use App\Repository\SentencesRepository;
use App\Repository\SentencesStatisticsRepository;
use App\Services\SentencesService;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PracticeController extends Controller
{
    private SentencesRepository $sentencesRepository;
    private SentencesService $sentencesService;
    private SentencesStatisticsRepository $statisticsRepository;

    public function __construct(
        SentencesRepository $sentencesRepository,
        SentencesService $sentencesService,
        SentencesStatisticsRepository $statisticsRepository
    ) {
        $this->sentencesRepository = $sentencesRepository;
        $this->sentencesService = $sentencesService;
        $this->statisticsRepository = $statisticsRepository;
    }

    /**
     * Страница выполнения теста. Показываются предложения в ряд.
    */
    public function index(int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $sentences = $this->sentencesRepository->getSentencesByLibraryId($libraryId);

        return view('site.sentence.practice', compact('sentences', 'libraryId'));
    }

    /**
     * Обработка выполненного теста и выведение статистики
    */
    public function store(SentencesPracticeRequest $request, $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $sentences = $request['sentences'];

        $statisticId = $this->sentencesService->calcPracticeSentences(libraryId: $libraryId, sentences: $sentences);

        if (!$statisticId) {
            return back()
                ->withErrors(['message' => 'Данные введены неправильно'])
                ->withInput();
        }

        return redirect()
            ->route('library.sentences.practice.statistic', compact('libraryId', 'statisticId'));
    }

    /**
     * Страница показа результата выполнения теста
    */
    public function statistic(int $libraryId, int $statisticId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $statistic = $this->statisticsRepository
            ->findByIdAndLibraryId(statisticId: $statisticId, libraryId: $libraryId);

        if ($statistic->isEmpty()) {
            throw new NotFoundHttpException();
        }

        return view('site.sentence.statistic', compact('libraryId', 'statisticId', 'statistic'));
    }
}
