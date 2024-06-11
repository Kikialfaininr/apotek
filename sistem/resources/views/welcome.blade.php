@extends('layouts.app')

@section('content')
<div class="content title"
    style="background-image: linear-gradient(to right, #34455B, rgba(52, 69, 91, 0)), url('sistem/img/bg.jpg'); margin-top: -25px; border-radius: 0 0 50% 20%;">
    <p class="big-text" style="margin: 50px 50px 0 50px;">
        Apotek <br>
        Dua Farma
    </p>
    <p style="margin: 0 50px;">
        Selalu siap melayani dan memberikan solusi terbaik untuk <br> segala kebutuhan kesehatan Anda.
    </p>
    <a class="btn btn-light" href="{{ url('/toko-allproduk') }}">
        <h6><i class="fas fa-store"></i> Pesan</h6>
    </a>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4 center-dist">
            <h1>
                Produk Kami
            </h1>
        </div>
        <div class="col" style="margin: 30px 0 0 -120px;">
            <div class="garis-warna">
            </div>
        </div>
    </div>
</div>

<div class="container container-item">
    <div class="row">
        <div class="col" onclick="window.location.href='{{ url('/toko-allproduk') }}';">
            <i class="fa fa-mortar-pestle fa-3x"></i>
            <h4>Obat Keras</h4>
            <p>Obat yang hanya boleh dibeli menggunakan resep dokter.</p>
        </div>
        <div class="col" onclick="window.location.href='{{ url('/toko-obt') }}';">
            <i class="fa fa-tablets fa-3x"></i>
            <h4>Obat Bebas Terbatas</h4>
            <p>Obat yang dapat dibeli secara bebas tanpa menggunakan resep dokter, namun mempunyai peringatan khusus
                saat menggunakannya.</p>
        </div>
        <div class="col" onclick="window.location.href='{{ url('/toko-obatbebas') }}';">
            <i class="fa fa-pills fa-3x"></i>
            <h4>Obat Bebas</h4>
            <p>Obat yang bisa dibeli bebas di apotek, bahkan di warung, tanpa resep dokter.</p>
        </div>
        <div class="col" onclick="window.location.href='{{ url('/toko-vitamin') }}';">
            <i class="fa fa-prescription-bottle fa-3x"></i>
            <h4>Vitamin</h4>
            <p> Nutrisi tambahan yang diperlukan bagi tubuh untuk bisa menunjang kinerja tubuh.</p>
        </div>
    </div>
</div>

<div class="container container-receipt">
    <div class="row">
        <div class="col center-dist receipt-bg">
            <h6 class="receipt-text">
                Daftarkan akun Anda sekarang untuk mendapatkan akses eksklusif cek harga obat terbaik apotek kami dan pesan obat secara online dengan mudah di website kami!
            </h6>
            <div class="text-end receipt-button">
                <a class="btn btn-light" href="{{ route('register') }}">
                    <h6><i class="fa fa-user"></i> Daftar sekarang</h6>
                </a>
            </div>
        </div>
        <div class="col thrid receipt-img">
            <img src="{{ asset('sistem/img/apotek-online.jpg') }}" class="receipt-image" />
        </div>
    </div>
</div>

<div class="container" id="carapesan">
    <div class="row">
        <div class="col-md-6 center-dist">
            <h1>
                Cara Pemesanan Online
            </h1>
        </div>
        <div class="col" style="margin: 30px 0 0 -110px;">
            <div class="garis-warna">
            </div>
        </div>
    </div>
</div>

<div class="container container-pesan">
    <div class="row">
        <div class="col">
            <h1>01</h1>
            <h5>Daftar atau masuk pada akun pelanggan.</h5>
        </div>
        <div class="col">
            <h1>02</h1>
            <h5>Cari produk pada halaman produk dan pilih produk serta kuantitas.</h5>
        </div>
        <div class="col">
            <h1>03</h1>
            <h5>Pastikan semua produk yang dipesan terdapat dalam list pesanan dan klik pesan.</h5>
        </div>
        <div class="col">
            <h1>04</h1>
            <h5>Pilih jenis pengiriman dan jenis pembayaran.</h5>
        </div>
    </div>
</div>
<div class="container container-pesan">
    <div class="row">
        <div class="col">
            <h1>05</h1>
            <h5>Jika memilih dikirimkan, maka isikan data alamat dan jarak dari apotek.</h5>
        </div>
        <div class="col">
            <h1>06</h1>
            <h5>Jika memilih diambil, maka ambil secara langsung produk yang dipesan di Apotek Dua Farma dengan menunjukan bukti pemesanan.</h5>
        </div>
        <div class="col">
            <h1>07</h1>
            <h5>Jika memilih jenis pembayaran langsung, maka berikan uang tunai saat menerima produk.</h5>
        </div>
        <div class="col">
            <h1>08</h1>
            <h5>Jika memilih jenis pembayaran melalui QRIS, maka scan QRIS dan bayarkan sesuai dengan total pembayaran, jika telah selesai unggah bukti transaksi.</h5>
        </div>
    </div>
</div>

@endsection