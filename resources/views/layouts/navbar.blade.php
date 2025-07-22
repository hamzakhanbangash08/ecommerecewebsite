    <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">


            <!--begin::Start Navbar Links-->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <!-- <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li> -->
            </ul>
            <!-- Left Side Of Navbar -->


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                        🛒
                        @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>
                </li>

                @if(Auth::check())
                <li class="nav-item">
                    <a href="{{ route('wishlists.index') }}" class="nav-link position-relative">
                        ❤️
                        @if(!empty($wishlistCount) && $wishlistCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $wishlistCount }}
                        </span>
                        @endif
                    </a>
                </li>
                @endif


                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown"
                        class="nav-link d-flex align-items-center"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        v-pre
                        style="gap: 10px; min-width: 180px;">

                        {{-- Profile Image --}}
                        <img src="{{ asset('images/' . (Auth::user()->image ?? 'default.png')) }}"
                            alt="Profile"
                            class="rounded-circle shadow-sm border border-light"
                            width="40" height="40"
                            style="object-fit: cover;">

                        {{-- User Name + Role --}}
                        <div class="d-flex flex-column align-items-start">
                            <strong>{{ Auth::user()->name }}</strong>
                            <small class="text-muted">{{ Auth::user()->role ?? 'User' }}</small>
                        </div>
                    </a>

                    {{-- Dropdown Menu --}}
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>


                @endguest
            </ul>
        </div>
        <!--end::Container-->
    </nav>