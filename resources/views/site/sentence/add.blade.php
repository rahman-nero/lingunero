@extends('layouts.main')


@section('title', 'Добавление предложении в библиотеку')

@section('root-classes', '')

@section('content')
    <a id="up"></a>
    <section id="content">
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
    <script>
        ///////// Добавление слова
        const edit_row_block = document.querySelector('.add-row-words');
        const button_add = document.querySelectorAll('.block-add-word-button');

        button_add.forEach(function (elem) {
            elem.addEventListener('click', function () {

                edit_row_block.insertAdjacentHTML('beforeend',
                    `<div class="word-block">
                        <div class="header-block"></div>
                                <div class="definition-block">
                                    <input type="text" required placeholder="Предложение (на английском)" id="word" >
                                    <input type="text" required placeholder="Перевод (на русском)" id="translation">
                                </div>
                            <div class="word-panel">
                                <a id="delete-word"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                     </div>
                    `);
                deleteAction();
            })
        })


        ///////// Удаление блок-предложении
        function deleteAction() {
            const word_blocks = edit_row_block.querySelectorAll('.word-block');

            word_blocks.forEach(function (elem, key) {
                // Кнопка удаления
                let button_delete = elem.querySelector('#delete-word');

                button_delete.addEventListener('click', function () {
                    // Количество блоков-предложении
                    let words_blocks_count = document
                        .querySelector('.add-row-words')
                        .childElementCount;

                    if (words_blocks_count <= 1) return;

                    elem.remove();
                })
            })
        }

        deleteAction();


        ///////// Отправка предложении на сохранение
        const form = document.querySelector('#form');

        form.addEventListener('submit', function (event) {
            event.preventDefault()
            const word_blocks = edit_row_block.querySelectorAll('.word-block');
            let data = [];

            word_blocks.forEach(function (elem, key) {
                let
                    sentence = elem.querySelector('#word').value,
                    translation = elem.querySelector('#translation').value;
                data.push({
                    sentence: sentence,
                    translation: translation,
                })
            })

            console.log(data);

            axios.post('{{ route('manage.library.sentences.add.store', $libraryId) }}', {sentences: data})
                .then(function (response) {
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error.toJSON());
                });
        });

    </script>
@endpush
