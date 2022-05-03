@extends('layouts.main')


@section('title', 'Добавление слов в библиотеку')

@section('root-classes', '')

@section('content')
    <section id="content">
        <div class="heading">
            Редактирование библиотеки
        </div>

        <form action="{{ route('manage.library.edit.store', $libraryId) }}" method="POST">
            @csrf
            <div class="edit-library">
                <div class="title-input-library">
                    <input type="text" name="title" value="{{ $library->first()->title }}"
                           placeholder="Название библиотеки">
                </div>

                <div class="description-input-library">
                    <textarea name="description"
                              placeholder="Описание библиотеки">{{ $library->first()->description }}</textarea>
                </div>

                <button type="submit">Обновить библиотеку</button>
            </div>

        </form>

        <div class="panel-edit-library">
            <a href="{{ route('manage.library.words.import', $libraryId) }}">Импорт слов</a>

            <form action="{{ route('manage.library.delete', $libraryId) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: red">Удалить библиотеку</button>
            </form>
            <form action="{{ route('manage.library.words.clear', $libraryId) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #ffa90a">Удалить все слова</button>
            </form>
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
                    @php
                        /** @var \App\Models\Words $word*/
                    @endphp
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
                                @if($word->isFavorite())
                                    <a href="#" title="Удалить из избранных" class="add-favorite added"><i class="fa fa-star" aria-hidden="true"></i></a>
                                @else
                                    <a href="#" title="Добавить в избранные" class="add-favorite"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                @endif
                            </div>
                        </div>

                    @endforeach

                    @if($words->total() > $words->count())
                        {{ $words->links() }}
                    @endif

                </div>

                <a href=" {{ route(name: 'manage.library.words.add.show', parameters: $libraryId) }}">
                    <div class="block-add-word-button">
                        <p>Добавить слово</p>
                    </div>
                </a>

                <div class="button-save">
                    <button type="submit" id="save-words">Обновить слова</button>
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
        const form = document.querySelector('#form');

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const word_blocks = document.querySelectorAll('.edit-row-words .word-block');

            let data = [];
            word_blocks.forEach(function (elem, key) {
                let
                    wordId = elem.dataset.id,
                    word = elem.querySelector('#word').value,
                    translation = elem.querySelector('#translation').value,
                    description = elem.querySelector('#description').value;
                data.push({
                    id: +wordId,
                    word: word,
                    translation: translation,
                    description: description,
                })
            })


            axios.post('{{ route('manage.library.words.edit.store', $libraryId) }}', {words: data})
                .then(function (response) {
                    // console.log(response)
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error.toJSON());
                });
        });


        ///////// Добавление/Удаление слов из избранных

        const icons = {
            deleted: '<i class="fa fa-star-o" aria-hidden="true"></i>',
            added: '<i class="fa fa-star" aria-hidden="true"></i>'
        };

        word_blocks.forEach((elem) => {
            let wordId = elem.dataset.id;

            elem.querySelector('.word-panel .add-favorite')
            .addEventListener('click', (e) => {
               e.preventDefault();

                let currentTarget = e.currentTarget;

               // Если это слово уже добавлено в избранные, то выполняем запрос на удаление из избранного
               if (e.currentTarget.className.includes('added')) {
                    axios.delete(`/user/favorites/${wordId}/ajax`).then(function(response) {

                        if (response.data.code == 200) {
                            currentTarget.innerHTML = '';
                            currentTarget.classList.remove('added');
                            currentTarget.insertAdjacentHTML('beforeend', icons.deleted)
                        }
                    });

               } else { // Если слово не находится в избранных, то добавляем
                   console.log('Кликнутый элемент', e.currentTarget);

                   axios.post(`/user/favorites/${wordId}`).then(function(response) {

                        if (response.data.code == 200) {
                            currentTarget.innerHTML = '';
                            currentTarget.classList.add('added');
                            currentTarget.insertAdjacentHTML('beforeend', icons.added)
                        }

                    });
               }

            });


        });

    </script>
@endpush
