@extends('layouts.app-admin')
@extends('layouts.alert')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'admin' || auth()->user()->level == 'owner'))
<div class="card card-data col-md-12">
    <h1 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">Data Produk</h1>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div style="margin: 0 20px 0 20px;">
                @if (session()->has('message'))
                @php
                $alertClass = session('alert_class', 'success');
                @endphp

                <div class="alert alert-{{ $alertClass }}">
                    {{ session('message') }}
                </div>
                @endif

                @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
            </div>
            <div class="row">
                @if(auth()->check() && (auth()->user()->level == 'admin'))
                <div class="col-md-8">
                    <button type="button" style="margin: 20px 0 20px 20px;" class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#TambahDataProduk" title="Tambah Data">
                        <i class="fa fa-plus"></i> Tambah Data Produk
                    </button>
                    <a href="{{url('downloadpdf-produk')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak
                        </button>
                    </a>
                </div>
                @else
                <div class="col-md-8">
                    <a style="margin: 20px;" href="{{url('downloadpdf-produk')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak
                        </button>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="table-responsive" style="width: 97%; margin-left: 15px;">
            <table id="example" class="table table-responsive table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Foto Produk</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Bentuk Sediaan</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Harga Beli</th>
                        <th class="text-center">Harga Jual</th>
                        <th class="text-center">Kategori</th>
                        @if(auth()->check() && (auth()->user()->level == 'admin'))
                        <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                @if(isset($produk) && count($produk) > 0)
                <tbody>
                    @foreach($produk as $no => $value)
                    <tr>
                        <td align="center">{{$no+1}}</td>
                        <td align="center">
                            @if($value->foto)
                            <img src="images/fotoproduk/{{$value->foto}}" width="100px">
                            @else
                            <img src="images/placeholder.png" width="100px">
                            @endif
                        </td>
                        <td>{{$value->nama}}</td>
                        <td>{{$value->bentuk_sediaan}}</td>
                        <td>{{$value->satuan}}</td>
                        <td align="center">{{$value->stok}}</td>
                        <td align="center">Rp {{ number_format($value->harga_beli) }}</td>
                        <td align="center">Rp {{ number_format($value->harga_jual) }}</td>
                        <td>{{$value->kategori->nama_kategori}}</td>
                        @if(auth()->check() && (auth()->user()->level == 'admin'))
                        <td align="center">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#UbahProduk{{$value->id_produk}}" title="Tambah Data">
                                <i class="fa fa-edit"></i>
                            </button>
                            <a href="{{url($value->id_produk.'/hapus-produk')}}">
                                <button title="Hapus Data" class="btn btn-danger btn-sm"><i
                                        class="fas fa-trash"></i></button>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@foreach($produk as $no => $value)
<div class="modal" id="TambahDataProduk" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Produk</h4>
            </div>
            <div class="modal-body">
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form method="POST" action="{{url('simpan-data-produk')}}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="foto">{{ __('Foto Produk') }}</label>
                        <input id="foto" onchange="readFoto(event)" type="file"
                            class="form-control @error('foto') is-invalid @enderror" name="foto"
                            value="{{ old('foto') }}" required autofocus>
                        <img id="output" style="width: 100px;">
                        @error('foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="nama">{{ __('Nama Produk') }}</label>
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            name="nama" value="{{ old('nama') }}" required autofocus>
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="bentuk_sediaan">{{ __('Bentuk Sediaan') }}</label>
                        <input id="bentuk_sediaan" type="text"
                            class="form-control @error('bentuk_sediaan') is-invalid @enderror" name="bentuk_sediaan"
                            value="{{ old('bentuk_sediaan') }}" required autofocus>
                        @error('bentuk_sediaan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="satuan">{{ __('Satuan') }}</label>
                        <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror"
                            name="satuan" value="{{ old('satuan') }}" required autofocus>
                        @error('satuan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="stok">{{ __('Stok') }}</label>
                        <input id="stok" type="number" class="form-control @error('stok') is-invalid @enderror"
                            name="stok" value="{{ old('stok') }}" required autofocus>
                        @error('stok')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="harga_jual">{{ __('Harga Jual') }}</label>
                        <input id="harga_jual" type="number"
                            class="form-control @error('harga_jual') is-invalid @enderror" name="harga_jual"
                            value="{{ old('harga_jual') }}" required autofocus>
                        @error('harga_jual')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="harga_beli">{{ __('Harga Beli') }}</label>
                        <input id="harga_beli" type="number"
                            class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli"
                            value="{{ old('harga_beli') }}" required autofocus>
                        @error('harga_beli')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="id_kategori">{{ __('Kategori') }}</label>
                        <select class="form-select" name="id_kategori" id="id_kategori"
                            value="{{ $value->id_kategori }}" style="width: 100%; height: 35px; font-size: 13px;">
                            <option disble value>Pilih Kategori</option>
                            @foreach ($kategori as $data)
                            <option value="{{$data->id_kategori}}"
                                {{$value && $data->id_kategori == $value->id_kategori ? 'selected' : ''}}>
                                {{$data->nama_kategori}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label text-md-end"></label>
                        <div class="col-md-8">
                            <button class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($produk as $no => $value)
<div class="modal" id="UbahProduk{{$value->id_produk}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Data Produk</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('update-produk/'.$value->id_produk)}}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="foto">{{ __('Foto Produk') }}</label>
                    
                        @if($value->foto)
                            <img id="output" src="images/fotoproduk/{{$value->foto}}" alt="Foto Produk" style="width: 100px;">
                        @else
                            <img id="output" style="width: 100px;">
                        @endif
                    
                        <input id="foto" onchange="readFoto(event)" type="file"
                            class="form-control @error('foto') is-invalid @enderror" name="foto"
                            value="{{ old('foto') }}" autofocus>
                    
                        @error('foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="nama">{{ __('Nama Produk') }}</label>
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            name="nama" value="{{ $value->nama }}" required autofocus>
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="bentuk_sediaan">{{ __('Bentuk Sediaan') }}</label>
                        <input id="bentuk_sediaan" type="text"
                            class="form-control @error('bentuk_sediaan') is-invalid @enderror" name="bentuk_sediaan"
                            value="{{ $value->bentuk_sediaan }}" required autofocus>
                        @error('bentuk_sediaan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="satuan">{{ __('Satuan') }}</label>
                        <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror"
                            name="satuan" value="{{ $value->satuan }}" required autofocus>
                        @error('satuan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="stok">{{ __('Stok') }}</label>
                        <input id="stok" type="text" class="form-control @error('stok') is-invalid @enderror"
                            name="stok" value="{{ $value->stok }}" required autofocus>
                        @error('stok')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="harga_jual">{{ __('Harga Jual') }}</label>
                        <input id="harga_jual" type="text"
                            class="form-control @error('harga_jual') is-invalid @enderror" name="harga_jual"
                            value="{{ $value->harga_jual }}" required autofocus>
                        @error('harga_jual')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="harga_beli">{{ __('Harga Beli') }}</label>
                        <input id="harga_beli" type="text"
                            class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli"
                            value="{{ $value->harga_beli }}" required autofocus>
                        @error('harga_beli')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="id_kategori">{{ __('Kategori') }}</label>
                        <select class="form-select" name="id_kategori" id="id_kategori"
                            value="{{ $value->id_kategori }}" style="width: 100%; height: 35px; font-size: 13px;">
                            <option disble value>Pilih Kategori</option>
                            @foreach ($kategori as $data)
                            <option value="{{$data->id_kategori}}">{{$data->nama_kategori}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label text-md-end"></label>
                        <div class="col-md-8">
                            <button class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

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

<script type="text/javascript">
var readFoto = function(event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function() {
        var dataURL = reader.result;
        var output = document.getElementById('output');
        output.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
};
</script>

@else
<?php abort(403, 'Unauthorized action.'); ?>
@endif

@endsection
