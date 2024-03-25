@extends('layouts.app')

@section('content')
<nav class="navbar sticky-bottom bg-white fixed-top">
    <div class="container-fluid" style="justify-content: center;">
        <a href="{{ url('/toko-allproduk') }}">All</a>
        <a href="{{ url('/toko-obt') }}">Obat Bebas Terbatas</a>
        <a href="{{ url('/toko-obatbebas') }}">Obat Bebas</a>
        <a href="{{ url('/toko-vitamin') }}">Vitamin</a>
    </div>
</nav>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <form class="d-flex" action="{{url('toko-vitamin')}}" method="GET">
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
                <div class="row justify-content-center">
                    @foreach($produk as $no => $value)
                    @if($value->kategori->nama_kategori == 'Vitamin')
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
                                @if($value->stok == 0)
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
                                    <form method="POST" action="{{url('keranjang-vitamin')}}">
                                        @csrf
                                        <input type="hidden" name="id_produk" value="{{$value->id_produk}}">
                                        <button type="submit" class="btn btn-primary btn-sm ml-2">
                                            <i class="fa fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

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
                                    <a href="{{ url('/ubah-quantity-vitamin?id_produk=' . $value->id_produk . '&act=minus') }}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-minus"></i></a>
                                    @endif
                                    <input type="number" value="{{ $value->qty }}" class="form-control" name="qty"
                                        id="qty-{{ $value->id_produk }}" readonly
                                        style="text-align: center; width: 50px;">
                                    <a href="{{ url('/ubah-quantity-vitamin?id_produk=' . $value->id_produk . '&act=plus') }}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                                </div>
                            </td>
                            <td>Rp. {{ number_format($value->produk->harga_jual) }}</td>
                            <td>Rp. {{ number_format($value->produk->harga_jual*$value->qty) }}</td>
                            <td>
                                <a href="{{url($value->id_kasir.'/hapus-keranjang-vitamin')}}">
                                    <button title="Hapus Data" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash"></i></button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <form method="POST" action="{{ url('simpan-pesanan-vitamin') }}">
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
                                        dilakukan dengan jarak maksimal 15 KM</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">Metode Pembayaran</td>
                                <td colspan="3">
                                    <label><input type="radio" name="metode_pembayaran" value="Tunai" checked>
                                        Tunai</label>
                                    <label><input type="radio" name="metode_pembayaran" value="QRIS">
                                        QRIS</label>
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
    </div>
</div>

@endsection