@extends('layouts.app-admin')
@extends('layouts.alert')

@section('content')
<div class="card card-data col-md-12">
    <h1 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">Data Kategori Produk</h1>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="row">
                <div class="col-md-8">
                    <button type="button" style="margin: 20px 0 20px 20px;" class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#TambahDataKategori" title="Tambah Data">
                        <i class="fa fa-plus"></i> Tambah Data Kategori
                    </button>
                    <a href="{{url('downloadpdf-kategori')}}" target="_blank">
                        <button class="btn btn-danger">
                            <i class='fas fa-file-pdf'></i> Cetak
                        </button>
                    </a>
                </div>
                <div class="col-md-4">
                    <form class="d-flex" style="margin: 20px 0 0 50px;" action="{{url('admin-kategori')}}" method="GET">
                        <input style="width: 200px" class="form-control me-2" type="text" name="search"
                            placeholder="Masukkan nama kategori" value="{{$request->search}}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive" style="width: 97%; margin-left: 15px;">
            <table class="table table-responsive table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategori as $no => $value)
                    <tr>
                        <td align="center">{{$no+1}}</td>
                        <td>{{$value->nama_kategori}}</td>
                        <td align="center">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#UbahKategori{{$value->id_kategori}}" title="Tambah Data">
                                <i class="fa fa-edit"></i>
                            </button>
                            <a href="{{url($value->id_kategori.'/hapus-kategori')}}">
                                <button title="Hapus Data" class="btn btn-danger btn-sm"><i
                                        class="fas fa-trash"></i></button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item {{ $kategori->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $kategori->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $kategori->lastPage(); $i++)
                            <li class="page-item {{ $kategori->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $kategori->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            <li
                                class="page-item {{ $kategori->currentPage() == $kategori->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $kategori->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>
</div>

<div class="modal" id="TambahDataKategori" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Kategori</h4>
            </div>
            <div class="modal-body">
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form method="POST" action="{{url('simpan-data-kategori')}}">
                    @csrf
                    <div>
                        <label for="nama_kategori">{{ __('Kategori') }}</label>
                        <input id="nama_kategori" type="text"
                            class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori"
                            value="{{ old('nama_kategori') }}" required autofocus>
                        @error('nama_kategori')
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

@foreach($kategori as $no => $value)
<div class="modal" id="UbahKategori{{$value->id_kategori}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Data Kategori</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('update-kategori/'.$value->id_kategori)}}">
                    @csrf
                    <div>
                        <label for="nama_kategori">{{ __('Kategori') }}</label>
                        <input id="nama_kategori" type="text"
                            class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori"
                            value="{{ $value->nama_kategori }}" required autofocus>
                        @error('nama_kategori')
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
<script>
window.onload = function() {
    if (!window.location.hash) {
        window.location = window.location + '#loaded';
        setTimeout(function() {
            window.location.reload();
        }, 5000); // 5000 milidetik = 5 detik
    }
}
</script>
@endsection