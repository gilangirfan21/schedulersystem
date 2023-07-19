@extends('layouts.guest')

@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('Login') }}</p>

        <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email') }}" required autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                <span class="error invalid-feedback">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                <span class="error invalid-feedback">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <button type="submit" class="btn btn-block" style="background-color: #5d77b9 !important;
                    color: #ffff !important;">{{ __('Login')}}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <div class="row justify-content-center mt-2">
            <div class="col-12 text-center">
                <a href="{{ route('mahasiswa') }}" class="">{{ __('Jadwal Perkuliahan')}}</a>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.login-card-body -->
@endsection