@extends('layouts.main')


@section('title', 'Добавление слов в библиотеку')

@section('root-classes', '')

@section('content')
    <section id="content" data-id="{{ $libraryId }}">
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
    <script src="{{ asset('js/word/edit.js') }}" ></script>
@endpush
