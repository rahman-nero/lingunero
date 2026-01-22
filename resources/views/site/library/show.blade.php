@extends('layouts.main')

@section('title', 'Библиотека')

@section('root-classes', 'background-soft-purple')

@section('content')
    <section id="content">
        <div class="heading">
            <h2>{{ \Illuminate\Support\Str::ucfirst($library->first()->title)  }}</h2>

            <a href="{{ route('manage.library.words.edit.show', $library->first()->id) }}" style="font-size: 14px">Редактировать
                библиотеку</a>
        </div>

        <div class="list-action">

            <a href="{{ route('library.words.studying', $library->first()->id) }}">
                <div class="list-block" data-background="{{ asset('media/i01_1.jpg') }}">
                    <div class="content">
                        <span>Карточки слов - {{ $library->first()->countWords() }}</span>
                    </div>
                <div class="action">
                        <a href="{{ route('manage.library.words.edit.show', $library->first()->id) }}"><img src="{{ asset('media/edit.png') }}" alt=""></a>
                        <a href="{{ route('manage.library.words.add.show', $library->first()->id) }}"><img src="{{ asset('media/plus.png') }}" alt=""></a>
                    </div>
                </div>
            </a>

            <a href="{{ route('library.words.practice.index', $library->first()->id) }}">
                <div class="list-block" data-background="{{ asset('media/i01_2.jpg') }}">

                    <div class="content">
                        <span>Практика слов - {{ $library->first()->countWords() }}</span>
                    </div>
                    <div class="action">
                        <a href="{{ route('manage.library.words.edit.show', $library->first()->id) }}"><img
                                src="{{ asset('media/edit.png') }}" alt=""></a>
                        <a href="{{ route('manage.library.words.add.show', $library->first()->id) }}"><img
                                src="{{ asset('media/plus.png') }}" alt=""></a>
                    </div>
                </div>
            </a>

            <a href="{{ route('library.sentences.practice.index', $library->first()->id) }}">
                <div class="list-block" data-background="{{ asset('media/i01_3.jpg') }}">
                    <div class="content">
                        <span>Практика предложении - {{ $library->first()->countSentences() }}</span>
                    </div>
                    <div class="action">
                        <a href="{{ route('manage.library.sentences.edit.show', $library->first()->id) }}">
                            <img src="{{ asset('media/edit.png') }}" alt="">
                        </a>
                        <a href="{{ route('manage.library.sentences.add.show', $library->first()->id) }}">
                            <img src="{{ asset('media/plus.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </a>


            <a href="{{ route('library.sentences.practice.cards', $library->first()->id) }}">
                <div class="list-block" data-background="{{ asset('media/i01_4.jpg') }}">
                    <div class="content">
                        <span>Карточки предложений - {{ $library->first()->countSentences() }}</span>
                    </div>
                    <div class="action">
                        <a href="{{ route('manage.library.sentences.edit.show', $library->first()->id) }}">
                            <img src="{{ asset('media/edit.png') }}" alt="">
                        </a>
                        <a href="{{ route('manage.library.sentences.add.show', $library->first()->id) }}">
                            <img src="{{ asset('media/plus.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </a>


        </div>
    </section>

@endsection


@push('js')
    @vite(['resources/js/site/library/show.js'])
@endpush
