@extends('layouts.app')

@section('content')

<div class="container">
    @if(auth()->check() && (auth()->user()->level == 'pelanggan'))
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="{{ url('/toko-allproduk') }}" style="text-decoration: none; color: #FFC045;"><i
                    class="fa fa-arrow-left" aria-hidden="true"></i> Kembali ke toko</a>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <a href="{{ url('/pelanggan') }}" style="text-decoration: none; color: #FFC045;">Lihat pesanan <i
                        class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="content" style="margin-top: 50px;">
    <div class="row">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Bagian Kiri -->
                <div class="col-md-5">
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
                    <!-- Jika memilih metode_pengiriman = Diambil -->
                    @if($checkout->metode_pengiriman == "Diambil")
                    <div class="card" style="padding: 20px;">
                        <div clas="title" align="center">
                            <h5 style="color: #FFC045;"><strong>Pengambilan</strong></h5>
                            <p>Silahkan ambil obat pada <strong>Apotek Dua Farma</strong></p>
                            <p style="font-style: italic; color: #E72929;">Obat tidak diambil lebih dari<strong> 2
                                    hari</strong> otomatis pesanan akan dibatalkan</p>
                        </div>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>Jalan Jendral Sudirman No. 6A RT 01 RW 09 Planjan, Kecamatan Kesugihan, Kab.
                                        Cilacap, Provinsi Jawa Tengah</td>
                                </tr>
                                <tr>
                                    <td>Maps</td>
                                    <td>:</td>
                                    <td>
                                        <div class="container-fluid">
                                            <div class="map-responsive">
                                                <iframe
                                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.5561556214234!2d109.08319967372269!3d-7.623175775373578!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e656d5ef62354f1%3A0x16963b8f0cf5cab3!2sApotik%20dua%20farma!5e0!3m2!1sid!2sid!4v1705336554209!5m2!1sid!2sid"
                                                    width="400" height="300" style="border:0;" allowfullscreen=""
                                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <!-- Jika memilih metode_pengiriman = Dikirim -->
                    @if($checkout->metode_pengiriman == "Dikirim")
                    <div class="card" style="padding: 20px;">
                        <div clas="title" align="center">
                            <h5 style="color: #FFC045;"><strong>Pengiriman</strong></h5>
                            <p>Pengiriman hanya bisa dilakukan pada daerah tertentu dalam wilayah kota Cilacap</strong>
                            </p>
                        </div>
                        <form method="POST" action="{{ url('simpan-pengiriman') }}">
                            @csrf
                            <table class="table table-borderless">
                                <tbody>
                                    <input type="hidden" name="id_pesanan" value="{{ $checkout->id_pesanan }}">
                                    <tr>
                                        <td>Alamat Lengkap</td>
                                        <td>:</td>
                                        <td colspan="2"><input type="text" id="alamat" class="form-control"
                                                name="alamat" placeholder="Masukkan alamat yang dituju untuk pengiriman"
                                                required></td>
                                    </tr>
                                    <tr>
                                        <td>Wilayah</td>
                                        <td>:</td>
                                        <td colspan="2">
                                            <select class="form-select" name="id_ongkir" id="id_ongkir"
                                                style="width: 100%; height: 35px; font-size: 13px;" required>
                                                <option disabled selected value>Pilih Wilayah Desa</option>
                                                @foreach ($wilayah as $data)
                                                <option value="{{ $data->id_ongkir }}">{{ $data->wilayah }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="border:none;">
                                            <button type="submit" id="ongkir" class="btn btn-success btn-sm float-right"
                                                style="width: 100%;">Bayar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

                    </div>
                    @endif
                </div>

                <!-- Bagian Kanan -->
                <div class="col-md-5">
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
                    <!-- Jika memilih metode_pembayaran = Tunai -->
                    @if($checkout->metode_pembayaran == "Tunai")
                    <div class="card" style="padding: 20px;">
                        <div clas="title" align="center">
                            <h5 style="color: #FFC045;"><strong>Pembayaran Tunai</strong></h5>
                            <p>Siapkan uang tunai untuk melakukan pembayaran sesuai dengan total pembayaran</p>
                        </div>
                        @if($checkout->id_pesanan)
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>Jumlah</td>
                                    <td>:</td>
                                    <td id="total_bayar" style="text-align:left;">Rp
                                        {{ number_format($checkout->grand_total) }}
                                    </td>
                                    @if(isset($pengiriman) && $pengiriman)
                                    <td>Ongkir</td>
                                    <td>:</td>
                                    <td id="ongkir" style="text-align:left;">Rp {{ number_format($pengiriman->ongkir) }}
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total Bayar</strong></td>
                                    <td>:</td>
                                    <td id="total_bayar" style="text-align:left;"> <strong>
                                            @if(isset($pengiriman) && $pengiriman)
                                            Rp {{ number_format($pengiriman->ongkir + $checkout->grand_total) }}
                                            @else
                                            Rp {{ number_format($checkout->grand_total) }}
                                            @endif
                                            <strong> </td>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </div>
                    @endif
                    <!-- Jika memilih metode_pembayaran = QRIS -->
                    @if($checkout->metode_pembayaran == "QRIS")
                    <div class="card" style="padding: 20px;">
                        <div clas="title" align="center">
                            <h5 style="color: #FFC045;"><strong>Pembayaran QRIS</strong></h5>
                            <p>Silahkan scan kode QR dibawah ini untuk melakukan pembayaran online</p>
                            <p style="font-style: italic; color: #E72929;">Pembayaran menggunakan QRIS tidak dapat
                                dibatalkan</p>
                        </div>
                        @if($checkout->id_pesanan)
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>Jumlah</td>
                                    <td>:</td>
                                    <td id="total_bayar" style="text-align:left;">Rp
                                        {{ number_format($checkout->grand_total) }}
                                    </td>
                                    @if(isset($pengiriman) && $pengiriman)
                                    <td>Ongkir</td>
                                    <td>:</td>
                                    <td id="ongkir" style="text-align:left;">Rp
                                        {{ number_format($pengiriman->ongkir) }}
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total Bayar</strong></td>
                                    <td>:</td>
                                    <td id="total_bayar" style="text-align:left;"> <strong>
                                            @if(isset($pengiriman) && $pengiriman)
                                            Rp {{ number_format($pengiriman->ongkir + $checkout->grand_total) }}
                                            @else
                                            Rp {{ number_format($checkout->grand_total) }}
                                            @endif
                                            <strong> </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td colspan="4" align="center">
                                        <img src="https://github.com/Kikialfaininr/qr/blob/main/frame.png?raw=true"
                                            alt="qris" width="70%" class="d-inline-block align-text-center" />
                                    </td>
                                </tr>
                                <form method="POST" action="{{ url('simpan-bukti') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id_pesanan" value="{{ $checkout->id_pesanan }}">
                                    <tr>
                                        <td>Upload Bukti Pembayaran</td>
                                        <td>:</td>
                                        <td></td>
                                        <td>
                                            <input id="foto" type="file" name="foto" required autofocus>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="border:none;">
                                            <button type="submit" class="btn btn-success btn-sm float-right"
                                                style="width: 100%;">Simpan</button>
                                        </td>
                                    </tr>
                                </form>
                            </tbody>
                        </table>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection