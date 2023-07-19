<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
    <nav class="main-header navbar navbar-expand navbar-white navbar-light fit-bg-color-secondary">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars fit-text-color-2"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown fit-text-color-2">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="dropdown-item fit-text-color-2"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ '(' . Auth::user()->email . ') - ' . __('Log Out') }}
                        <i class="mr-2 fas fa-sign-out-alt fit-text-color-2"></i>
                    </a>
                </form>
                
                {{-- <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                    {{(Auth::user()->email)}}
                </a> --}}
                <div class="dropdown-menu dropdown-menu-right fit-text-color-2" style="left: inherit; right: 0px;">
                    <a href="{{ route('profile.show') }}" class="dropdown-item fit-text-color-2">
                        <i class="mr-2 fas fa-file fit-text-color-2"></i>
                        {{ __('My profile') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    
                </div>
            
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 fit-bg-color-secondary">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{ asset('images/main.png') }}" alt="Logo Apps"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
            <span class="brand-text font-weight-light fit-text-color-2">{{ strtoupper(Auth::user()->name) }}</span>
        </a>

        @include('layouts.navigation')
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
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
    <footer class="main-footer navbar-white navbar-light fit-bg-color-secondary">
        <!-- Coppyright Center -->
        <div class="d-flex justify-content-center ">
            <span class="fit-text-color-2">Copyright &copy; 2023 - Fitriana Indah Mitasari</span>
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

{{-- @vite('resources/js/app.js') --}}
{{-- <script src="resources/js/app.js"></script> --}}
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}" defer></script>
<!-- JQuery -->
{{-- <script src="{{ secure_asset('https://code.jquery.com/jquery-3.7.0.js') }}" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script> --}}
<script src="{{ secure_asset('https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js') }}"></script>
<!-- Select 2 -->
<script src="{{ secure_asset('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
<!-- Datatable -->
<script src="{{ secure_asset('https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js') }}"></script>
<!-- Popper -->
{{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!-- Axios -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<!-- Alertify -->
<script src="{{ secure_asset('https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js') }}"></script>
@yield('scripts')
</body>
</html>
