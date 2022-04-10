@extends('layouts.main')


@section('title', 'Практика слов')

@section('root-classes', 'background-soft-purple')

@section('content')

    <section id="content">
        <div class="back">
            <a href="{{ route(name: 'home') }}">Назад</a>
        </div>
        @if($words->isNotEmpty())
            <div class="slider">
                @foreach($words as $word)
                    <div class="slide">
                        <div class="card">
                            <div class="word">{{ $word->word }}</div>
                            <div class="translation">{{ $word->translation }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
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
    <script>
        const cards = document.querySelectorAll('.slide .card');
        cards.forEach(function (card) {
            card.addEventListener('click', function () {
                card.classList.toggle('is-flip');
            });
        })
    </script>
    <script>
        // Slider
        const slider = document.querySelector(".slider");
        const slides = document.querySelectorAll(".slide");
        const left = document.querySelector(".left");
        const right = document.querySelector(".right");
        let scrollValue = 0;

        left.addEventListener("click", () => {
            scrollValue -= slider.scrollWidth / slides.length;

            if (scrollValue < 0) {
                scrollValue = slider.scrollWidth - (slider.scrollWidth / slides.length);
            }

            console.log(scrollValue);
            slider.scrollLeft = scrollValue;
        });

        right.addEventListener("click", () => {
            scrollValue += slider.scrollWidth / slides.length;

            if (scrollValue >= slider.scrollWidth) {
                scrollValue = 0;
            }

            slider.scrollLeft = scrollValue;
        });
    </script>
@endpush
