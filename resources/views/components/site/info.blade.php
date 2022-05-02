{{-- Вывод ошибок --}}
@if(session('success'))
    <div class="info info-success">
        <div class="message">
            <p>{{ session('success') }}</p>
        </div>
        <div class="close-arrow"><i class="fa fa-times" aria-hidden="true"></i></div>
    </div>
@endif
