@extends('layouts.main')


@section('title', 'Практика слов')

@section('root-classes', 'background-soft-purple')

@section('content')

    <section id="content">
        <div class="back">
            <a href="{{ back()->getTargetUrl() }}">Назад</a>
        </div>



        @if($words->isNotEmpty())
            <div class="slider">

                @foreach($words as $word)
                    <div class="slide">
                        <div class="card">

                            {{-- Слово --}}
                            <div class="word"  data-id="{{ $word->id }}">
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
                                </div>
                            </div>

                            {{-- Перевод --}}
                            <div class="translation">
                                <p>
                                {{ $word->translation }}
                                </p>
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
    <script>
        // Переворачивание карточек
        const cards = document.querySelectorAll('.slide .card');
        cards.forEach(function (card) {
            card.addEventListener('click', (e) => {
                if(
                    e.target.classList[0] != 'button-add-favorite'
                    && e.target.parentNode.classList[0] != 'button-add-favorite'
                ) {
                    card.classList.toggle('is-flip');
                }
            });
        })


        ///////// Добавление/Удаление слов из избранных

        const icons = {
            deleted: '<i class="fa fa-star-o" aria-hidden="true"></i>',
            added: '<i class="fa fa-star" aria-hidden="true"></i>'
        };

        slides.forEach((elem) => {
            let wordBlock = elem.querySelector('.card .word')
            let wordId = wordBlock.dataset.id;

            wordBlock.querySelector('.button-add-favorite')
                .addEventListener('click', (e) => {
                    let currentTarget = e.currentTarget;

                    // Если это слово уже добавлено в избранные, то выполняем запрос на удаление из избранного
                    if (e.currentTarget.className.includes('added')) {
                        axios.delete(`/user/favorites/${wordId}/ajax`).then(function(response) {

                            if (response.data.code == 200) {
                                currentTarget.innerHTML = '';
                                currentTarget.classList.remove('added');
                                currentTarget.insertAdjacentHTML('beforeend', icons.deleted)
                            }
                        });

                    } else { // Если слово не находится в избранных, то добавляем
                        axios.post(`/user/favorites/${wordId}`).then(function(response) {

                            if (response.data.code == 200) {
                                currentTarget.innerHTML = '';
                                currentTarget.classList.add('added');
                                currentTarget.insertAdjacentHTML('beforeend', icons.added)
                            }

                        });
                    }

                });


        });


    </script>
@endpush
