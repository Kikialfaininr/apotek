@extends('layouts.app-admin')
@extends('layouts.alert')

@section('content')
<div class="card card-data col-md-12">
    <h1 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">Pesanan Online Selesai
        Diproses</h1>
    @if(isset($tanggal))
    <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
    @endif
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="row" style="margin: 10px;">
                <div class="col-md-8">
                    <a href="{{url('downloadpesanan')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak Pesanan Online
                        </button>
                    </a>
                    <a href="{{url('downloadpesanandetail')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak Produk Online Terjual
                        </button>
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="{{ url('admin-pesananselesai') }}" method="GET" class="w-100">
                        <div class="d-flex align-items-center">
                            <input type="date" class="form-control me-2" id="tanggal" name="tanggal">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            @if(isset($tanggal))
                            <a href="{{ url('admin-pesananselesai') }}" class="btn btn-secondary ms-2">All</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive" style="width: 97%; margin-left: 15px;">
            <table class="table table-responsive table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Waktu</th>
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
                        <td align="center">{{ $value->created_at }}</td>
                        <td align="center">{{ $value->no_order }}</td>
                        <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                        <td align="center">{{ $value->metode_pengiriman }} </td>
                        <td align="center">{{ $value->metode_pembayaran }} </td>
                        <td align="center" style="background-color: green; color: white;">{{ $value->status }}</td>
                        <td align="center">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#detail{{$value->id_pesanan}}" title="Detail Pesanan">
                                Detail
                            </button>
                            <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}" target="_blank">
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-file-invoice"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @if ($no == 0)
                    <tr>
                        <td colspan="12" align="center">Data tidak ditemukan</td>
                    </tr>
                    @endif
                </tbody>
            </table>
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
                            <td colspan="2">Jarak</td>
                            <td>{{ $kirim->jarak }} KM</td>
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
                                @else
                                <form action="{{ url('konfirmasi-pembayaran') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="bukti_pembayaran_id" value="{{ $bukti->id_bukti }}">
                                    <button type="submit" class="btn btn-warning">Konfirmasi Pembayaran</button>
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
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection