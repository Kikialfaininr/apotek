@extends('layouts.app-admin')
@extends('layouts.alert')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'admin' || auth()->user()->level == 'owner'))
<div class="card card-data col-md-12">
    <h1 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">Laporan Stok Opname</h1>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="row" style="margin: 0 10px 10px 10px;">
                <div class="col-md-8">
                    <a href="{{url('download-laporanstok')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak Stok Opname
                        </button>
                    </a>
                    <a href="{{url('downloadstokmenipis')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak Stok Menipis
                        </button>
                    </a>
                    <a href="{{url('downloadstokhabis')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak Stok Habis
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="table-responsive" style="width: 97%; margin-left: 15px;">
            <table id="example" class="table table-responsive table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Bentuk Sediaan</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Harga Beli</th>
                        <th class="text-center">Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $counter = 0;
                    @endphp
                    @if(isset($produk) && count($produk) > 0)
                    @foreach($produk as $no => $value)
                    @php $counter++; @endphp
                    <tr>
                        <td align="center">{{$counter}}</td>
                        <td>{{$value->nama}}</td>
                        <td>{{$value->bentuk_sediaan}}</td>
                        <td>{{$value->satuan}}</td>
                        <td align="center">{{$value->stok}}</td>
                        <td align="center">Rp {{ number_format($value->harga_beli) }}</td>
                        <td>{{$value->kategori->nama_kategori}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    new DataTable('#example', {
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