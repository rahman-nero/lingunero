@extends('layouts.main')


@section('title', 'Практика слов')

@section('root-classes', 'background-soft-purple disable-vh')

@section('content')

    <section id="content">
        <div class="back">
            <a href="{{ route(name: 'home') }}">Назад</a>
        </div>

        @if($words->isNotEmpty())
            <form action="{{ route('library.words.practice.store', [$libraryId]) }}" method="POST">
                @csrf

                @foreach($words as $word)
                    <div class="form-div">
                        <div class="word">{{ $word->word }}</div>

                        <p class="label-input"><label for="input-{{ $word->id }}">Ваш ответ:</label></p>
                        <p><input type="text" autocomplete="off" id="input-{{ $word->id }}"
                                  placeholder="Введите перевод"
                                  name="words[{{ $word->id }}]"
                            ></p>
                    </div>
                @endforeach

                <button type="submit" class="styled-button">Завершить практику</button>
            </form>
        @else
            <a href="" class="styled-button">Добавь сюда слова</a>
        @endif

    </section>
@endsection
