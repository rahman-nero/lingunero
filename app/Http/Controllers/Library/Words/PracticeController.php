<?php


namespace App\Http\Controllers\Library\Words;


use App\Http\Controllers\Controller;
use App\Repository\WordsRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PracticeController extends Controller
{
    private WordsRepository $wordsRepository;

    public function __construct(WordsRepository $wordsRepository)
    {
        $this->wordsRepository = $wordsRepository;
    }

    public function index(int $libraryId)
    {
        if (!Gate::allows('can-studying-words', $libraryId)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        $words = $this->wordsRepository->getWordsByLibraryId(libraryId: $libraryId);


        return view(view: 'site.word.practice', data: compact('words'));
    }

    public function store(Request $request, int $libraryId)
    {

    }

}
