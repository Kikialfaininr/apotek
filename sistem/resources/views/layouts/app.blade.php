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
    <link rel="stylesheet" type="text/css" href="{{ asset('sistem\css\style.css') }}">

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

    <!-- DataTables -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('sistem/img/logo2.png') }}" alt="apotek" width="100px"
                        class="d-inline-block align-text-center" />
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ url('/') }}"
                                style="{{ request()->is('/') ? 'color: #FFC045;' : '' }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/toko-allproduk') }}"
                                style="{{ request()->is('toko-allproduk') ? 'color: #FFC045;' : '' }}">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}#carapesan">Cara Pemesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}#kontak">Kontak</a>
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
                        @if(auth()->check() && (auth()->user()->level == 'pelanggan'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/pelanggan') }}"><i class='fas fa-shopping-bag'
                                    style="font-size: 20px; margin-top: 10px;"></i>
                                @php
                                $userId = auth()->user()->id;
                                $count = \App\Models\Pesanan::where('id', $userId)
                                ->where(function($query) {
                                $query->whereIn('status', ['Siap', 'Dikirim'])
                                ->orWhereNull('status');
                                })
                                ->count();
                                @endphp
                                @if($count > 0)
                                <span
                                    class="position-absolute top-40 start-10 translate-middle badge rounded-pill bg-danger"
                                    style="background-color: red;"> {{ $count }}</span>
                                @endif
                            </a>
                        </li>
                        @endif
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
                                @if(auth()->check() && (auth()->user()->level == 'pelanggan'))
                                <a href="{{ url('pelanggan') }}" class="dropdown-item">
                                    Profil Saya
                                </a>
                                @elseif(auth()->check() && (auth()->user()->level == 'admin' || auth()->user()->level ==
                                'owner'))
                                <a href="{{ url('editprofil-admin') }}" class="dropdown-item">
                                    Edit Profile
                                </a>
                                @else
                                <a href="{{ url('editprofil-kasir') }}" class="dropdown-item">
                                    Edit Profile
                                </a>
                                @endif
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

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <div class="footer-container" id="kontak">
                <div class="row">
                    <div class="col-md-6">
                        <div style="margin: 50px 0 20px 70px;">
                            <h3 style="font-weight: bold;">Alamat Apotek</h3>
                            <p>Jalan Jendral Sudirman No. 6A RT 01 RW 09 Planjan, Kecamatan Kesugihan, Kab. Cilacap,
                                Provinsi
                                Jawa Tengah</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="margin: 50px 0 20px 70px;">
                            <h3 style="font-weight: bold;">Kontak</h3>
                            <p><i class="fa fa-envelope" aria-hidden="true"></i> Email: duafarmaapotek@gmail.com</p>
                            <p><i class="fa fa-phone" aria-hidden="true"></i> Telepon: 081391127556</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="margin: 10px 0 20px 70px;">
                        <h3 style="font-weight: bold;">Maps</h3>
                        <div class="map" style="margin-top: 20px;">
                            <div class="container-fluid">
                                <div class="map-responsive">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.5561556214234!2d109.08319967372269!3d-7.623175775373578!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e656d5ef62354f1%3A0x16963b8f0cf5cab3!2sApotik%20dua%20farma!5e0!3m2!1sid!2sid!4v1705336554209!5m2!1sid!2sid"
                                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center"
                        style="border-top: 1px solid #ccc; padding-top: 20px; margin-top: 40px;">
                        <p>&copy; 2024 Apotek Dua Farma. All rights reserved.</p>
                        <p>Powered by Kiki Alfaini Nurrizki</p>
                    </div>
                </div>
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