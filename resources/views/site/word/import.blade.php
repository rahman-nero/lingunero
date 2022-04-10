@extends('layouts.main')


@section('title', 'Импорт слов в библиотеку')

@section('root-classes', '')

@section('content')
    <section id="content">
        <div class="heading">
            Импорт слов в библиотеку - "{{ $library->first()->title }}"
        </div>

        <div class="panel-edit-library">
            <a href="{{ route('manage.library.words.edit.show', $libraryId) }}">Редактировать библиотеку</a>
        </div>


        <form action="{{ route('manage.library.words.import.store', $libraryId) }}" method="POST" id="form">
            @csrf
            <div class="block-import">
                <h3>Шаблон - "Слово на английском - слово на русском". Шаблон: ({{ config('site.regexp.word') }})</h3>
                <textarea name="words" placeholder="Слово - Перевод"></textarea>
            </div>

            <button type="submit" id="import-words">Загрузить слова</button>
        </form>

    </section>
@endsection

@push('js')
    <script>

    </script>
@endpush
