@extends('layouts.main')


@section('title', 'Статистика слов')

@section('root-classes', 'background-soft-purple ')

@section('content')
    <section id="content">
        <div class="back">
            <a href="{{ back()->getTargetUrl() }}">Назад</a>
        </div>

        <div class="block-statistic">
            <h3>Статистика</h3>

            <div class="result">
                <p class="count-words" data-count="{{ $statistic->first()->count_sentences  }}">Слов:
                    <span>{{ $statistic->first()->count_sentences }}</span></p>

                <p class="count-wrong" data-count="{{ $statistic->first()->count_wrong }}">Неправильные:
                    <span>{{ $statistic->first()->count_wrong }}</span></p>

                <p class="count-right" data-count="{{ $statistic->first()->count_true }}">Правильные:
                    <span>{{ $statistic->first()->count_true }}</span>
                </p>
            </div>

            <div class="percent">0</div>
            <div class="progress-bar">
                <div class="loaded"></div>
            </div>

        </div>

    </section>
@endsection

@push('js')
    <script src="{{ asset('js/sentences/statistic.js') }}"></script>
@endpush
