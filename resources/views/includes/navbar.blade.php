<nav class="navbar navbar-expand-lg   schema-color <?= ($_SERVER['REQUEST_URI'] == '/')? 'mainNav-transparent' : '' ?>  fixed-top "
    id="mainNav">
    <div class="container">


        <a class="navbar-brand " href="{{route('landing')}}"> <img
                src="{{asset('storage/images/design/logos/mylogo.png')}}" alt="Logo"> LARABRARY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase  ">


                <li class="nav-item">
                    <a class="nav-link underline-animation {{ request()->is('library') ? 'active ' : '' }}"
                        href="{{route('library')}}"><i class="fa fa-book"></i> Library</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link underline-animation {{ request()->is('authors') ? 'active ' : '' }}"
                        href="{{route('authors')}}"><i class="fa fa-handshake-o"></i> Authors</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link underline-animation {{ request()->is('about') ? 'active ' : '' }}"
                        href="{{route('about')}}"><i class="fa fa-users"></i> About</a>
                </li>


            </ul>
            <ul class="navbar-nav text-uppercase ml-auto">
                {{-- -------------------------------- --}}

                <li class="nav-item cart" id="cartNav">
                    <a class="nav-link underline-animation {{ request()->is('cart') ? 'active ' : '' }}"
                        href="{{route('cart')}}">

                        <i class="fa fa-shopping-cart "></i> Cart
                        @php
                        if(Auth::check()){

                        getCartInstanceDB('default');
                        if (!isCartInstanceEmpty('default')) {
                        refreshCartInstanceDB('default');
                        }
                        getCartInstanceDB('wishlist');
                        if (!isCartInstanceEmpty('wishlist')) {
                        refreshCartInstanceDB('wishlist');
                        }
                        }
                        @endphp

                        <span class="badge badge-success"
                            id="cartCountSpan">{{Cart::instance('default')->count()}}</span>

                    </a>
                </li>


                {{-- --------------------------------------- --}}
                <!-- Authentication Links -->

                @guest
                <li class="nav-item ">
                    <a class="nav-link underline-animation {{ request()->is('login') ? 'active ' : '' }}"
                        href="{{ route('login') }}"><i class="fa fa-sign-in"></i> {{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item ">
                    <a class="nav-link underline-animation {{ request()->is('register') ? 'active' : '' }}"
                        href="{{ route('register') }}"><i class="fa fa-user-plus"></i> {{ __('Register') }}</a>
                </li>
                @endif
                @else
                @if (auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link underline-animation " href="{{ route('admin') }}"><i
                            class="fa fa-unlock-alt"></i> Admin</a>
                </li>
                @endif


                <li class="nav-item dropdown">
                    <a id="navbarDropdown "
                        class="nav-link dropdown-toggle hover-bigger {{ request()->is('user/dashboard')  ? 'active ' : '' }}"
                        href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img class="rounded-circle " width="30" height="30" src="{{Auth::user()->avatar}}" alt="">


                    </a>

                    <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown">
                        <a class="dropdown-item {{ request()->is('user/dashboard') ? 'active' : '' }}"
                            href="{{route('user.dashboard')}}"><i class="fa fa-tachometer"></i> dashboard</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                        </a>


                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>

                    @endguest
            </ul>

        </div>
    </div>
</nav>
