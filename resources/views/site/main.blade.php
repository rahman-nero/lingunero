@extends('layouts.main')


@section('title', 'Библиотека')

@section('root-classes', 'background-soft-purple')

@section('content')
    <section id="content">
        <div class="heading">
            Библиотека
        </div>

        <div class="libraries-row">
            @if($libraries->isNotEmpty())
                @foreach($libraries as $library)

                    <a href="{{ route('library.show', $library->id) }}">
                        <div class="library-block">
                            <div class="library-title">{{ $library->title }}</div>
                            <div class="library-count-items">
                                <p class="count-words">Слов: {{ $library->countWords() }}</p>
                                <p class="count-sentences">Предложении: {{ $library->countSentences() }}</p>
                            </div>
                        </div>
                    </a>

                @endforeach
            @else
                <a href="">Пожалуйста добавьте библиотеку</a>
            @endif

        </div>
    </section>
@endsection
