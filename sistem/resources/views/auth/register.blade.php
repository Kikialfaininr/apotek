@extends('layouts.app-auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7 bg-auth">
            <img src="sistem/img/bg-auth.png" alt="apotek">
        </div>

        <div class="col">
            <div class="card register" style="width: 120%; height:90%; overflow-y: auto;">
                <div class="card-body">
                    <a href="{{ url('/') }}" class="back-link">
                        <i class="fa fa-arrow-left" style="color: #34455B"></i>
                    </a>
                    <form method="POST" action="{{ route('register') }}">
                        <h3 align="center" style="margin: 0 0 20px 0;">Daftar</h3>
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Username') }}</label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fullname" class="col-md-3 col-form-label">{{ __('Nama Lengkap') }}</label>
                            <div class="col-md-9">
                                <input id="fullname" type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname') }}" required autocomplete="fullname" autofocus>
                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-3 col-form-label">{{ __('Email') }}</label>
                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat" class="col-md-3 col-form-label">{{ __('Alamat') }}</label>
                            <div class="col-md-9">
                                <input id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" required autocomplete="alamat" autofocus>
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nomor_tlp" class="col-md-3 col-form-label">{{ __('Nomor Telefon') }}</label>
                            <div class="col-md-9">
                                <input id="nomor_tlp" type="text" class="form-control @error('nomor_tlp') is-invalid @enderror" name="nomor_tlp" value="{{ old('nomor_tlp') }}" required autocomplete="nomor_tlp" autofocus>
                                @error('nomor_tlp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-3 col-form-label">{{ __('Password') }}</label>
                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-3 col-form-label">{{ __('Confirm Password') }}</label>
                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    {{ __('Daftar') }}
                                </button>
                            </div>
                        </div> 
                        <div class="row mb-3" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <p>Sudah memiliki akun? <a href="{{ url('login') }}"> Masuk</a></p>
                            </div>
                        </div>                 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection