@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Halaman Daftar Pengguna</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="m-2">
                            @if ($message = Session::get('success'))
                                <div id="alertFlash" class="alert alert-success alert-block">
                                    <button id="closeAlert" type="button" class="close" data-dismiss="alert">×</button>	
                                <span>{{ $message }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-0">
                            <table class="table m-1">
                                <thead class="fit-bg-color-secondary">
                                    <tr>
                                        <th>Kode Dosen</th>
                                        <th>Role</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <a href="/user/edit/{{ $user->uid }}" class="btn fit-bg-color-secondary">Edit</a>
                                            <a href="/user/resetpass/{{ $user->uid }}" class="btn btn-warning">Reset Password</a>
                                            <a id="btnHapus" href="/user/hapus/{{ $user->uid }}" class="btn btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $users->links() }}
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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    $('#closeAlert').on('click', function() {
        $('#alertFlash').hide();
    });

    $(document).on('click','#btnHapus', function(event) {
        console.log(this);
        event.preventDefault();
        alertify.confirm("PERINGATAN","Apakah anda yakin?",function(){
            alertify.success('Update berhasil')
            var url = $('#btnHapus').attr('href');
            window.location.href = url;
        },
        function(){
            alertify.error('Cancel')
        });
    });

});
</script>
@endsection