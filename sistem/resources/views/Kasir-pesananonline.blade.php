@extends('layouts.app-kasir')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'apoteker'))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <form action="{{ url('kasir-pesananonline') }}" method="GET" class="w-100">
                        <div class="d-flex align-items-center">
                            <label for="tanggal" class="form-label me-2">Tanggal:</label>
                            <input type="date" class="form-control me-2" id="tanggal" name="tanggal">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            @if(isset($tanggal))
                            <a href="{{ url('kasir-pesananonline') }}" class="btn btn-secondary ms-2">All</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="diproses-tab" data-bs-toggle="tab"
                                data-bs-target="#diproses" type="button" role="tab" aria-controls="diproses"
                                aria-selected="true">Diproses</button>
                            <button class="nav-link" id="siap-tab" data-bs-toggle="tab" data-bs-target="#siap"
                                type="button" role="tab" aria-controls="siap" aria-selected="true">Siap</button>
                            <button class="nav-link" id="siap-tab" data-bs-toggle="tab" data-bs-target="#dikirim"
                                type="button" role="tab" aria-controls="siap" aria-selected="true">Dikirim</button>
                            <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai"
                                type="button" role="tab" aria-controls="selesai" aria-selected="false">Selesai</button>
                            <button class="nav-link" id="batal-tab" data-bs-toggle="tab" data-bs-target="#batal"
                                type="button" role="tab" aria-controls="batal" aria-selected="false">Dibatalkan</button>
                        </div>
                    </nav>
                    <div style="margin-top: 20px;">
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
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="diproses" role="tabpanel"
                            aria-labelledby="diproses-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Diproses</h3>
                            <div class="table-responsive" style="margin-top: 20px;">
                                <table id="example1"
                                    class="table table-responsive table-striped table-hover table-bordered small">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 0;
                                        @endphp
                                        @forelse($pesanan as $value)
                                        @if(is_null($value->status))
                                        @php
                                        $no++;
                                        @endphp
                                        <tr>
                                            <td align="center">{{$no+1}}</td>
                                            <td align="center">{{$value->updated_at}}</td>
                                            <td align="center">
                                                @if ($value->pelanggan)
                                                {{$value->pelanggan->name}}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td align="center">{{$value->no_order}}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center" style="@if ($value->status == 'Ditolak') background-color: red;
                                                    @elseif ($value->status == 'Siap') background-color: blue;
                                                    @elseif ($value->status == 'Dikirim') background-color: gray;
                                                    @elseif ($value->status == 'Selesai') background-color: green;
                                                    @elseif (is_null($value->status)) background-color: #FFC700;
                                                    @endif; color: white;">
                                                @if (is_null($value->status))
                                                Belum Diproses
                                                @else
                                                {{ $value->status }}
                                                @endif
                                            </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan"
                                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm"  style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="siap" role="tabpanel" aria-labelledby="siap-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Siap</h3>
                            <p style="color: #B4B4B8; text-align: center;">Pesanan siap diambil di Apotek Dua Farma</p>
                            <div class="table-responsive">
                                <table id="example2"
                                    class="table table-responsive table-striped table-hover table-bordered small"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0 @endphp
                                        @foreach($pesanan as $value)
                                        @if ($value->status == 'Siap')
                                        @php
                                        // Hitung selisih hari
                                        $createdDate = \Carbon\Carbon::parse($value->updated_at);
                                        $now = \Carbon\Carbon::now();
                                        $differenceInDays = $createdDate->diffInDays($now);
                                        @endphp
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->updated_at }}</td>
                                            <td align="center">
                                                @if ($value->pelanggan)
                                                {{$value->pelanggan->name}}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td align="center">{{ $value->no_order }}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center"
                                                style="max-width: 150px; @if ($value->metode_pengiriman == 'Diambil' && $differenceInDays > 2) background-color: #E72929; color: white; @else background-color: blue; color: white; @endif">
                                                {{ $value->status }}
                                                @if ($value->metode_pengiriman == 'Diambil' && $differenceInDays > 2)
                                                <hr>
                                                <p style="font-style: italic; font-size: smaller;">Pesanan tidak diambil
                                                    dalam 2 hari, batalkan!</p>
                                                @endif
                                            </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan"
                                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="dikirim" role="tabpanel" aria-labelledby="dikirim-tab"
                            tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Dikirim</h3>
                            <p style="color: #B4B4B8; text-align: center;">Pesanan anda sedang dikirim, silahkan tunggu!
                            </p>
                            <div class="table-responsive">
                                <table id="example3"
                                    class="table table-responsive table-striped table-hover table-bordered small"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0 @endphp
                                        @foreach($pesanan as $value)
                                        @if ($value->status == 'Dikirim')
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->updated_at }}</td>
                                            <td align="center">
                                                @if ($value->pelanggan)
                                                {{$value->pelanggan->name}}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td align="center">{{ $value->no_order }}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center" style="background-color: gray; color: white;">
                                                {{ $value->status }}</td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan"
                                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab"
                            tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Online Selesai</h3>
                            <div class="table-responsive">
                                <table id="example4"
                                    class="table table-responsive table-striped table-hover table-bordered small"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0 @endphp
                                        @foreach($pesanan as $value)
                                        @if ($value->status == 'Selesai')
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->updated_at }}</td>
                                            <td align="center">
                                                @if ($value->pelanggan)
                                                {{$value->pelanggan->name}}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td align="center">{{ $value->no_order }}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center" style="background-color: green; color: white;">
                                                {{ $value->status }}</td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan"
                                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="batal" role="tabpanel" aria-labelledby="batal-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Dibatalkan</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive" style="margin-top: 20px;">
                                <table id="example5"
                                    class="table table-responsive table-striped table-hover table-bordered small"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pengiriman</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0 @endphp
                                        @foreach($pesanan as $value)
                                        @if ($value->status == 'Ditolak' || $value->status == 'Dibatalkan')
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->updated_at }}</td>
                                            <td align="center">
                                                @if ($value->pelanggan)
                                                {{$value->pelanggan->name}}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td align="center">{{ $value->no_order }}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center" style="@if ($value->status == 'Ditolak') background-color: red;
                                                    @elseif ($value->status == 'Dibatalkan') background-color: darkred;
                                                    @endif; color: white;">{{ $value->status }}
                                            </td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($pesanan as $no => $value)
<div class="modal" id="detail{{$value->id_pesanan}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pesanan</h4>
            </div>
            <div class="modal-body">
                <table class="table table-responsive table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">QTY</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $counter = 0;
                        $last_order_id = null;
                        @endphp

                        @foreach($pesananDetail as $no => $detail)
                        @if($detail->id_pesanan != $last_order_id)
                        @php
                        $counter = 1;
                        $last_order_id = $detail->id_pesanan;
                        @endphp
                        @endif

                        @if($detail->id_pesanan == $value->id_pesanan)
                        <tr>
                            <td align="center">{{$counter}}</td>
                            <td align="center">{{$detail->produk->nama}}</td>
                            <td align="center">Rp. {{ number_format($detail->produk->harga_jual) }}</td>
                            <td align="center">{{$detail->qty}}</td>
                            <td align="center">Rp. {{ number_format($detail->total) }}</td>
                        </tr>
                        @php $counter++; @endphp
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2" style="background-color: #EEEEEE"><strong>Pengiriman</strong></td>
                            <td style="background-color: #EEEEEE"><strong>{{ $value->metode_pengiriman }}</strong>
                            </td>
                        </tr>
                        @foreach($pengiriman as $no => $kirim)
                        @if($kirim->id_pesanan == $value->id_pesanan)
                        <tr>
                            <td colspan="2">Alamat</td>
                            <td>{{ $kirim->alamat }} </td>
                        </tr>
                        <tr>
                            <td colspan="2">Wilayah</td>
                            <td>{{ $kirim->wilayah }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Ongkir</td>
                            <td>{{ $kirim->ongkir }} </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2" style="background-color: #EEEEEE"><strong>Pembayaran</strong></td>
                            <td style="background-color: #EEEEEE"><strong>{{ $value->metode_pembayaran }}</strong>
                            </td>
                        </tr>
                        @foreach($buktiPembayaran as $no => $bukti)
                        @if($bukti->id_pesanan == $value->id_pesanan)
                        <tr>
                            <td colspan="2">Bukti Pembayaran</td>
                            <td><a href="images/buktipembayaran/{{$bukti->foto}}" target="_blank"><img
                                        src="images/buktipembayaran/{{$bukti->foto}}" width="100px"></a></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                @if ($bukti->konfirmasi == 'Terkonfirmasi')
                                <strong><i class="fa fa-check"></i> Terkonfirmasi</strong>
                                @elseif ($bukti->konfirmasi == 'Ditolak')
                                <strong><i class="fa fa-times"></i> Bukti Ditolak</strong>
                                @else
                                <form action="{{ url('konfirmasi-pembayaran') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="bukti_pembayaran_id" value="{{ $bukti->id_bukti }}">
                                    <input type="hidden" name="status" value="Terkonfirmasi">
                                    <button type="submit" class="btn btn-warning">Konfirmasi Pembayaran</button>
                                </form>
                                <form action="{{ url('konfirmasi-pembayaran') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="bukti_pembayaran_id" value="{{ $bukti->id_bukti }}">
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button type="submit" class="btn btn-danger">Tolak Bukti</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        @foreach($pengiriman as $no => $kirim)
                        @if($kirim->id_pesanan == $value->id_pesanan)
                        <tr>
                            <td colspan="2" style="background-color: #EEEEEE"><strong>Total Pembayaran</strong></td>
                            <td style="background-color: #EEEEEE"><strong>Rp
                                    {{ number_format($kirim->ongkir + $value->grand_total) }}</strong>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                @foreach($buktiPenerimaan as $no => $penerimaan)
                @if($penerimaan->id_pesanan == $value->id_pesanan)
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="3" style="background-color: #EEEEEE;">
                                <strong>Bukti Penerimaan Pelanggan</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Bukti Penerimaan</td>
                            <td><a href="images/buktipenerimaan/{{$penerimaan->foto}}" target="_blank">
                                    <img src="images/buktipenerimaan/{{$penerimaan->foto}}" width="100px"></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endif
                @endforeach

                <!-- Jika pesanan belum diproses dan QRIS (Harus konfirmasi pembayaran dahulu) -->
                @if(is_null($value->status) && $value->metode_pembayaran == "QRIS")
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <table class="table table-responsive table-borderless">
                                @php $bukti_pembayaran_ada = false; @endphp
                                @foreach($buktiPembayaran as $no => $bukti)
                                @if($bukti->id_pesanan == $value->id_pesanan)
                                @php $bukti_pembayaran_ada = true; @endphp
                                <tbody>
                                    @if ($bukti->konfirmasi == 'Terkonfirmasi')
                                    <tr>
                                        <td>
                                            <form action="{{ url('update-status') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ url('update-status') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                                <input type="hidden" name="status" value="Siap">
                                                <button type="submit" class="btn btn-primary">Siap</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @elseif ($bukti->konfirmasi == 'Ditolak')
                                    <tr>
                                        <td colspan="2">
                                            <p style="font-style: italic; color: #E72929;">Bukti pembayaran ditolak,
                                                lakukan penolakan pesanan online segera!</p>
                                        </td>
                                        <td>
                                            <form action="{{ url('update-status') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="2">
                                            <p style="font-style: italic; color: #E72929;">Lakukan konfirmasi bukti
                                                pembayaran dahulu sebelum memproses pesanan
                                                online!</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                                @endif
                                @endforeach
                                @if (!$bukti_pembayaran_ada)
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <p style="font-style: italic; color: #E72929;">Pelanggan tidak menyertakan
                                                bukti pembayaran,
                                                tolak pesanan!</p>
                                        </td>
                                        <td>
                                            <form action="{{ url('update-status') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Jika pesanan belum diproses dan tunai (tolak atau siap) -->
                @elseif(is_null($value->status) && $value->metode_pembayaran == "Tunai")
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <table class="table table-responsive table-borderless">
                                <tbody>
                                    <td>
                                        <form action="{{ url('update-status') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ url('update-status') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                            <input type="hidden" name="status" value="Siap">
                                            <button type="submit" class="btn btn-primary">Siap</button>
                                        </form>
                                    </td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Jika pesanan siap dan dikirim (dikirim)-->
                @elseif($value->status == "Siap" && $value->metode_pengiriman == "Dikirim")
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <form action="{{ url('update-status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                <input type="hidden" name="status" value="Dikirim">
                                <button type="submit" class="btn btn-secondary">Dikirim</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Jika pesanan siap dan diambil (jika lebih dari 2 hari maka pesanan dibatalkan) -->
                @elseif($value->status == "Siap" && $value->metode_pengiriman == "Diambil")
                @php
                $createdDate = \Carbon\Carbon::parse($value->updated_at);
                $now = \Carbon\Carbon::now();
                $differenceInDays = $createdDate->diffInDays($now);
                @endphp
                @if ($differenceInDays > 2)
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <form action="{{ url('update-status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                <input type="hidden" name="status" value="Ditolak">
                                <button type="submit" class="btn btn-danger">Tolak</button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <form action="{{ url('update-status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                <input type="hidden" name="status" value="Selesai">
                                <button type="submit" class="btn btn-success">Selesai</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @elseif($value->status == "Dikirim")
                @php
                $adaBuktiPenerimaan = false;
                @endphp
                @foreach($buktiPenerimaan as $no => $penerimaan)
                @if($penerimaan->id_pesanan == $value->id_pesanan)
                @php
                $adaBuktiPenerimaan = true;
                @endphp
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="3" style="background-color: #EEEEEE; font-style: italic; color: #E72929;">
                                <strong>Jika pelanggan tidak konfirmasi penerimaan selama 3 hari, selesaikan pesanan
                                    dengan upload bukti penerimaan!</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Bukti Penerimaan</td>
                            <td><a href="images/buktipenerimaan/{{$penerimaan->foto}}" target="_blank">
                                    <img src="images/buktipenerimaan/{{$penerimaan->foto}}" width="100px"></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <form action="{{ url('update-status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                <input type="hidden" name="status" value="Selesai">
                                <button type="submit" class="btn btn-success">Selesai</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach

                @php
                $created_at = \Carbon\Carbon::parse($value->created_at);
                $now = \Carbon\Carbon::now();
                $diffInDays = $created_at->diffInDays($now);
                @endphp

                @if(!$adaBuktiPenerimaan)
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="3" style="background-color: #EEEEEE; font-style: italic; color: #E72929;">
                                <strong>Jika pelanggan tidak konfirmasi penerimaan selama 3 hari, selesaikan pesanan
                                    dengan upload bukti penerimaan!</strong>
                            </td>
                        </tr>
                        <form method="POST" action="{{ url('simpan-penerimaan') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_pesanan" value="{{ $value->id_pesanan }}">
                            <tr>
                                <td colspan="2">Upload Bukti Penerimaan</td>
                                <td>
                                    <input id="foto" type="file" name="foto" required autofocus
                                        {{ $diffInDays < 3 ? 'disabled' : '' }}> <br><br>
                                    <button type="submit" class="btn btn-success btn-sm float-right"
                                        style="width: 100%;" {{ $diffInDays < 3 ? 'disabled' : '' }}>Simpan</button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <form action="{{ url('update-status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                <input type="hidden" name="status" value="Selesai">
                                <button type="submit" class="btn btn-success" disabled>Selesai</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
new DataTable('#example1', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
<script>
new DataTable('#example2', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
<script>
new DataTable('#example3', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
<script>
new DataTable('#example4', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
<script>
new DataTable('#example5', {
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
});
</script>
@endpush

@else
<?php abort(403, 'Unauthorized action.'); ?>
@endif

@endsection