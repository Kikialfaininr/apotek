@extends('layouts.app-admin')
@extends('layouts.alert')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'admin' || auth()->user()->level == 'owner'))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ url('admin-pesanandiproses') }}" method="GET" class="w-100">
                                <div class="d-flex align-items-center">
                                    <label for="tanggal" class="form-label me-2">Tanggal:</label>
                                    <input type="date" class="form-control me-2" id="tanggal" name="tanggal">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    @if(isset($tanggal))
                                    <a href="{{ url('admin-pesanandiproses') }}" class="btn btn-secondary ms-2">All</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
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
                                aria-selected="true">Belum diproses</button>
                            <button class="nav-link" id="siap-tab" data-bs-toggle="tab" data-bs-target="#siap"
                                type="button" role="tab" aria-controls="siap" aria-selected="true">Siap</button>
                            <button class="nav-link" id="siap-tab" data-bs-toggle="tab" data-bs-target="#dikirim"
                                type="button" role="tab" aria-controls="siap" aria-selected="true">Dikirim</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="diproses" role="tabpanel"
                            aria-labelledby="diproses-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Belum Diproses</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive" style="margin-top: 20px;">
                                <table id="example1" class="table table-responsive table-striped table-hover table-bordered">
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
                                                    title="Detail Pesanan">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm">
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
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive" style="margin-top: 20px;">
                                <table id="example2" class="table table-responsive table-striped table-hover table-bordered" style="width: 100%;">
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
                                            <td align="center" style="background-color: blue; color: white;">
                                                {{ $value->status }}</td>
                                            <td align="center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{$value->id_pesanan}}"
                                                    title="Detail Pesanan">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm">
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
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive" style="margin-top: 20px;">
                                <table id="example3" class="table table-responsive table-striped table-hover table-bordered" style="width: 100%;">
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
                                                    title="Detail Pesanan">
                                                    Detail
                                                </button>
                                                <a href="{{url($value->id_pesanan.'/invoice-pesananonline')}}"
                                                    target="_blank">
                                                    <button class="btn btn-danger btn-sm">
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
@endpush

@else
<?php abort(403, 'Unauthorized action.'); ?>
@endif

@endsection