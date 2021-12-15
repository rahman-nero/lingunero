@extends('layouts.main')


@section('title', 'Добавление слов в библиотеку')

@section('root-classes', '')

@section('content')
    <a id="up"></a>
    <section id="content">
        <div class="heading">
            Редактирование библиотеки
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
                <a href="">Удалить библиотеку</a>
                <a href="">Импорт слов</a>
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
                            {{--                        <a href="">Примеры</a>--}}
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
                                    <input type="text" required placeholder="Слово (на английском)" id="word" >
                                    <input type="text" required placeholder="Слово (на русском)" id="translation">
                                    <p><textarea placeholder="Объяснение" id="description"></textarea></p>
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


        ///////// Удаление блок-слова
        function deleteAction() {
            const word_blocks = edit_row_block.querySelectorAll('.word-block');

            word_blocks.forEach(function (elem, key) {
                // Кнопка удаления
                let button_delete = elem.querySelector('#delete-word');

                button_delete.addEventListener('click', function () {
                    // Количество блоков-слов
                    let words_blocks_count = document
                        .querySelector('.add-row-words')
                        .childElementCount;

                    if (words_blocks_count <= 1) return;

                    elem.remove();
                })
            })
        }

        deleteAction();


        ///////// Отправка слов на сохранение
        const form = document.querySelector('#form');

        form.addEventListener('submit', function () {
            const word_blocks = edit_row_block.querySelectorAll('.word-block');
            let data = [];

            word_blocks.forEach(function (elem, key) {
                let
                    word = elem.querySelector('#word').value,
                    translation = elem.querySelector('#translation').value,
                    description = elem.querySelector('#description').value;

                data.push({
                    word: word,
                    translation: translation,
                    description: description,
                })
            })


            axios.post('{{ route('manage.library.words.add.store', $libraryId) }}', data)
                .then(function (response) {
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
        });


    </script>
@endpush
