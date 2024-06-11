@extends('layouts.app-kasir')
@extends('layouts.alert')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'apoteker'))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <form action="{{ url('kasir-riwayatpesananonline') }}" method="GET" class="w-100">
                        <div class="d-flex align-items-center">
                            <label for="tanggal" class="form-label me-2">Tanggal:</label>
                            <input type="date" class="form-control me-2" id="tanggal" name="tanggal">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            @if(isset($tanggal))
                            <a href="{{ url('kasir-riwayatpesananonline') }}" class="btn btn-secondary ms-2">All</a>
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
                            <button class="nav-link active" id="invoice-tab" data-bs-toggle="tab"
                                data-bs-target="#invoice" type="button" role="tab" aria-controls="invoice"
                                aria-selected="true">Invoice Penjualan</button>
                            <button class="nav-link" id="produkterjual-tab" data-bs-toggle="tab"
                                data-bs-target="#produkterjual" type="button" role="tab" aria-controls="produkterjual"
                                aria-selected="false">Produk Terjual</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="invoice" role="tabpanel"
                            aria-labelledby="invoice-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Online</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="col-md-8" style="margin-bottom: 10px;">
                                <a href="{{url('download-riwayatpesanan')}}" target="_blank">
                                    <button class="btn btn-danger">
                                        <i class='fas fa-file-pdf'></i> Cetak
                                    </button>
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="example1" class="table table-responsive table-striped table-hover table-bordered small">
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

                        <div class="tab-pane fade" id="produkterjual" role="tabpanel" aria-labelledby="produkterjual-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Produk Terjual</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="col-md-8" style="margin-bottom: 10px;">
                                <a href="{{url('download-riwayatdetail')}}" target="_blank">
                                    <button class="btn btn-danger">
                                        <i class='fas fa-file-pdf'></i> Cetak
                                    </button>
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="example2" class="table table-responsive table-striped table-hover table-bordered small" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">No Order</th>
                                            <th class="text-center">Produk</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 0 @endphp
                                        @foreach($detail as $value)
                                        @if ($value->pesanan->status == 'Selesai')
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->updated_at }}</td>
                                            <td align="center">{{ $value->pesanan->no_order }}</td>
                                            <td align="center">{{ $value->produk->nama }}</td>
                                            <td align="center">Rp. {{ number_format($value->produk->harga_jual) }}</td>
                                            <td align="center">{{ $value->qty }} </td>
                                            <td align="center">Rp {{ number_format($value->total) }} </td>
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
@endpush

@else
<?php abort(403, 'Unauthorized action.'); ?>
@endif

@endsection