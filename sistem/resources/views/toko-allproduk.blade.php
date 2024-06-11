@extends('layouts.app')

@section('content')
<nav class="navbar sticky-bottom bg-white fixed-top">
    <div class="container-fluid" style="justify-content: center;">
        <a href="{{ url('/toko-allproduk') }}"
            style="{{ request()->is('toko-allproduk') ? 'color: #FFC045;' : '' }}">All</a>
        <a href="{{ url('/toko-obt') }}" style="{{ request()->is('toko-obt') ? 'color: #FFC045;' : '' }}">Obat Bebas
            Terbatas</a>
        <a href="{{ url('/toko-obatbebas') }}"
            style="{{ request()->is('toko-obatbebas') ? 'color: #FFC045;' : '' }}">Obat Bebas</a>
        <a href="{{ url('/toko-vitamin') }}"
            style="{{ request()->is('toko-vitamin') ? 'color: #FFC045;' : '' }}">Vitamin</a>
    </div>
</nav>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <form class="d-flex" action="{{url('toko-allproduk')}}" method="GET">
            <input class="form-control me-2" type="text" name="search" placeholder="Cari produk"
                value="{{$request->search}}">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div> 
    <div class="col-md-4"></div>
</div>

<div class="content" style="margin-top: 50px;">
    <div class="row">
        <div class="col-md-8">
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    Obat Keras tidak boleh dijual belikan tanpa resep dokter, harap membeli langsung
                    pada Apotek
                </div>
                <div class="row justify-content-center">
                    @if($produk->isEmpty())
                        <div class="col-md-12">
                            <div class="alert alert-info" role="alert">
                                Produk tidak ada.
                            </div>
                        </div>
                    @else
                    @foreach($produk as $no => $value)
                    <div class="col-md-3">
                        <div class="card" style="margin-bottom:20px;">
                            <img class="card-img-top" src="images/fotoproduk/{{$value->foto}}" alt="Card image cap"
                                style="width: 100%; height: 150px;">
                            <div class="card-body">
                                <h5 class="card-title">{{$value->nama}}</h5>
                                <p class="card-text" style="color: #999; font-size: smaller;">
                                    <strong>
                                        {{$value->kategori->nama_kategori}} <br>
                                        Rp {{number_format($value->harga_jual)}} / {{$value->bentuk_sediaan}}
                                    </strong>
                                </p>
                                @if(Auth::check() && Auth::user()->level == 'pelanggan')
                                @if($value->kategori->nama_kategori == 'Obat Keras')
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary btn-sm ml-2"
                                        style="background-color: #999;" disabled>
                                        <i class="fa fa-cart-plus"></i>
                                    </button>
                                </div>
                                @elseif($value->stok == 0)
                                <div class="d-flex justify-content-between align-items-center">
                                    <p style="font-style: italic; color: red; font-size: smaller;">Stok habis
                                    </p>
                                    <button type="button" class="btn btn-primary btn-sm ml-2"
                                        style="background-color: #999;" disabled>
                                        <i class="fa fa-cart-plus"></i>
                                    </button>
                                </div>
                                @else
                                <div class="d-flex justify-content-end">
                                    <form method="POST" action="{{url('keranjang')}}">
                                        @csrf
                                        <input type="hidden" name="id_produk" value="{{$value->id_produk}}">
                                        <button type="submit" class="btn btn-primary btn-sm ml-2">
                                            <i class="fa fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                                @else
                                @if($value->stok == 0)
                                <div class="d-flex justify-content-between align-items-center">
                                    <p style="font-style: italic; color: red; font-size: smaller;">Stok habis
                                    </p>
                                </div>
                                @endif
                                <button type="button" class="btn btn-primary btn-sm ml-2"
                                    style="background-color: #999;" disabled>
                                    <i class="fa fa-cart-plus"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

        @if(Auth::check() && Auth::user()->level == 'pelanggan')
        <div class="col-md-4">
            <div class="card">
                @if (session()->has('message'))
                @php
                $alertClass = session('alert_class', 'success');
                @endphp

                <div class="alert alert-{{ $alertClass }}">
                    {{ session('message') }}
                </div>
                @endif

                @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <table class="table table-striped table-hover" style="font-size: smaller;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">QTY</th>
                            <th scope="col">Harga/QTY</th>
                            <th scope="col" style="width: 200px;">Total</th>
                            <th scope="col" style="width: 10px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasir as $no => $value)
                        <tr>
                            <td align="center">{{$no+1}}</td>
                            <td>{{$value->produk->nama}}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($value->qty > 1)
                                    <a href="{{ url('/ubah-quantity?id_produk=' . $value->id_produk . '&act=minus') }}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-minus"></i></a>
                                    @endif
                                    <input type="number" value="{{ $value->qty }}" class="form-control" name="qty"
                                        id="qty-{{ $value->id_produk }}" readonly
                                        style="text-align: center; width: 50px;">
                                    <a href="{{ url('/ubah-quantity?id_produk=' . $value->id_produk . '&act=plus') }}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                                </div>
                            </td>
                            <td>Rp. {{ number_format($value->produk->harga_jual) }}</td>
                            <td>Rp. {{ number_format($value->produk->harga_jual*$value->qty) }}</td>
                            <td>
                                <a href="{{url($value->id_kasir.'/hapus-keranjang')}}">
                                    <button title="Hapus Data" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash"></i></button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <form method="POST" action="{{ url('simpan-pesanan') }}">
                        @csrf
                        <tfoot>
                            <tr>
                                <td colspan="3">Total</td>
                                <td colspan="3">
                                    Rp {{ number_format($kasir->sum('total')) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">Metode Pengambilan</td>
                                <td colspan="3">
                                    <label><input type="radio" name="metode_pengiriman" value="Diambil" checked>
                                        Diambil di Apotek</label>
                                    <label><input type="radio" name="metode_pengiriman" value="Dikirim">
                                        Dikirim</label>
                                    <br><br>
                                    <p style="font-style: italic; color: #808080;">Catatan: pengiriman hanya bisa
                                        dilakukan dalam wilayah Cilacap</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">Metode Pembayaran</td>
                                <td colspan="3">
                                    <label><input type="radio" name="metode_pembayaran" value="Tunai" checked>
                                        Tunai</label>
                                    <label><input type="radio" name="metode_pembayaran" value="QRIS">
                                        QRIS</label>
                                        <br><br>
                                    <p style="font-style: italic; color: #808080;" id="keterangan"></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:none;"></td>
                            </tr>
                            <tr>
                                <td colspan="6" style="border:none;">
                                    <button type="submit" class="btn btn-success btn-sm float-right"
                                        style="width: 100%;">Checkout</button>
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </form>
                </table>
            </div>
        </div>
        @elseif(Auth::check() && Auth::user()->level != 'pelanggan')
        <div class="col-md-4">
            <div class="alert alert-danger">
                Maaf, {{ Auth::user()->name }} tidak diperbolehkan melakukan pemesanan online.
                <br><br>
                <a href="{{ route('logout') }}" class="btn btn-primary" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        @else
        <div class="col-md-4">
            <div class="alert alert-warning">
                <h5 class="card-title">Selamat Datang!</h5>
                <p class="card-text">Untuk dapat melakukan pemesanan online, harap login atau daftar terlebih
                    dahulu jika belum memiliki akun.</p>
                <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
                <a href="{{ url('/register') }}" class="btn btn-secondary">Daftar</a>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    // Fungsi untuk menangani perubahan pada radio button metode pengambilan
    function handleMetodePengambilanChange() {
        // Mendapatkan elemen radio button metode pengambilan yang dipilih
        var metodePengambilan = document.querySelector('input[name="metode_pengiriman"]:checked').value;

        // Mendapatkan elemen radio button metode pembayaran
        var metodePembayaranRadio = document.getElementsByName("metode_pembayaran");
        var keterangan = document.getElementById("keterangan");

        // Jika metode pengambilan adalah "Dikirim", maka atur metode pembayaran ke "QRIS" dan nonaktifkan pilihan tunai
        if (metodePengambilan === "Dikirim") {
            for (var i = 0; i < metodePembayaranRadio.length; i++) {
                if (metodePembayaranRadio[i].value === "Tunai") {
                    metodePembayaranRadio[i].disabled = true;
                }
            }
            document.querySelector('input[value="QRIS"]').checked = true; // Set metode pembayaran ke QRIS
            keterangan.textContent = "Produk dikirim hanya bisa menerima pembayaran QRIS.";
        } else {
            // Jika metode pengambilan bukan "Dikirim", aktifkan kembali opsi pembayaran tunai
            for (var i = 0; i < metodePembayaranRadio.length; i++) {
                if (metodePembayaranRadio[i].value === "Tunai") {
                    metodePembayaranRadio[i].disabled = false;
                }
            }
            keterangan.textContent = "";
        }
    }

    // Menambahkan event listener untuk perubahan pada radio button metode pengambilan
    var radioMetodePengambilan = document.getElementsByName("metode_pengiriman");
    for (var i = 0; i < radioMetodePengambilan.length; i++) {
        radioMetodePengambilan[i].addEventListener('change', handleMetodePengambilanChange);
    }

    // Memanggil fungsi handleMetodePengambilanChange() saat halaman dimuat untuk menetapkan opsi pembayaran awal
    window.addEventListener('load', handleMetodePengambilanChange);
</script>

@endsection