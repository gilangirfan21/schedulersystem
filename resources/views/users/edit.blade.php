@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Halaman Edit Pengguna</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="container mt-5" style="width: 500px">
                            <form class="form" action="/user/update/{{ $user[0]->uid }}" method="POST">
                            @csrf
                                <div class="form-group">
                                    <label for="name">Kode Dosen</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user[0]->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $user[0]->nama }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user[0]->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn fit-bg-color-secondary" style="width: 120px">Update</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('#closeAlert').on('click', function() {
        $('#alertFlash').hide();
    });
});
</script>
@endsection