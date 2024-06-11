<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Apotek Dua Farma</title>
    <link rel="icon" href="{{ asset('sistem/img/logo1.png') }}" type="image">

    <!-- My Own Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('sistem\css\style-kasir.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Quicksand:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome 5.15.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Pastikan untuk memuat jQuery sebelum memuat Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- DataTables -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" rel="stylesheet">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('sistem/img/logo1.png') }}" alt="apotek" width="100px"
                        class="d-inline-block align-text-center" />
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link{{ Request::is('kasir') ? ' active' : '' }}" aria-current="page"
                                href="{{ url('/kasir') }}"
                                style="{{ Request::is('kasir') ? 'color: #FFC045;' : '' }}">Kasir</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ Request::is('kasir-pesananonline') ? ' active' : '' }}"
                                href="{{ url('/kasir-pesananonline') }}"
                                style="{{ Request::is('kasir-pesananonline') ? 'color: #FFC045;' : '' }}">
                                Pesanan Online
                                @php
                                $count = \App\Models\Pesanan::whereNull('status')->count();
                                @endphp
                                @if($count > 0)
                                <span class="badge rounded-pill bg-danger">{{ $count }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ Request::is('kasir-stokproduk') ? ' active' : '' }}"
                                href="{{ url('/kasir-stokproduk') }}"
                                style="{{ Request::is('kasir-stokproduk') ? 'color: #FFC045;' : '' }}">Stok Produk</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle{{ Request::is('kasir-riwayatpenjualan') || Request::is('kasir-riwayatpesananonline') ? ' active' : '' }}"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false"
                                style="{{ Request::is('kasir-riwayatpenjualan') || Request::is('kasir-riwayatpesananonline') ? 'color: #FFC045;' : 'color: white;' }}">
                                Riwayat Transaksi
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ url('/kasir-riwayatpenjualan') }}">Riwayat
                                        Penjualan</a></li>
                                <li><a class="dropdown-item" href="{{ url('/kasir-riwayatpesananonline') }}">Riwayat
                                        Pesanan Online</a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Masuk') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Daftar') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if(Auth::user()->foto)
                                <img src="{{ asset('images/fotoprofil/'.Auth::user()->foto) }}" alt="profil"
                                    style="width:40px; height: 40px;"
                                    class="d-inline-block align-text-center rounded-circle">
                                @else
                                <img src="{{ asset('sistem/img/profil.jpg') }}" alt="profil"
                                    style="width:40px; height: 40px;"
                                    class="d-inline-block align-text-center rounded-circle">
                                @endif
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a href="{{ url('editprofil-kasir') }}" class="dropdown-item">
                                    Edit Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4" style="background-color: #EEEDEB;">
            @yield('content')
        </main>

        <footer>
            <p>Aplikasi Kasir</p>
            <p>&#169;2024 Apotek Dua Farma</p>
        </footer>
    </div>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
    @stack('scripts')
</body>

</html>