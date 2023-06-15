@extends('layouts.main')

@section('title', 'Практика слов')

@section('root-classes', 'background-soft-purple disable-vh')

@section('content')

    <section id="content">
        <div class="back">
            <a href="{{ back()->getTargetUrl() }}">Назад</a>
        </div>

        @if($sentences->isNotEmpty())
            <form action="{{ route('library.words.practice.store', $libraryId) }}" method="POST">
                @csrf

                @foreach($sentences as $word)
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
            <a href="{{ route('manage.library.words.add.show', $libraryId) }}" class="styled-button">Добавить слова</a>
        @endif

    </section>
@endsection
