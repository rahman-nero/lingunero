@extends('layouts.main')


@section('title', 'Импорт слов в библиотеку')

@section('root-classes', '')

@section('content')
    <section id="content">
        <div class="heading">
            Импорт предложении в библиотеку - "{{ $library->first()->title }}"
        </div>

        <div class="panel-edit-library">
            <a href="{{ route('manage.library.words.edit.show', $libraryId) }}">Редактировать библиотеку</a>
        </div>


        <form action="{{ route('manage.library.sentences.import.store', $libraryId) }}" method="POST" id="form">
            @csrf
            <div class="block-import">
                <h3>Шаблон - "<b>Предложение на английском</b> - <b>Предложение на русском</b>". Шаблон:
                    ({{ config('site.regexp.sentence') }})</h3>
                <textarea name="sentences" placeholder="Предложение - Перевод"></textarea>
            </div>

            <button type="submit" id="import-words">Загрузить предложения</button>
        </form>

    </section>
@endsection

@push('js')
    <script>

    </script>
@endpush
