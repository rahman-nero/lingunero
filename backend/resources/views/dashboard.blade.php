@extends('layouts.main')


@section('title', 'Профиль')

@section('root-classes', 'background-soft-purple')

@section('content')
    Ты в профиле!

    <a href="{{ route('logout') }}">Выйти из аккаунта</a>
@endsection
