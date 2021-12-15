@extends('layouts.main')


@section('title', 'Добавление слов в библиотеку')

@section('root-classes', '')

@section('content')
    <section id="content">
        <div class="heading">
            Редактирование библиотеки
        </div>

        <div class="edit-library">
            <div class="title-input-library">
                <input type="text" name="library[title]" placeholder="Название библиотеки">
            </div>

            <div class="description-input-library">
                <textarea name="library[description]" placeholder="Описание библиотеки"></textarea>
            </div>

            <div class="panel-edit-library">
                <a href="">Удалить библиотеку</a>
                <a href="">Импорт слов</a>
            </div>
        </div>

        <div class="add-word-form">
            <h3>Редактирование слов</h3>

            <div class="edit-row-words">

                <div class="word-block">
                    <div class="header-block">Capacity</div>
                    <div class="definition-block">
                        <input type="text" placeholder="Слово (на английском)" name="words[]">
                        <input type="text" placeholder="Слово (на русском)">
                        <p><textarea name="" placeholder="Объяснение"></textarea></p>
                    </div>
                    <div class="word-panel">
                        <a id="delete-word" data-id="2"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        <a href="">Примеры</a>
                    </div>
                </div>

            </div>


        </div>

    </section>
@endsection

@push('js')
    <script>
        //// Удаление слова через ajax

    </script>
@endpush
