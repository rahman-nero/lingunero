@extends('layouts.main')


@section('title', 'Библиотека')

@section('root-classes', 'background-soft-purple')

@section('content')
    <section id="content">
        <div class="heading">
            <h2>{{ $library->first()->title  }}</h2>
        </div>

        <div class="list-action">

            <div class="list-block"
                 data-background="{{ asset('media/i01_1.jpg') }}"
            >

                <div class="content">
                    <span>Карточки слов - {{ $library->first()->countWords() }}</span>
                </div>
                <div class="action">
                    <a href=""><img src="{{ asset('media/edit.png') }}" alt=""></a>
                    <a href=""><img src="{{ asset('media/remove.png') }}" alt=""></a>
                    <a href=""><img src="{{ asset('media/plus.png') }}" alt=""></a>
                </div>
            </div>


            <div class="list-block"
                 data-background="{{ asset('media/i01_2.jpg') }}"
            >

                <div class="content">
                    <span>Практика слов - {{ $library->first()->countWords() }}</span>
                </div>
                <div class="action">
                    <a href=""><img src="{{ asset('media/edit.png') }}" alt=""></a>
                    <a href=""><img src="{{ asset('media/remove.png') }}" alt=""></a>
                    <a href=""><img src="{{ asset('media/plus.png') }}" alt=""></a>
                </div>
            </div>

            <div class="list-block"
                 data-background="{{ asset('media/i01_3.jpg') }}"
            >
                <div class="content">
                    <span>Практика предложении - {{ $library->first()->countSentences() }}</span>
                </div>
                <div class="action">
                    <a href=""><img src="{{ asset('media/edit.png') }}" alt=""></a>
                    <a href=""><img src="{{ asset('media/remove.png') }}" alt=""></a>
                    <a href=""><img src="{{ asset('media/plus.png') }}" alt=""></a>
                </div>
            </div>

        </div>
    </section>
    <script>
        let list_blocks = document.querySelectorAll('.list-block');

        list_blocks.forEach(function (elem, key) {
            console.log(elem);
            console.log(elem.dataset);

            elem.style.backgroundImage = "url(" + elem.dataset.background + ")";
        });
    </script>
@endsection


