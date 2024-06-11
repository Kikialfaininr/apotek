@extends('layouts.app-admin')
@extends('layouts.alert')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'admin' || auth()->user()->level == 'owner'))
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="stokhabis-tab" data-bs-toggle="tab"
                                data-bs-target="#stokhabis" type="button" role="tab" aria-controls="stokhabis"
                                aria-selected="true">Stok Habis</button>
                            <button class="nav-link" id="stokmenipis-tab" data-bs-toggle="tab"
                                data-bs-target="#stokmenipis" type="button" role="tab" aria-controls="stokmenipis"
                                aria-selected="false">Stok Menipis</button>
                            <button class="nav-link" id="stokopname-tab" data-bs-toggle="tab"
                                data-bs-target="#stokopname" type="button" role="tab" aria-controls="stokopname"
                                aria-selected="false">Stok Opname</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="stokhabis" role="tabpanel"
                            aria-labelledby="stokhabis-tab" tabindex="0">
                            <h3 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">
                                Stok Habis</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive">
                                <table id="example1" class="table table-responsive table-striped table-hover table-bordered">
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
                                        @if($value->stok == 0)
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
                                            <td>{{$value->kategori->nama_kategori}}</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="stokmenipis" role="tabpanel" aria-labelledby="stokmenipis-tab"
                            tabindex="0">
                            <h3 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">
                                Stok Menipis</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive">
                                <table id="example2" class="table table-responsive table-striped table-hover table-bordered" style="width: 100%;">
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
                                        @if($value->stok > 0 && $value->stok < 10) @php $counter++; @endphp <tr>
                                            <td align="center">{{$counter}}</td>
                                            <td>{{$value->nama}}</td>
                                            <td>{{$value->bentuk_sediaan}}</td>
                                            <td>{{$value->satuan}}</td>
                                            <td align="center">{{$value->stok}}</td>
                                            <td align="center">Rp {{ number_format($value->harga_beli) }}</td>
                                            <td>{{$value->kategori->nama_kategori}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="stokopname" role="tabpanel" aria-labelledby="stokopname-tab"
                            tabindex="0">
                            <h3 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">
                                Stok Opname</h3>
                            @if(isset($tanggal))
                            <p style="color: #B4B4B8; text-align: center;">Tanggal: {{ $tanggal }}</p>
                            @endif
                            <div class="table-responsive">
                                <table id="example3" class="table table-responsive table-striped table-hover table-bordered" style="width: 100%;">
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
                </div>
            </div>
        </div>
    </div>
</div>

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