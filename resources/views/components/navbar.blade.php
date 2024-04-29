<header>
    <nav>
        <div class="logo-menu-container">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/images.png') }}" alt="Logo" class="logo-navbar w-10">
            </a>
        </div>

        <div class="menu-desktop-navbar">
            <ul>
                @guest
                <li class="menu-navbar">
                    <a href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="menu-navbar">
                    <a href="#form-section">Kontak</a>
                </li>
                @else
                <li class="menu-navbar">
                    <a href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="menu-navbar">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="menu-navbar">
                    <a href="{{ route('data-user.index') }}">Data Pengguna</a>
                </li>
                <li class="menu-navbar">
                    <a href="#">Hai, {{ Auth::user()->name }}</a>
                </li>
                <li class="menu-navbar">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                        {{ __('Keluar') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                @endguest
            </ul>
        </div>

        <div class="profile-desktop-navbar relative cursor-pointer hidden">
            <img src="{{ asset('assets/images/Logo.svg') }}" alt="profile-picture" class="hidden md:block border border-slate-100 rounded-2xl p-2 aspect-square">
            <div id="profile-option" class="absolute bg-slate-50 w-full p-2 space-y-2 rounded-lg hidden">
                <p class="hover:text-[#008d91] cursor-pointer">Profile</p>
                <p id="logout" class="hover:text-red-400 cursor-pointer">Logout</p>
            </div>
        </div>

        <img id="menu-mobile-open" src="{{ asset('assets/icons/HamburgerMenu.svg') }}" alt="Menu" class="icon-navbar">
    </nav>

    <div id="menu-mobile" class="menu-mobile-navbar">
        <div class="icon-close-container">
            <img id="menu-mobile-close" src="{{ asset('assets/icons/Close.svg') }}" alt="Close" class="icon-navbar">
        </div>

        <ul>
            <li class="menu-option-navbar"><a href="#">Beranda</a></li>
            <li class="menu-option-navbar"><a href="#tentang">Tentang</a></li>
            @guest
            @else
            <li class="menu-option-navbar"><a href="{{ route('home') }}">Dashboard</a></li>
            @endguest
            <li class="menu-option-navbar"><a href="#form-section">Kontak</a></li>

            <li class="menu-option-navbar">
                @guest
                <div id="btn-navbar">
                    <a href="{{ route('login') }}"><button class="btn btn-secondary">Masuk</button></a>
                    <a href="{{ route('register') }}" class="btn btn-primary ml-2">Daftar</a>
                </div>
                @else
                <div id="profile-navbar" class="hidden justify-between items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/id/0/03/Lambang_Universitas_Tanjungpura.png" class="border border-slate-100 rounded-2xl aspect-square" alt="profile">

                    <div>
                        <button class="btn btn-secondary mr-2">Profile</button>
                        <button id="logout" class="btn btn-primary bg-red-400 border-red-400 text-black">Logout</button>
                    </div>
                </div>
                @endguest
            </li>
        </ul>
    </div>
</header>