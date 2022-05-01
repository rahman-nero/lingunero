<?php

namespace App\Http\Controllers;

use App\Repository\LibraryRepository;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        return view('site.main', compact('libraries'));
    }

    public function library(int $libraryId)
    {
        $library = $this->libraryRepository->getLibrary($libraryId, Auth::id());

        if ($library->isEmpty()) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return view('site.library.show', compact('library'));
    }
}
