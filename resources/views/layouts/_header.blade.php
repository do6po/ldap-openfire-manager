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
                {!! Form::open(['route' => 'logout']) !!}
                {!! Form::submit(__('Logout'), [
                    'class' => 'btn btn-link nav-link',
                    'onClick' => sprintf('return confirm("%s")', __('Are you sure?')),
                ]) !!}
                {!! Form::close() !!}
            @endguest
        </li>
    </ul>
</nav>