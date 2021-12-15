@extends('layouts.main')


@section('title', 'Добавление слов в библиотеку')

@section('root-classes', '')

@section('content')
    <section id="content">
        <div class="heading">
            Редактирование библиотеки
        </div>

        <div class="edit-library">
            <div class="title-input-library">
                <input type="text" name="library[title]" placeholder="Название библиотеки">
            </div>

            <div class="description-input-library">
                <textarea name="library[description]" placeholder="Описание библиотеки"></textarea>
            </div>

            <div class="panel-edit-library">
                <a href="">Удалить библиотеку</a>
                <a href="">Импорт слов</a>
            </div>
        </div>


        <form action="#" method="POST" id="form">

            <div class="edit-word-form">
                <h3>Редактирование слов</h3>

                <a href=" {{ route(name: 'manage.library.words.add.show', parameters: $libraryId) }}">
                    <div class="block-add-word-button">
                        <p>Добавить слово</p>
                    </div>
                </a>

                <div class="edit-row-words">

                    @foreach($words as $word)
                        <div class="word-block" data-id="{{ $word->id }}">
                            <div class="header-block"></div>
                            <div class="definition-block">
                                <input type="text" required value="{{ $word->word }}"
                                       placeholder="Слово (на английском)" id="word">
                                <input type="text" required value="{{ $word->translation }}"
                                       placeholder="Слово (на русском)" id="translation">
                                <p><textarea placeholder="Объяснение"
                                             id="description">{{ $word->description }}</textarea></p>
                            </div>
                            <div class="word-panel">
                                <a id="delete-word"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                <a href="">Примеры</a>
                            </div>
                        </div>

                    @endforeach


                </div>

                <a href=" {{ route(name: 'manage.library.words.add.show', parameters: $libraryId) }}">
                    <div class="block-add-word-button">
                        <p>Добавить слово</p>
                    </div>
                </a>

                <div class="button-save">
                    <button type="submit" id="save-words">Сохранить все слова</button>
                </div>

            </div>

        </form>

    </section>
@endsection

@push('js')
    <script>
        ///////// Удаление слова
        const word_blocks = document.querySelectorAll('.edit-row-words .word-block');

        word_blocks.forEach(function (elem) {
            // Кнопка удаления
            let button_delete = elem.querySelector('#delete-word');

            button_delete.addEventListener('click', function () {
                // Количество блоков-слов
                let words_blocks_count = document
                    .querySelector('.edit-row-words')
                    .childElementCount;

                if (words_blocks_count <= 1) return;

                const id = elem.dataset.id;
                const url = `{{ request()->getSchemeAndHttpHost() }}/manage/library/{{ $libraryId }}/words/${id}`;

                axios.delete(url)
                    .then(function (response) {
                        elem.remove();
                    })
                    .catch(function (error) {
                        alert(error.toString())
                        console.log(error.toJSON());
                    });

            })
        });


        ///////// Отправка слов на сохранение
        {{--const form = document.querySelector('#form');--}}

        {{--form.addEventListener('submit', function (event) {--}}
        {{--    event.preventDefault()--}}
        {{--    const word_blocks = edit_row_block.querySelectorAll('.word-block');--}}
        {{--    let data = [];--}}

        {{--    word_blocks.forEach(function (elem, key) {--}}
        {{--        let--}}
        {{--            word = elem.querySelector('#word').value,--}}
        {{--            translation = elem.querySelector('#translation').value,--}}
        {{--            description = elem.querySelector('#description').value;--}}

        {{--        data.push({--}}
        {{--            word: word,--}}
        {{--            translation: translation,--}}
        {{--            description: description,--}}
        {{--        })--}}
        {{--    })--}}


        {{--    axios.post('{{ route('manage.library.words.add.store', $libraryId) }}', {words: data})--}}
        {{--        .then(function (response) {--}}
        {{--            location.reload();--}}
        {{--        })--}}
        {{--        .catch(function (error) {--}}
        {{--            console.log(error.toJSON());--}}
        {{--        });--}}
        {{--});--}}

    </script>
@endpush
