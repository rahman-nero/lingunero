<?php


namespace App\Http\Controllers;


use App\Repository\LibraryRepository;
use Illuminate\Support\Facades\Auth;

final class MainController
{
    private LibraryRepository $libraryRepository;

    public function __construct(LibraryRepository $libraryRepository)
    {
        $this->libraryRepository = $libraryRepository;
    }

    public function index()
    {
        $libraries = $this->libraryRepository->getAllLibraries(Auth::id());


        $countWords = 5;
        $countSentences = 5;

        return view('site.main', compact('libraries', 'countSentences', 'countWords'));
    }
}
