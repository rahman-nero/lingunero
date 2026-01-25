@extends('layouts.main')


@section('title', 'Добавление предложении в библиотеку')

@section('root-classes', '')

@section('content')
    <a id="up"></a>
    <section id="content" data-id="{{ $libraryId }}">
        <div class="heading">
            Добавление предложении в библиотеку
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
                <a href="{{ route('manage.library.sentences.import', $libraryId) }}">Импорт предложении</a>
            </div>
        </div>


        {{-- Форма добавления слов --}}
        <form action="#" method="POST" id="form">

            <div class="add-word-form">
                <h3>Добавление предложении</h3>

                <div class="block-add-word-button">
                    <p>Добавить предложение</p>
                </div>

                <div class="add-row-words">

                    <div class="word-block">
                        <div class="header-block"></div>
                        <div class="definition-block">
                            <input type="text" required placeholder="Предложение (на английском)" id="word">
                            <input type="text" required placeholder="Перевод (на русском)" id="translation">
                        </div>
                        <div class="word-panel">
                            <a id="delete-word"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            {{--                        <a href="">Примеры</a>--}}
                        </div>
                    </div>

                </div>

                <div class="block-add-word-button">
                    <p>Добавить предложении</p>
                </div>

                <div class="button-save">
                    <button type="submit" id="save-words">Сохранить все предложения</button>
                </div>

            </div>

        </form>

        <a href="#up" id="up-button"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    </section>
@endsection

@push('js')
    @vite(['resources/js/site/sentences/add.js'])
@endpush
