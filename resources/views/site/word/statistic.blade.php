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
                <p class="count-words" data-count="{{ $statistic['count_words']  }}">Слов:
                    <span>{{ $statistic['count_words'] }}</span></p>

                <p class="count-wrong" data-count="{{ $statistic['count_wrong'] }}">Неправильные:
                    <span>{{ $statistic['count_wrong'] }}</span></p>

                <p class="count-right" data-count="{{ $statistic['count_true'] }}">Правильные:
                    <span>{{ $statistic['count_true'] }}</span>
                </p>
            </div>

            <div class="percent">0</div>
            <div class="progress-bar">
                <div class="loaded"></div>
            </div>

            <br>
            <br>
            @if(!empty($statistic['result']))
                <h3>Результат</h3>
                <br>
                <table class="table">
                    <thead>
                    <th>Слово</th>
                    <th>Перевод</th>
                    <th>Ответ</th>
                    <th>Правильность</th>
                    </thead>
                    <tbody>
                    @foreach($statistic['result'] as $item)
                        <tr class="table-{{ $item['is_right'] ? 'success': 'wrong' }}">
                            <td>{{ $item['word'] }}</td>
                            <td>{{ $item['answer'] }}</td>
                            @if(!$item['is_right'])
                                <td>{{ $item['user_answer'] }}</td>
                            @else
                                <td>{{ $item['answer'] }}</td>
                            @endif
                            @if(!$item['is_right'])
                                <td><i class="fa fa-times" aria-hidden="true"></i></td>
                            @else
                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </section>
@endsection

@push('js')
    @vite(['resources/js/site/word/statistic.js'])
@endpush
