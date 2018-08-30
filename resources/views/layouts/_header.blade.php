<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">{{ config('app.company_name', 'name') }}</a>
    @auth
        <input class="form-control form-control-dark w-100" placeholder="Search" aria-label="Search" type="text">
    @endauth
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            @guest()
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            @else
                {!! Form::button(__('Logout'), [
                    'class' => 'btn btn-link nav-link',
                    'data-toggle' => 'modal',
                    'data-target' => '#logoutConfirm',
                ]) !!}
            @endguest
        </li>
    </ul>
</nav>

@auth()
    @include('layouts._confirm', [
        'id' => 'logoutConfirm',
        'route' => 'logout',
        'message' => __('Logout. Are you sure?'),
        'buttonName' => __('Logout'),
        'buttonClass' => 'btn btn-danger',
    ])
@endauth