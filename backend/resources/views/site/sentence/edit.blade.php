@extends('layouts.main')


@section('title', 'Добавление слов в библиотеку')

@section('root-classes', '')

@section('content')
    <section id="content" data-id="{{ $libraryId }}">
        <form action="#" method="POST" id="form">

            <div class="edit-word-form">
                <h3>Редактирование предложении</h3>

                <a href=" {{ route(name: 'manage.library.sentences.add.show', parameters: $libraryId) }}">
                    <div class="block-add-word-button">
                        <p>Добавить предложение</p>
                    </div>
                </a>

                <div class="edit-row-words">

                    @foreach($sentences as $sentence)
                        <div class="word-block" data-id="{{ $sentence->id }}">
                            <div class="header-block"></div>
                            <div class="definition-block">
                                <input type="text" required value="{{ $sentence->sentence }}"
                                       placeholder="Предложении (на английском)" id="word">
                                <input type="text" required value="{{ $sentence->translation }}"
                                       placeholder="Перевод (на русском)" id="translation">
                            </div>
                            <div class="word-panel">
                                <a id="delete-word"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>
                        </div>

                    @endforeach

                    @if($sentences->total() > $sentences->count())
                        {{ $sentences->links() }}
                    @endif

                </div>

                <a href=" {{ route(name: 'manage.library.sentences.add.show', parameters: $libraryId) }}">
                    <div class="block-add-word-button">
                        <p>Добавить предложение</p>
                    </div>
                </a>

                <div class="button-save">
                    <button type="submit" id="save-words">Обновить предложении</button>
                </div>

            </div>

        </form>

    </section>
@endsection

@push('js')
    <script src="{{ asset('js/sentences/edit.js') }}"></script>
@endpush
