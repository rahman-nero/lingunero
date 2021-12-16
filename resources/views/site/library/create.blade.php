@extends('layouts.main')


@section('title', 'Создание библиотеки')

@section('root-classes', '')

@section('content')
    <a id="up"></a>
    <section id="content">
        <div class="heading">
            Создание библиотеки
        </div>

        <form action="{{ route('manage.library.create.store') }}" method="POST">
            @csrf
            <div class="edit-library">
                <div class="title-input-library">
                    <input type="text" name="title" placeholder="Название библиотеки">
                </div>

                <div class="description-input-library">
                    <textarea name="description" placeholder="Описание библиотеки"></textarea>
                </div>

                <button type="submit">Создать библиотеку</button>
            </div>

        </form>

    </section>
@endsection

@push('js')

@endpush
