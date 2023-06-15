@extends('layouts.main')


@section('title', 'Практика слов')

@section('root-classes', 'background-soft-purple')

@section('content')

    <section id="content">
        <div class="back">
            <a href="{{ back()->getTargetUrl() }}">Назад</a>
        </div>


        @if($sentences->isNotEmpty())
            <div class="slider">

                @foreach($sentences as $word)
                    <div class="slide">
                        <div class="card">

                            {{-- Слово --}}
                            <div class="word" data-id="{{ $word->id }}">
                                @if($word->isFavorite())
                                    <div class="button-add-favorite added">
                                        <i class="fa fa-star"></i>
                                    </div>
                                @else
                                    <div class="button-add-favorite">
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                @endif
                                <div class="center-word">
                                    {{ $word->word }}

                                    <div class="voice" data-text="{{ $word->word }}">
                                        <i class="fa fa-microphone" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Перевод --}}
                            <div class="translation">
                                <div class="center-word">
                                    {{ $word->translation }}
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Кнопки переключения --}}
            <div class="panel">
                <div class="controls">
                    <div class="left"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></div>
                    <div class="right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>
                </div>

                <span class="add-button"><a href="{{ route('manage.library.words.add.show', $libraryId) }}">Добавить новое слово</a></span>
            </div>
        @else
            <a href="{{ route('manage.library.words.add.show', $libraryId) }}">Добавь сюда слова</a>
        @endif

    </section>
@endsection

@push('js')
    <script src="{{ asset('js/word/cards.js') }}"></script>
@endpush
