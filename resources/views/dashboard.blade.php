@extends('layouts.main')


@section('title', 'Профиль')

@section('root-classes', 'background-soft-purple')

@section('content')
    Ты в профиле!
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        @method('POST')
        <button type="submit">Выйти из аккаунта</button>
    </form>
@endsection
