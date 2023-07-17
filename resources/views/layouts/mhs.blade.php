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
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- SELECT 2 -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css') }}" />
    <!-- DATATABLE -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css') }}" />
    <!-- CUSTOME STYLE -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    {{-- START Alertify --}}
    <!-- CSS -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css') }}"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css') }}"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css') }}"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css') }}"/>
    {{-- END Alertify --}}

    @yield('styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white mhs-margin mhs-nav fit-bg-color-primary px-3" >
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('login') }}" role="button"><i class="fa fa-home fit-text-color-2" aria-hidden="true"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <span class="fit-bg-color-primary fit-text-color-2">Halaman Mahasiswa</span>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mhs-margin">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer navbar-white fit-bg-color-primary mhs-margin">
        <!-- Coppyright Center -->
        <div class="d-flex justify-content-center">
            <span class="fit-text-color-2">Copyright &copy; 2023 - Fitriana Indah Mitasari</span>
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

{{-- @vite('resources/js/app.js') --}}
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}" defer></script>
<!-- JQuery -->
<script src="{{ secure_asset('https://code.jquery.com/jquery-3.7.0.js') }}" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<!-- Select 2 -->
<script src="{{ secure_asset('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
<!-- Datatable -->
<script src="{{ secure_asset('https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js') }}"></script>
<!-- Alertify -->
<script src="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js') }}"></script>
@yield('scripts')
</body>
</html>
