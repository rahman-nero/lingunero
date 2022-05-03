<header id="header">

    <div class="center">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('media/logotip.png') }}" alt="Logotip">
            </a>
        </div>

        <div class="top-nav-bar">
            <ul>
                <li><a href="{{ route('home') }}">Главная</a></li>
                <li><a href="{{ route('user.favorites') }}">Избранные</a></li>
                <li><a href="{{ route('manage.library.create.show') }}" class="styled-button">Создать библиотеку</a>
                </li>
            </ul>
        </div>

        <div class="profile-block">

            <a href="{{ route('dashboard') }}">
                <div class="user">
                    <div class="avatar">
                        <img src="{{ asset('media/user.png') }}" alt="">
                    </div>
                    <div class="description">
                    <span>
                        @php
                            $userName = \Illuminate\Support\Facades\Auth::user()->name;
                            $output = $userName;

                            if(strlen($userName) > 9) {
                                $output = substr($userName, 0, 10) . '...';
                            }
                        @endphp
                        {{ $output }}
                    </span>
                    </div>
                </div>
            </a>

        </div>
    </div>

</header>
