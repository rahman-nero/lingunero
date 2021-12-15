<?php


namespace App\Http\Controllers\Library\Words;


use App\Http\Controllers\Controller;
use App\Http\Requests\Words\WordsPracticeRequest;
use App\Repository\WordsRepository;
use App\Repository\WordsStatisticsRepository;
use App\Services\WordsService;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PracticeController extends Controller
{
    private WordsRepository $wordsRepository;
    private WordsService $wordsService;
    private WordsStatisticsRepository $statisticsRepository;

    public function __construct(
        WordsRepository $wordsRepository,
        WordsService $wordsService,
        WordsStatisticsRepository $statisticsRepository
    )
    {
        $this->wordsRepository = $wordsRepository;
        $this->wordsService = $wordsService;
        $this->statisticsRepository = $statisticsRepository;
    }

    public function cards(int $libraryId)
    {
        if (!Gate::allows('can-studying-words', $libraryId)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        $words = $this->wordsRepository->getWordsByLibraryId(libraryId: $libraryId);

        return view(view: 'site.word.cards', data: compact('words', 'libraryId'));
    }

    public function practice(int $libraryId)
    {
        if (!Gate::allows('can-studying-words', $libraryId)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        $words = $this->wordsRepository->getWordsByLibraryId(libraryId: $libraryId);

        return view(view: 'site.word.practice', data: compact('words', 'libraryId'));
    }

    public function store(WordsPracticeRequest $request, int $libraryId)
    {
        if (!Gate::allows('can-studying-words', $libraryId)) {
            throw new AccessDeniedHttpException();
        }
        $words = $request['words'];

        $statisticId = $this->wordsService->calcPracticeWords(libraryId: $libraryId, words: $words);

        if (!$statisticId) {
            return back()
                ->withErrors(['message' => 'Данные введены неправильно'])
                ->withInput();
        }

        return redirect()
            ->route('library.words.statistic.show', [$libraryId, $statisticId]);
    }

    public function statistic(int $libraryId, int $statisticId)
    {
        if (!Gate::allows('can-studying-words', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $statistic = $this->statisticsRepository
            ->findByIdAndLibraryId(statisticId: $statisticId, libraryId: $libraryId);

        if ($statistic->isEmpty()) {
            throw new NotFoundHttpException();
        }

        return view('site.word.statistic', compact('statistic', 'libraryId'));
    }

}
