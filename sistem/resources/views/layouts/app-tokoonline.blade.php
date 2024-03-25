<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Apotek Dua Farma</title>
    <link rel="icon" href="sistem\img\logo1.png" type="image">

    <!-- My Own Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('sistem\css\style-tokoonline.css') }}">

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
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bg-body-tertiary shadow rounded">
            <div class="container-fluid">
                <a class="navbar-brand mx-auto" href="#">
                    <img src="sistem/img/logo2.png" alt="Logo" height="40">
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Semua Obat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Obat Keras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Obat Bebas Terbatas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Obat Bebas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Obat Wajib Apotek (OWA)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Obat Over the Counter (OTC)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Vitamin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Obat Herbal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Alat Kesehatan</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            @yield('content')
        </div>
    </div>
</body>

</html>