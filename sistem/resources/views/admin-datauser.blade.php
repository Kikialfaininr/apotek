@extends('layouts.app-admin')

@section('content')
@if(auth()->check() && (auth()->user()->level == 'admin' || auth()->user()->level == 'owner'))
<div class="card card-data col-md-12">
    <h1 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">Data Pelanggan</h1>
    <div class="row">
        <div class="col-md-8">
            <a style="margin: 10px;" href="{{url('downloadpdf-pelanggan')}}" target="_blank">
                <button class="btn btn-danger">
                    <i class='fas fa-file-pdf'></i> Cetak
                </button>
            </a>
        </div>
        <div class="row">
            <div class="table-responsive" style="margin-left: 10px;">
                <table id="example" class="table table-responsive table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Foto Profil</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Nama Lengkap</th>
                            <th class="text-center">E-mail</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Nomor Telepon</th>
                        </tr>
                    </thead>
                    @if(isset($pelanggan) && count($pelanggan) > 0)
                    <tbody>
                        @foreach($pelanggan as $no => $value)
                        @if($value->level == 'pelanggan')
                        <tr>
                            <td align="center">{{$no+1}}</td>
                            <td align="center">
                                @if($value->foto)
                                <img src="images/fotoprofil/{{$value->foto}}" alt="profil"
                                    style="width:100px; height: 100px;"
                                    class="d-inline-block align-text-center rounded-circle" />
                                @else
                                <img src="sistem/img/profil.jpg" alt="profil" style="width:100px; height: 100px;"
                                    class="d-inline-block align-text-center rounded-circle">
                                @endif
                            </td>
                            <td align="center">{{$value->name}}</td>
                            <td align="center">{{$value->fullname}}</td>
                            <td align="center">{{$value->email}}</td>
                            <td align="center">{{$value->alamat}}</td>
                            <td align="center">{{$value->nomor_tlp}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    @endif
                </table>
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