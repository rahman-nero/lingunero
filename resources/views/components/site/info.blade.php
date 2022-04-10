{{-- Вывод ошибок --}}
@if(session('success'))
    <div class="info-success">
        <p>{{ session('success') }}</p>
    </div>
@endif
