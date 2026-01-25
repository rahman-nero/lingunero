@extends('layouts.main')

@section('title', 'Чаты')

@section('root-classes', 'background-soft-purple')

@section('content')
    <section id="content" class="chats-page">
        <div class="chats-layout">

            <aside class="chats-sidebar">
                <h2 class="chats-sidebar__title">Все чаты</h2>

                <ul class="chats-list">
                    @if($chats->isNotEmpty())
                        @foreach($chats as $chat)
                            <li class="chats-list__item">
                                <a href="{{ route('llm.chats.show', ['chat_id' => $chat->id]) }}"
                                   class="chats-list__link">
                                    {{ $chat->title }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        Чатов нет
                    @endif
                </ul>
            </aside>

            <main class="chat-placeholder">
                <div class="chat-placeholder__content">
                    <p class="chat-placeholder__text">Выберите чат</p>
                    <p class="chat-placeholder__text text-sm">или</p>
                    <a href="/chats/create" class="chat-placeholder__button">
                        <span class="chat-placeholder__icon">＋</span>
                        Создать чат
                    </a>
                </div>
            </main>

        </div>
    </section>
@endsection

