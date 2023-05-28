{{-- @extends('layouts.guest') --}}
@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('About us') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            {{-- START LOADING --}}
            <div id="loading" class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body text-center box-spinner">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">Loading...</span>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END LOADING --}}


            <div id="content" class="row">
                <div class="col-lg-12">
                    <div  class="card">
                        <div class="card-body">
                            {{-- <h5 class="card-title">{{ __('About us') }}</h5> --}}

                            {{-- START DEFAULT VIEW REGISTER --}}
                            <div class="card-body login-card-body">
                                <div class="row justify-content-md-center">
                                    <div class="col-lg-6">

                            {{-- DEFAULT VIEW REGISTER --}}
                                        {{-- <p class="login-box-msg">{{ __('Register') }}</p> --}}
                                        <p class="login-box-msg">{{ __('Tambah Akun') }}</p>

                                        {{-- <form method="POST" action="{{ route('register') }}"> --}}
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf

                                            {{-- <div class="input-group mb-3"> --}}
                                                {{-- <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Name') }}" required autocomplete="name" autofocus> --}}
                                                {{-- <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Kode Dosen') }}" required autocomplete="name" autofocus> --}}
                                                {{-- <div class="input-group-append"> --}}
                                                    {{-- <div class="input-group-text"> --}}
                                                        {{-- <span class="fas fa-user"></span> --}}
                                                    {{-- </div> --}}
                                                {{-- </div> --}}
                                                {{-- @error('name') --}}
                                                {{-- <span class="error invalid-feedback"> --}}
                                                    {{-- {{ $message }} --}}
                                                {{-- </span> --}}
                                                {{-- @enderror --}}
                                            {{-- </div> --}}

                                            {{-- START CUSTOM ADD ROLE --}}
                                            <div class="input-group mb-3">
                                                <select name="name" class="custom-select select2" id="name">
                                                    <option value="" selected disabled>Dosen Code</option>
                                                </select>
                                                <div class="input-group-append">
                                                <label class="input-group-text" for="name">
                                                    <span class="fas fa-user"></span>
                                                </label>
                                                </div>
                                                @error('name')
                                                <span class="error invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="input-group mb-3">
                                                <select name="role" class="custom-select select2" id="role">
                                                    <option value="" selected disabled>Role</option>
                                                    <option value="2">Staff</option>
                                                    <option value="3">Dosen</option>
                                                </select>
                                                <div class="input-group-append">
                                                <label class="input-group-text" for="role">
                                                    <span class="fas fa-users"></span>
                                                </label>
                                                </div>
                                                @error('role')
                                                <span class="error invalid-feedback">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            {{-- END CUSTOM ADD ROLE --}}

                                            <div class="input-group mb-3">
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="{{ __('Email') }}" required autocomplete="email">
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
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="{{ __('Password') }}" required autocomplete="new-password">
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

                                            <div class="input-group mb-3">
                                                <input type="password" name="password_confirmation"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit"
                                                        {{-- class="btn btn-primary btn-block">{{ __('Register') }} --}}
                                                        class="btn btn-primary btn-block">{{ __('Tambah') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                            {{-- END DEFAULT VIEW REGISTER --}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    
@endsection

@section('scripts')
<script type="module">
    $( document ).ready(function() {

        // GET DATA DOSEN FROM API
        $.ajax({
            url: 'api/dosen',
            method: 'GET',
            data: {
            },
            beforeSend: function () {
                $('#content').hide();
                $('#loading').show();
            },
            success: function(data) {
                var select = $('#name');

                $.each(data, function(index, item) {
                console.log(item);
                    var option = $('<option></option>');
                    option.val(item.kode);
                    option.text(item.kode + '-' +item.dosen);
                    select.append(option);
                });
                $('#content').show();
                $('#loading').hide();
                // Handle the response data here
                console.log(data);
            },
            error: function(xhr, status, error) {
                // Handle the error here
                console.log(error);
            }
        });

    });
</script>
@endsection