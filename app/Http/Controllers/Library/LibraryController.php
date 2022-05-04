<?php

namespace App\Http\Controllers\Library;

use App\DTO\Library\LibraryDTO;
use App\Http\Requests\Library\CreateRequest;
use App\Http\Requests\Library\EditRequest;
use App\Services\LibraryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

final class LibraryController
{
    private LibraryService $service;

    public function __construct(LibraryService $service)
    {
        $this->service = $service;
    }

    /**
     * Страница создания библиотеки
    */
    public function create()
    {
        return view('site.library.create');
    }

    /**
     * Обработка формы создания библиотеки
    */
    public function store(CreateRequest $request)
    {
        $data = new LibraryDTO(
            title: $request->input('title'),
            description: $request->input('description')
        );

        $libraryId = $this->service->create($data, Auth::id());

        if (!$libraryId) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'Вышла ошибка при создании библиотеки, пожалуйста, повторите попытку позднее']);
        }

        return redirect()
            ->route('manage.library.words.add.show', $libraryId)
            ->with('success', 'Вы успешно создали библиотеку, пожалуйста, добавьте слова');
    }

    /**
     * Обработка формы обновления библиотеки
    */
    public function update(EditRequest $request, $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $data = new LibraryDTO(
            title: $request->input('title'),
            description: $request->input('description')
        );

        $result = $this->service->edit($libraryId, $data);

        if (!$result) {
            return back()
                ->withErrors(['error' => 'Произошла ошибка при редактировании библиотеки'])
                ->withInput();
        }

        return redirect()
            ->route('manage.library.words.edit.show', $libraryId)
            ->with('success', 'Вы успешно обновили библиотеку');
    }

    /**
     * Удаление целой библиотеки со всеми связами
    */
    public function delete(int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $result = $this->service->delete($libraryId);

        if (!$result) {
            return back()
                ->withErrors(['error' => 'Произошла ошибка при удалении библиотеки'])
                ->withInput();
        }

        return redirect()
            ->route('home')
            ->with('success', 'Вы успешно удалили библиотеку');
    }

    /**
     * Удаление всех слов из библиотеки
     * !Только слов, а не предложений
    */
    public function removeWordsOfLibrary(int $libraryId)
    {
        if (!Gate::allows('can-edit-library', $libraryId)) {
            throw new AccessDeniedHttpException();
        }

        $result = $this->service->removeAllLibraryWords($libraryId);

        if (!$result) {
            return back()
                ->withErrors(['message' => 'Не удалось очистить слова библиотеки']);
        }

        return back()
            ->with('success', 'Вы успешно очистили слова из библиотеки');
    }
}
