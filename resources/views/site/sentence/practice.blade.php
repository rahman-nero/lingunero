@extends('layouts.main')


@section('title', 'Практика слов')

@section('root-classes', 'background-soft-purple disable-vh')

@section('content')

    <section id="content">
        <div class="back">
            <a href="{{ route(name: 'home') }}">Назад</a>
        </div>

        @if($sentences->isNotEmpty())
            <form action="{{ route('library.sentences.practice.store', [$libraryId]) }}" method="POST">
                @csrf

                @foreach($sentences as $sentence)
                    <div class="form-div">
                        <div class="word">{{ $sentence->sentence }}</div>

                        <p class="label-input"><label for="input-{{ $sentence->id }}">Ваш ответ:</label></p>
                        <p><input type="text" id="input-{{ $sentence->id }}"
                                  placeholder="Введите перевод"
                                  name="sentences[{{ $sentence->id }}]"
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
