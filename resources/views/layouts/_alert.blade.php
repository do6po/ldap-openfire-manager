@foreach(\App\Helpers\FlashMessageHelper::allTypes() as $type)
    @if (Session::has($type))
        <div class="alert alert-{{ $type }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get($type) }}
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif