<?php


namespace App\Http\Controllers;


use App\Repository\WordsRepository;

final class MainController
{
    private WordsRepository $wordsRepository;

    /**
     * MainController constructor.
     */
    public function __construct(WordsRepository $wordsRepository)
    {
        $this->wordsRepository = $wordsRepository;
    }

    public function index()
    {
        dd($this->wordsRepository->get());
    }
}
