@extends('layouts.app-kasir')
@extends('layouts.alert')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <form action="{{ url('kasir-riwayatpenjualan') }}" method="GET" class="w-100">
                        <div class="d-flex align-items-center">
                            <label for="tanggal" class="form-label me-2">Tanggal:</label>
                            <input type="date" class="form-control me-2" id="tanggal" name="tanggal">
                            <button type="submit" class="btn btn-primary">Cari</button>
                            @if(isset($tanggal))
                            <a href="{{ url('kasir-riwayatpenjualan') }}" class="btn btn-secondary ms-2">All</a>
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
                                Invoice Penjualan</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="col-md-8" style="margin-bottom: 10px;">
                                <a href="{{url('downloadinvoice-penjualan')}}" target="_blank">
                                    <button class="btn btn-danger">
                                        <i class='fas fa-file-pdf'></i> Cetak
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
                                            <th class="text-center">Produk</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($penjualanDetail) && count($penjualanDetail) > 0)
                                        @foreach($penjualanDetail as $no => $value)
                                        <tr>
                                            <td align="center">{{$no+1}}</td>
                                            <td align="center">{{$value->created_at}}</td>
                                            <td align="center">{{$value->penjualan->no_order}}</td>
                                            <td align="center">{{$value->produk->nama}}</td>
                                            <td align="center">Rp. {{ number_format($value->produk->harga_jual) }}</td>
                                            <td align="center">{{$value->qty}}</td>
                                            <td align="center">Rp. {{ number_format($value->total) }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="12" align="center">Data tidak ditemukan</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if(isset($penjualan) && count($penjualan) > 0)
                            <div class="d-flex justify-content-end">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item {{ $penjualan->currentPage() == 1 ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $penjualan->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        @for ($i = 1; $i <= $penjualan->lastPage(); $i++)
                                            <li class="page-item {{ $penjualan->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $penjualan->url($i) }}">{{ $i }}</a>
                                            </li>
                                            @endfor
                                            <li
                                                class="page-item {{ $penjualan->currentPage() == $penjualan->lastPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $penjualan->nextPageUrl() }}"
                                                    aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                    </ul>
                                </nav>
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="produkterjual" role="tabpanel"
                            aria-labelledby="produkterjual-tab" tabindex="0">
                            <h3 style="color: #34495e; margin-top: 30px; font-weight: bold; text-align: center;">
                                Produk Terjual</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="col-md-8" style="margin-bottom: 10px;">
                                <a href="{{url('downloadprodukterjual')}}" target="_blank">
                                    <button class="btn btn-danger">
                                        <i class='fas fa-file-pdf'></i> Cetak
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
                                            <th class="text-center">Produk</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($penjualanDetail) && count($penjualanDetail) > 0)
                                        @foreach($penjualanDetail as $no => $value)
                                        <tr>
                                            <td align="center">{{$no+1}}</td>
                                            <td align="center">{{$value->created_at}}</td>
                                            <td align="center">{{$value->penjualan->no_order}}</td>
                                            <td align="center">{{$value->produk->nama}}</td>
                                            <td align="center">Rp. {{ number_format($value->produk->harga_jual) }}</td>
                                            <td align="center">{{$value->qty}}</td>
                                            <td align="center">Rp. {{ number_format($value->total) }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="12" align="center">Data tidak ditemukan</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if(isset($penjualanDetail) && count($penjualanDetail) > 0)
                            <div class="d-flex justify-content-end">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li
                                            class="page-item {{ $penjualanDetail->currentPage() == 1 ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $penjualanDetail->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        @for ($i = 1; $i <= $penjualanDetail->lastPage(); $i++)
                                            <li
                                                class="page-item {{ $penjualanDetail->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $penjualanDetail->url($i) }}">{{ $i }}</a>
                                            </li>
                                            @endfor
                                            <li
                                                class="page-item {{ $penjualanDetail->currentPage() == $penjualanDetail->lastPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $penjualanDetail->nextPageUrl() }}"
                                                    aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                    </ul>
                                </nav>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection