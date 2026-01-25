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
        WordsRepository           $wordsRepository,
        WordsService              $wordsService,
        WordsStatisticsRepository $statisticsRepository
    )
    {
        $this->wordsRepository = $wordsRepository;
        $this->wordsService = $wordsService;
        $this->statisticsRepository = $statisticsRepository;
    }

    /**
     * Страница показа всех слов из библиотеки в виде карточек
     */
    public function cards(int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        $words = $this->wordsRepository->getWordsByLibraryId(libraryId: $libraryId);

        return view(view: 'site.word.cards', data: compact('words', 'libraryId'));
    }

    /**
     * Страница практики слов из библиотеки
     * Некий тест на слова
     */
    public function practice(int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        $words = $this->wordsRepository->getWordsByLibraryIdWithoutModel(libraryId: $libraryId);

        return view(view: 'site.word.practice', data: compact('words', 'libraryId'));
    }

    /**
     * Обработка формы "практики слов" и выведение статистики
     */
    public function store(WordsPracticeRequest $request, int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
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
            ->route('library.words.statistic.show', compact('libraryId', 'statisticId'));
    }

    /**
     * Страница просмотра статистики по определенному тесту
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

        $statistic = $statistic->first()->toArray();

        return view('site.word.statistic', compact('statistic', 'libraryId'));
    }
}
