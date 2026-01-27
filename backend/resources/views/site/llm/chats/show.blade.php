@extends('layouts.main')

@section('title', $currentChat->title)

@section('root-classes', 'background-soft-purple')

@section('content')
    <section id="content" class="chats-page">
        <div class="chats-layout">

            <aside class="chats-sidebar hidden md:block">
                <div class="flex justify-between">
                    <h2 class="chats-sidebar__title">Все чаты</h2>
                    <a href="{{ route('llm.chats.store') }}" class="block" title="Создать чат"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>

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
            <main class="chat h-auto">

                {{-- Header --}}
                <div class="chat-header">
                    <h3 class="chat-header__title">
                        <a href="{{ route('llm.chats.index') }}" class="mr-2"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                        {{ $currentChat->title }}
                    </h3>

                    <a href="{{ route('llm.chats.delete', ['chat_id' => $currentChat->id]) }}" class="chat-header__delete" title="Удалить чат">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>

                {{-- Messages --}}
                <div class="chat-messages" id="chatMessages">

                    @if($messages->isNotEmpty())

                    @foreach($messages as $message)
                        {{-- Message from current user --}}
                        <div class="chat-message chat-message--outgoing"  title="{{ $message->created_at->translatedFormat('j F Y H:i:s') }}">
                            <div class="chat-message__bubble">
                                {!! $message->message !!}
                            </div>
                        </div>

                        @if($message->reply_given_at !== null)
                            {{-- Reply from LLM --}}
                            <div class="chat-message chat-message--incoming" title="{{ $message->reply_given_at->translatedFormat('j F Y H:i:s') }}">
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

                    <button type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                </form>

            </main>
        </div>
    </section>
@endsection


@push('js')
    @vite(['resources/js/site/llm/chats/show.js'])
@endpush
