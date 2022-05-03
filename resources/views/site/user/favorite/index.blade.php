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
                        <div class="favorite-word-head">
                            <span class="favorite-word-span-word">{{ mb_ucfirst($favoriteWord->word) }}</span> - <span class="favorite-word-span-translation">{{ mb_ucfirst($favoriteWord->translation) }}</span>

                            <div class="favorite-word-links">
                                <form action="{{ route('user.favorites.delete', $favoriteWord->f_id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="red-link" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
{{--                                <a href="" class="red-link"></a>--}}
                            </div>

                        </div>
                        @if(!empty($favoriteWord->description))
                            <div class="favorite-word-description">
                                {{
                                    strlen($favoriteWord->description) > 400 ?
                                    mb_strcut(mb_ucfirst($favoriteWord->description), 0, 400) . ' ...' :
                                    mb_ucfirst($favoriteWord->description)
                                }}
                            </div>
                        @endif

                    </div>
                @endforeach

            @else
                <p>Нет избранных слов</p>
            @endif
        </div>
    </section>

@endsection

