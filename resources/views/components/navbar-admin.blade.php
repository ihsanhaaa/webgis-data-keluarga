<div class="container my-3">
    <ul class="nav justify-content-end">
        

        @guest
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Beranda</a>
            </li>
            <li><a class="nav-link" href="{{ route('login') }}">{{ 'Login' }} </a></li>
            <li><a class="nav-link" href="{{ route('register') }}">{{ 'Register' }}</a></li>
        @else
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('data-user.index') }}">Data Pengguna</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('data-keluarga.index') }}">Data Keluarga</a>
            </li>
            <li class="nav-link">
                Hai, {{ Auth::user()->name }} <span class="caret">
            </li>
            <li class="nav-link">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Keluar') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>
</div>
