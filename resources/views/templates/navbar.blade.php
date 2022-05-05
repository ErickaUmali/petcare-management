<nav class="navbar navbar-expand-md navbar-light bg-light px-lg-4 position-fixed">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home.index') }}"> <img src="{{ asset('images/mainlogo.png') }}"
                class="logo">
            @if ($user)
                <span>Welcome, {{ $user->firstname }}!</span>
            @endif
        </a>
        <div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if ($user && $user->role == 3)
                        <li class="nav-item">
                            <a href="{{ route('home.index') . '#home' }}"
                                class="{{ Route::currentRouteName() == 'home.index' ? 'active' : '' }}">Home</a>
                        </li>
                    @endif
                    @if (($user && $user->role == 3) || !$user)
                        <li class="nav-item">
                            <a href="{{ route('reservations.create') }}"
                                class="{{ str_contains(Route::currentRouteName(), 'reservations') ? 'active' : '' }}">Reserve</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pets.create') }}"
                                class="{{ str_contains(Route::currentRouteName(), 'pets') ? 'active' : '' }}">Pets</a>
                        </li>
                    @endif
                    @if ($user)
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}"
                                class="{{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">Dashboard</a>
                        </li>
                    @endif
                    @if ($user)
                        <form class="nav-item" action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('auth.index') }}">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>
