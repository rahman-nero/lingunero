{{-- Вывод ошибок --}}
@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="info info-error">
            <div class="message">
                <p>{{ $error }}</p>
            </div>
            <div class="close-arrow"><i class="fa fa-times" aria-hidden="true"></i></div>
        </div>
    @endforeach
@endif
