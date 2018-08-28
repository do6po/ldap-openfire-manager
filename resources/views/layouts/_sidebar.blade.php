<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">

            @auth()

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteNamed('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="fa fa-home"></i>
                        {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteNamed('ldap.*') ? 'active' : '' }}"
                       href="{{ route('ldap.index') }}">
                        <i class="fa fa-server"></i>
                        {{ __('LDAP servers') }}
                    </a>
                </li>

                <li class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-plus-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </a>
                </li>

            @endauth

        </ul>
    </div>
</nav>
