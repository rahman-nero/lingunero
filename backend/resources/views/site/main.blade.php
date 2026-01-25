@extends('layouts.main')

@section('title', 'Библиотека')

@section('root-classes', 'background-soft-purple')

@section('content')
    <section id="content">
        <div class="heading">
            Библиотека
        </div>

        <div class="libraries-row">
            @if($libraries->isNotEmpty())
                @foreach($libraries as $library)

                    <a href="{{ route('library.show', $library->id) }}">
                        <div class="library-block">
                            <div class="library-title">{{ $library->title }}</div>
                            <div class="library-count-items">
                                <p class="count-words">Слов: {{ $library->countWords() }}</p>
                                <p class="count-sentences">Предложении: {{ $library->countSentences() }}</p>
                            </div>
                        </div>
                    </a>

                @endforeach
            @else
                <a href="{{ route('manage.library.create.show') }}">Пожалуйста добавьте библиотеку</a>
            @endif
        </div>

        @if ($libraries->hasPages())
            <nav class="flex items-center justify-center mt-10">
                <ul class="inline-flex items-center gap-1 text-sm">

                    {{-- Previous --}}
                    @if ($libraries->onFirstPage())
                        <li>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded cursor-not-allowed">
                        ←
                    </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $libraries->previousPageUrl() }}"
                               class="px-3 py-2 bg-white border rounded hover:bg-gray-100">
                                ←
                            </a>
                        </li>
                    @endif

                    {{-- Pages --}}
                    @foreach ($libraries->links()->elements[0] ?? [] as $page => $url)
                        @if ($page == $libraries->currentPage())
                            <li>
                        <span class="px-3 py-2 text-white bg-indigo-600 rounded">
                            {{ $page }}
                        </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="px-3 py-2 bg-white border rounded hover:bg-gray-100">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($libraries->hasMorePages())
                        <li>
                            <a href="{{ $libraries->nextPageUrl() }}"
                               class="px-3 py-2 bg-white border rounded hover:bg-gray-100">
                                →
                            </a>
                        </li>
                    @else
                        <li>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded cursor-not-allowed">
                        →
                    </span>
                        </li>
                    @endif

                </ul>
            </nav>
        @endif
    </section>
@endsection
