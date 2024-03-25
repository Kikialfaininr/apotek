@extends('layouts.app-kasir')
@extends('layouts.alert')

@section('content')
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
                            <button class="nav-link active" id="masuk-tab" data-bs-toggle="tab" data-bs-target="#masuk"
                                type="button" role="tab" aria-controls="masuk" aria-selected="true">Masuk</button>
                            <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai"
                                type="button" role="tab" aria-controls="selesai" aria-selected="false">Selesai</button>
                            <button class="nav-link" id="batal-tab" data-bs-toggle="tab" data-bs-target="#batal"
                                type="button" role="tab" aria-controls="batal" aria-selected="false">Batal</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="masuk" role="tabpanel" aria-labelledby="masuk-tab"
                            tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Online Masuk</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive" style="margin-top: 20px;">
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
                                        @php
                                        $no = 0;
                                        @endphp
                                        @forelse($pesanan as $value)
                                        @if(in_array($value->status, ['Siap', 'Dikirim']) || is_null($value->status))
                                        @php
                                        $no++;
                                        @endphp
                                        <tr>
                                            <td align="center">{{$no+1}}</td>
                                            <td align="center">{{$value->created_at}}</td>
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
                                        @empty
                                        <tr>
                                            <td colspan="12" align="center">Data tidak ditemukan</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li class="page-item {{ $pesanan->currentPage() == 1 ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $pesanan->previousPageUrl() }}"
                                                    aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            @for ($i = 1; $i <= $pesanan->lastPage(); $i++)
                                                <li
                                                    class="page-item {{ $pesanan->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $pesanan->url($i) }}">{{ $i }}</a>
                                                </li>
                                                @endfor
                                                <li
                                                    class="page-item {{ $pesanan->currentPage() == $pesanan->lastPage() ? 'disabled' : '' }}">
                                                    <a class="page-link" href="{{ $pesanan->nextPageUrl() }}"
                                                        aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab"
                            tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Online Selesai</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="col-md-8" style="margin: 20px 0 10px 0;">
                                <a href="{{url('download-pesananonline')}}" target="_blank">
                                    <button class="btn btn-danger">
                                        <i class='fas fa-file-pdf'></i> Cetak Pesanan Online
                                    </button>
                                </a>
                                <a href="{{url('download-detailonline')}}" target="_blank">
                                    <button class="btn btn-danger">
                                        <i class='fas fa-file-pdf'></i> Cetak Produk Online Terjual
                                    </button>
                                </a>
                            </div>
                            <div class="table-responsive">
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
                                            <td align="center" style="background-color: green; color: white;">
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
                                        @if ($no == 0)
                                        <tr>
                                            <td colspan="12" align="center">Data tidak ditemukan</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="batal" role="tabpanel" aria-labelledby="batal-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Pesanan Online Batal</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive" style="margin-top: 20px;">
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
                                        @if ($value->status == 'Ditolak' || $value->status == 'Batal')
                                        <tr>
                                            <td align="center">{{ ++$no }}</td>
                                            <td align="center">{{ $value->created_at }}</td>
                                            <td align="center">{{ $value->no_order }}</td>
                                            <td align="center">Rp. {{ number_format($value->grand_total) }}</td>
                                            <td align="center">{{ $value->metode_pengiriman }} </td>
                                            <td align="center">{{ $value->metode_pembayaran }} </td>
                                            <td align="center" style="@if ($value->status == 'Ditolak') background-color: red;
                                                    @elseif ($value->status == 'Batal') background-color: darkred;
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
                @if(in_array($value->status, ['Siap', 'Dikirim']) || is_null($value->status))
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
                                    <td>
                                        <form action="{{ url('update-status') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                            <input type="hidden" name="status" value="Dikirim">
                                            <button type="submit" class="btn btn-secondary">Dikirim</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ url('update-status') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pesanan_id" value="{{ $value->id_pesanan }}">
                                            <input type="hidden" name="status" value="Selesai">
                                            <button type="submit" class="btn btn-success">Selesai</button>
                                        </form>
                                    </td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection