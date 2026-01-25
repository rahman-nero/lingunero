@extends('layouts.main')

@section('title', $currentChat->title)

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
                                   class="chats-list__link
                                          @if($currentChat->id === $chat->id)
                                            is-active
                                          @endif">
                                    {{ $chat->title }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        Чатов нет
                    @endif
                </ul>
            </aside>


            {{-- RIGHT: Chat --}}
            <main class="chat">

                {{-- Header --}}
                <div class="chat-header">
                    <h3 class="chat-header__title">{{ $currentChat->title }}</h3>

                    <button class="chat-header__delete" title="Удалить чат">
                        🗑
                    </button>
                </div>

                {{-- Messages --}}
                <div class="chat-messages" id="chatMessages">

                    @if($messages->isNotEmpty())

                    @foreach($messages as $message)
                        {{-- Message from current user --}}
                        <div class="chat-message chat-message--outgoing">
                            <div class="chat-message__bubble">
                                {!! $message->message !!}
                            </div>
                        </div>

                        @if($message->reply_given_at !== null)
                            {{-- Reply from LLM --}}
                            <div class="chat-message chat-message--incoming">
                                <div class="chat-message__bubble">
                                    {!! $message->reply !!}
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @else
                        Начните разговор первым!
                    @endif
                </div>

                {{-- Loader --}}
                <div class="chat-loader" id="chatLoader">
                    <span class="spinner"></span>
                    <span class="chat-loader__text">ИИ думает…</span>
                </div>

                {{-- Input --}}
                <form class="chat-input" id="chatForm">
                    <input
                        type="text"
                        id="chatInput"
                        placeholder="Введите сообщение…"
                        autocomplete="off"
                    />

                    <button type="submit">Отправить</button>
                </form>

            </main>
        </div>
    </section>
@endsection


@push('js')
    @vite(['resources/js/site/llm/chats/show.js'])
@endpush
