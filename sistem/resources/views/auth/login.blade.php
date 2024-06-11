@extends('layouts.app-auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7 bg-auth">
            <img src="sistem/img/bg-auth.png" alt="apotek">
        </div>

        <div class="col">
            <div class="card login">
                <div class="card-body">
                    <a href="{{ url('/') }}" class="back-link">
                        <i class="fa fa-arrow-left" style="color: #34455B"></i>
                    </a>

                    <form method="POST" action="{{ route('login') }}">
                        <h3 align="center">Masuk</h3>
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                        @endif
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Masukkan Email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password" placeholder="Masukkan Password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary custom-btn" style="width: 100%;">
                                    {{ __('Masuk') }}
                                </button>
                                @if (Route::has('password.request'))
                                <div class="col-md-12 text-md-end">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Lupa Password?') }}
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p>Belum memiliki akun? <a href="{{ url('register') }}"> Daftar</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection