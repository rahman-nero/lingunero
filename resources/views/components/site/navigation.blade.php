<header id="header">
    <div class="center">
        <div class="logo">
            <img src="{{ asset('media/logotip.png') }}" alt="Logotip">
        </div>
        <div class="top-nav-bar">
            <ul>
                <li><a href="">Главная</a></li>
                <li><a href="">Библиотека</a></li>
                <li><a href="" class="styled-button">Создать библиотеку</a></li>
            </ul>
        </div>

        <div class="profile-block">

            <div class="user">
                <div class="avatar">
                    <img src="{{ asset('media/user.png') }}" alt="">
                </div>
                <div class="description">
                    <span>
                        @php
                            $userName = \Illuminate\Support\Facades\Auth::user()->name;
                            if(strlen($userName) > 9) {
                                $output = substr($userName, 0, 10) . '...';
                            } else {
                                $output = $userName;
                            }
                        @endphp
                        {{ $output }}
                    </span>
                </div>
            </div>

        </div>
    </div>

</header>
