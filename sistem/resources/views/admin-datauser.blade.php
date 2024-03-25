@extends('layouts.app-admin')

@section('content')
<div class="card card-data col-md-12">
    <h1 style="color: #34495e; margin: 30px 0 30px 0; font-weight: bold; text-align: center;">Data Pelanggan</h1>
    <div>
        <form class="d-flex" style="float: right; margin-bottom: 20px; margin-right: 20px;" action="{{url('admin-datauser')}}"
            method="GET">
            <input style="width: 200px" class="form-control me-2" type="text" name="search" placeholder="Masukan nama atau username"
                value="{{$request->search}}">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div>
    <div class="row">
        <div class="table-responsive" style="width: 97%; margin-left: 15px;">
            <table class="table table-responsive table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Foto Profil</th>
                        <th class="text-center">Nama Lengkap</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">E-mail</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Nomor Telefon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user as $no => $value)
                    <tr>
                        <td align="center">{{$no+1}}</td>
                        <td align="center">{{$value->foto_profil}}</td>
                        <td align="center">{{$value->fullname}}</td>
                        <td align="center">{{$value->name}}</td>
                        <td align="center">{{$value->email}}</td>
                        <td align="center">{{$value->alamat}}</td>
                        <td align="center">{{$value->nomor_tlp}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection