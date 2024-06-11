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
    <link rel="stylesheet" type="text/css" href="{{ asset('sistem\css\style-admin.css') }}">

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
        <div class="content">
            <nav class="navbar navbar-expand-md bg-body-tertiary shadow rounded">
                <div class="container-fluid">
                    <a class="navbar-brand me-auto" href="{{ url('/home') }}">
                        <h4>Dashboard</h4>
                    </a>
                </div>
                <div class="top_bar_content ms-auto">
                    <div class="nav-item dropdown">
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
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a href="{{ url('editprofil-admin') }}" class="dropdown-item">
                                    Edit Profile
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="sidebar" style="overflow-y: scroll;">
            <div class="logo">
                <img src="{{ asset('sistem/img/logo1.png') }}" alt="apotek" width="120px" class="d-inline-block align-text-center" />
            </div>
            <ul class="menu">
                <li style="@if(Request::is('home')) background-color: #FFC045; @endif border-radius: 10px;"><a
                        href="{{url('/home')}}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li style="@if(Request::is('admin-datauser')) background-color: #FFC045; @endif border-radius: 10px;"><a
                        href="{{url('/admin-datauser')}}"><i class="fas fa-users"></i> Data Pelanggan</a></li>
                <li style="@if(Request::is('admin-ongkir')) background-color: #FFC045; @endif border-radius: 10px;"><a
                        href="{{url('/admin-ongkir')}}"><i class="fa fa-truck"></i> Data Ongkir</a></li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-box"></i> Produk </a> <a
                        style="float: right; margin-top: -15px; color: white;"><i class="fas fa-caret-down"></i></a>
                    <ul>
                        <li
                            style="@if(Request::is('admin-kategori')) background-color: #FFC045; @endif border-radius: 10px;">
                            <a href="{{url('/admin-kategori')}}"> Data Kategori</a>
                        </li>
                        <li
                            style="@if(Request::is('admin-produk')) background-color: #FFC045; @endif border-radius: 10px;">
                            <a href="{{url('/admin-produk')}}"> Data Produk</a>
                        </li>
                    </ul>
                </li>
                <li style="@if(Request::is('admin-stok')) background-color: #FFC045; @endif border-radius: 10px;"><a
                        href="{{url('/admin-stok')}}"><i class="fas fa-dolly"></i> Kontrol Stok</a></li>
                <li style="@if(Request::is('admin-penjualan')) background-color: #FFC045; @endif border-radius: 10px;">
                    <a href="{{url('/admin-penjualan')}}"><i class="fas fa-chart-bar"></i> Penjualan</a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-shopping-cart"></i> Pesanan Online
                        @php
                        $count = \App\Models\Pesanan::whereNull('status')->count();
                        @endphp
                        @if($count > 0)
                        <span class="badge rounded-pill bg-danger" style="background-color: red;">{{ $count }}</span>
                        @endif
                    </a>
                    <a style="float: right; margin-top: -15px; color: white;"><i class="fas fa-caret-down"></i></a>
                    <ul>
                        <li
                            style="@if(Request::is('admin-pesanandiproses')) background-color: #FFC045; @endif border-radius: 10px;">
                            <a href="{{url('/admin-pesanandiproses')}}">Pesanan Diproses
                                @php
                                $count = \App\Models\Pesanan::whereNull('status')->count();
                                @endphp
                                @if($count > 0)
                                <span class="badge rounded-pill bg-danger" style="background-color: red;"> {{ $count }}</span>
                                @endif
                            </a>
                        </li>
                        <li
                            style="@if(Request::is('admin-pesananselesai')) background-color: #FFC045; @endif border-radius: 10px;">
                            <a href="{{url('/admin-pesananselesai')}}">Pesanan Selesai</a>
                        </li>
                        <li
                            style="@if(Request::is('admin-pesananbatal')) background-color: #FFC045; @endif border-radius: 10px;">
                            <a href="{{url('/admin-pesananbatal')}}">Pesanan Batal</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-file-alt"></i> Laporan </a> <a
                        style="float: right; margin-top: -15px; color: white;"><i class="fas fa-caret-down"></i></a>
                    <ul>
                        <li
                            style="@if(Request::is('admin-laporanpenjualan')) background-color: #FFC045; @endif border-radius: 10px;">
                            <a href="{{url('/admin-laporanpenjualan')}}">Laporan Penjualan</a>
                        </li>
                        <li
                            style="@if(Request::is('admin-laporanstok')) background-color: #FFC045; @endif border-radius: 10px;">
                            <a href="{{url('/admin-laporanstok')}}">Laporan Stok Opname</a>
                        </li>
                        <li
                            style="@if(Request::is('admin-laporankeuangan')) background-color: #FFC045; @endif border-radius: 10px;">
                            <a href="{{url('/admin-laporankeuangan')}}">Laporan Keuangan</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
    @stack('scripts')
</body>
</html>