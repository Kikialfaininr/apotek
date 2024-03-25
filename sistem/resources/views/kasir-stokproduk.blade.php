@extends('layouts.app-kasir')
@extends('layouts.alert')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <a href="{{url('downloadpdf-produk')}}" target="_blank">
                                <button class="btn btn-danger">
                                    <i class='fas fa-file-pdf'></i> Cetak
                                </button>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <form class="d-flex" style="margin: 20px 0 0 50px;" action="{{url('kasir-stokproduk')}}"
                                method="GET">
                                <input style="width: 200px" class="form-control me-2" type="text" name="search"
                                    placeholder="Masukkan nama produk" value="{{$request->search}}">
                                <button class="btn btn-primary" type="submit">Search</button>
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
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Produk</th>
                                    <th class="text-center">Bentuk Sediaan</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Harga Beli</th>
                                    <th class="text-center">Harga Jual</th>
                                    <th class="text-center">Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $counter = 0;
                                @endphp
                                @if(isset($produk) && count($produk) > 0)
                                @foreach($produk as $no => $value)
                                @if($value->stok > 0)
                                @php
                                $counter++;
                                @endphp
                                <tr>
                                    <td align="center">{{$counter}}</td>
                                    <td>{{$value->nama}}</td>
                                    <td>{{$value->bentuk_sediaan}}</td>
                                    <td>{{$value->satuan}}</td>
                                    <td align="center">{{$value->stok}}</td>
                                    <td align="center">Rp {{ number_format($value->harga_beli) }}</td>
                                    <td align="center">Rp {{ number_format($value->harga_jual) }}</td>
                                    <td>{{$value->kategori->nama_kategori}}</td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" align="center">Data tidak ditemukan</td>
                                </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>

                    @if(isset($produk) && count($produk) > 0)
                    <div class="d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item {{ $produk->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $produk->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $produk->lastPage(); $i++)
                                    <li class="page-item {{ $produk->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $produk->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li
                                        class="page-item {{ $produk->currentPage() == $produk->lastPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $produk->nextPageUrl() }}" aria-label="Next">
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
@endsection