@extends('layouts.app-admin')
@extends('layouts.alert')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'admin' || auth()->user()->level == 'owner'))
<div class="card card-data col-md-12">
    <h1 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">Data Ongkos Kirim</h1>
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
                        data-bs-toggle="modal" data-bs-target="#TambahDataOngkir" title="Tambah Data">
                        <i class="fa fa-plus"></i> Tambah Data Ongkir
                    </button>
                    <a href="{{url('downloadpdf-ongkir')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak
                        </button>
                    </a>
                </div>
                @else
                <div class="col-md-8">
                    <a style="margin: 20px;" href="{{url('downloadpdf-ongkir')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak
                        </button>
                    </a>
                </div>
                <div class="col-md-4">
                </div>
                @endif
            </div>
        </div>

        <div class="table-responsive" style="width: 97%; margin-left: 15px;">
            <table id="example" class="table table-responsive table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">wilayah</th>
                        <th class="text-center">Ongkir</th>
                        @if(auth()->check() && (auth()->user()->level == 'admin'))
                        <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($ongkir as $no => $value)
                    <tr>
                        <td align="center">{{$no+1}}</td>
                        <td align="center">{{$value->wilayah}}</td>
                        <td align="center">Rp {{ number_format($value->ongkir) }}</td>
                        @if(auth()->check() && (auth()->user()->level == 'admin'))
                        <td align="center">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#UbahOngkir{{$value->id_ongkir}}" title="Tambah Data">
                                <i class="fa fa-edit"></i>
                            </button>
                            <a href="{{url($value->id_ongkir.'/hapus-ongkir')}}">
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
    </div>
</div>

<div class="modal" id="TambahDataOngkir" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Ongkir</h4>
            </div>
            <div class="modal-body">
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form method="POST" action="{{url('simpan-data-ongkir')}}">
                    @csrf
                    <div>
                        <label for="wilayah">{{ __('Wilayah') }}</label>
                        <div class="input-group">
                            <input id="wilayah" type="text" class="form-control @error('wilayah') is-invalid @enderror"
                                name="wilayah" value="{{ old('wilayah') }}" required autofocus>
                        </div>
                        @error('wilayah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="ongkir">{{ __('Ongkir') }}</label>
                        <input id="ongkir" type="text" class="form-control @error('ongkir') is-invalid @enderror"
                            name="ongkir" value="{{ old('ongkir') }}" required autofocus>
                        @error('ongkir')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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

@foreach($ongkir as $no => $value)
<div class="modal" id="UbahOngkir{{$value->id_ongkir}}" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Data Ongkir</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('update-ongkir/'.$value->id_ongkir)}}">
                    @csrf
                    <div>
                        <label for="wilayah">{{ __('Wilayah') }}</label>
                        <div class="input-group">
                            <input id="wilayah" type="text" class="form-control @error('wilayah') is-invalid @enderror"
                                name="wilayah" value="{{ $value->wilayah }}" required autofocus>
                        </div>
                        @error('wilayah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="ongkir">{{ __('Ongkir') }}</label>
                        <input id="ongkir" type="text" class="form-control @error('ongkir') is-invalid @enderror"
                            name="ongkir" value="{{ $value->ongkir }}" required autofocus>
                        @error('ongkir')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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

@else
<?php abort(403, 'Unauthorized action.'); ?>
@endif

@endsection