@extends('layouts.app-kasir')
@extends('layouts.alert')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'apoteker'))
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <div class="row">
                        <div class="col-md-8">
                            <a href="{{url('download-laporanstok')}}" target="_blank">
                                <button class="btn btn-danger">
                                    <i class='fas fa-file-pdf'></i> Cetak
                                </button>
                            </a>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-responsive table-striped table-hover table-bordered">
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
                                @php $counter++; @endphp
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
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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