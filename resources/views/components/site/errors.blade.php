{{-- Вывод ошибок --}}
@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="info-error">
            <p>{{ $error }}</p>
        </div>
    @endforeach
@endif
