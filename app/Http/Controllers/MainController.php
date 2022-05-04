<?php

namespace App\Http\Controllers;

use App\Repository\LibraryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        $libraries = $this->libraryRepository->getAllLibrariesWithPaginate(Auth::id(), 20);

        return view('site.main', compact('libraries'));
    }

    public function library(int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            abort(404);
        }

        $library = $this->libraryRepository->getLibrary($libraryId);

        if ($library->isEmpty()) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return view('site.library.show', compact('library'));
    }
}
