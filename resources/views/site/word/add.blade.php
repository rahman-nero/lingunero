@extends('layouts.main')

@section('title', 'Добавление слов в библиотеку')

@section('root-classes', '')

@section('content')
    <a id="up"></a>
    <section id="content" data-id="{{ $libraryId }}">
        <div class="heading">
            Добавление слов в библиотеку
        </div>
        {{-- Описание библиотеки --}}
        <div class="edit-library">
            <div class="title-input-library">
                <input type="text" value="{{ $library->first()->title  }}" disabled placeholder="Название библиотеки">
            </div>

            <div class="description-input-library">
                <textarea disabled placeholder="Описание библиотеки">{{ $library->first()->description  }}</textarea>
            </div>

            <div class="panel-edit-library">
                <a href="{{ route('manage.library.words.edit.show', $libraryId) }}">Редактировать библиотеку</a>
                <a href="{{ route('manage.library.words.import', $libraryId) }}">Импорт слов</a>
            </div>

        </div>


        {{-- Форма добавления слов --}}
        <form action="#" method="POST" id="form">

            <div class="add-word-form">
                <h3>Добавление слов</h3>

                <div class="block-add-word-button">
                    <p>Добавить слово</p>
                </div>

                <div class="add-row-words">

                    <div class="word-block">
                        <div class="header-block"></div>
                        <div class="definition-block">
                            <input type="text" required placeholder="Слово (на английском)" id="word">
                            <input type="text" required placeholder="Слово (на русском)" id="translation">
                            <p><textarea placeholder="Объяснение" id="description"></textarea></p>
                        </div>
                        <div class="word-panel">
                            <a id="delete-word"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a id="open-examples">Примеры</a>
                        </div>

                        <div class="list-examples">
                            <a id="add-example">Добавить пример</a>
                            <br>

                            <div class="example-block">
                                <input type="text" name="example" placeholder="Пример">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="block-add-word-button">
                    <p>Добавить слово</p>
                </div>

                <div class="button-save">
                    <button type="submit" id="save-words">Сохранить все слова</button>
                </div>

            </div>

        </form>

        <a href="#up" id="up-button"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    </section>
@endsection

@push('js')
    @vite(['resources/js/site/word/add.js'])
@endpush
