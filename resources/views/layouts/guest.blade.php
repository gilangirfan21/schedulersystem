<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    {{-- START Alertify --}}
    <!-- CUSTOME STYLE -->
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
    <!-- CSS -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css') }}"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css') }}"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css') }}"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css') }}"/>
    {{-- END Alertify --}}

</head>
<body class="hold-transition login-page fit-custom mt-2" style="height:90vh !important;">
<div class="login-box mt-5">
    <div class="login-logo" style="margin:0 !important;">
        <img src="{{ asset('images/logo_gundar_hd.png') }}" alt="logo universitas gunadarma" width="200" height="200" class="d-inline-block align-top">
    </div>
    <div class="login-logo">
        <h2 style="font-size: 42px !important;">Sistem Penjadwalan Perkuliahan</h2>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        @yield('content')
    </div>
    <div class="login-logo mt-3">
        <h2 class="font-weight-bold" style="font-size: 26px !important;">Universitas Gunadarma</h2>
    </div>
</div>
<!-- /.login-box -->

{{-- @vite('resources/js/app.js') --}}
<!-- Bootstrap 4 -->
{{-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> --}}
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}" defer></script>
<!-- Alertify -->
<script src="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js') }}"></script>
</body>
</html>
