@extends('layouts.main')

@section('title', 'Библиотека')

@section('root-classes', 'background-soft-purple')

@section('content')
    <section id="content">
        <div class="heading">
            Избранные
        </div>

        <div class="list-favorite-words">

            @if($favoriteWords->isNotEmpty())

                @foreach($favoriteWords as $favoriteWord)
                    <div class="favorite-word">
                        <p>
                            <span class="favorite-word-span-word">{{ mb_ucfirst($favoriteWord->word) }}</span> - <span class="favorite-word-span-translation">{{ mb_ucfirst($favoriteWord->translation) }}</span>
                        </p>
                        <a href="{{ route('manage.library.words.edit.show', $favoriteWord->library_id) }}" class="">Перейти к cлову</a>

                        <div class="favorite-word-links">
                            <a href="" class="red-link"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                @endforeach

            @else
                <p>Нет избранных слов</p>
            @endif
        </div>
    </section>

@endsection

