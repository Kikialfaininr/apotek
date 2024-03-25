@extends('layouts.app-admin')
@extends('layouts.alert')

@section('content')
<div class="card card-data col-md-12">
    <h1 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">Laporan Penjualan</h1>
    @if(isset($tanggal))
    <p style="color: #B4B4B8; text-align: center;">Per Tanggal: {{ $tanggal }}</p>
    @elseif(isset($bulanTerpilih))
    <p style="color: #B4B4B8; text-align: center;">Per Bulan: {{ \Carbon\Carbon::createFromFormat('m', $bulanTerpilih)->format('F') }}</p>
    @endif
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="row" style="margin: 0 10px 10px 10px;">
                <div class="col-md-8">
                    <a href="{{url('download-laporanpenjualan')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak
                        </button>
                    </a>
                </div>
                <div class="col-md-4">
                    <form class="d-flex" action="{{url('admin-laporanpenjualan')}}" method="GET">
                        <input type="date" class="form-control me-2" id="tanggal" name="tanggal">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        @if(isset($tanggal))
                        <a href="{{ url('admin-laporanpenjualan') }}" class="btn btn-secondary ms-2">All</a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="row" style="margin: 0 10px 10px 10px;">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <form class="d-flex" action="{{url('admin-laporanpenjualan')}}" method="GET">
                        <select class="form-control me-2" id="bulan" name="bulan">
                            <option value="">Pilih Bulan</option>
                            @foreach($bulanList as $key => $bulan)
                            <option value="{{$key}}" {{$key == $bulanTerpilih ? 'selected' : ''}}>{{$bulan}}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Cari</button>
                        @if(isset($bulanTerpilih))
                        <a href="{{ url('admin-laporanpenjualan') }}" class="btn btn-secondary ms-2">Semua Bulan</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="table-responsive" style="width: 97%; margin-left: 15px;">
                <table class="table table-responsive table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Waktu</th>
                            <th class="text-center">No Order</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">QTY</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Jenis Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($mergedDetail) && count($mergedDetail) > 0)
                        @foreach($mergedDetail as $no => $detail)
                        <tr>
                            <td align="center">{{$no+1}}</td>
                            <td align="center">{{$detail->created_at}}</td>
                            @if($detail instanceof App\Models\PenjualanDetail)
                            <td align="center">{{$detail->penjualan->no_order}}</td>
                            <td align="center">{{$detail->produk->nama}}</td>
                            <td align="center">Rp. {{ number_format($detail->produk->harga_jual) }}</td>
                            <td align="center">{{$detail->qty}}</td>
                            <td align="center">Rp. {{ number_format($detail->total) }}</td>
                            @elseif($detail instanceof App\Models\PesananDetail)
                            <td align="center">{{$detail->pesanan->no_order}}</td>
                            <td align="center">{{$detail->produk->nama}}</td>
                            <td align="center">Rp. {{ number_format($detail->produk->harga_jual) }}</td>
                            <td align="center">{{$detail->qty}}</td>
                            <td align="center">Rp. {{ number_format($detail->total) }}</td>
                            @endif
                            <td align="center">
                                @if($detail instanceof App\Models\PenjualanDetail)
                                Penjualan Kasir
                                @elseif($detail instanceof App\Models\PesananDetail)
                                Pesanan Online
                                @endif
                            </td>

                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" align="center">Data tidak ditemukan</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item {{ $mergedDetail->currentPage() == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $mergedDetail->previousPageUrl() }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $mergedDetail->lastPage(); $i++)
                                <li class="page-item {{ $mergedDetail->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $mergedDetail->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li
                                    class="page-item {{ $mergedDetail->currentPage() == $mergedDetail->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $mergedDetail->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>

    @endsection