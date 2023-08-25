@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div id="test" class="col-sm-6">
                    {{-- <h1 class="m-0">{{ __('Dashboard') }}</h1> --}}
                    <h1 class="ml-2">Halaman Menu Tanggal Merah</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            {{-- START LOADING --}}
            <div id="loading" class="row" style="block">
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
            <div id="content" class="row" style="display: none">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                <div id="alertFlash" class="alert alert-success alert-block">
                                    <button id="closeAlert" type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                                </div>
                            @elseif($message = Session::get('failed'))
                                <div id="alertFlash" class="alert alert-danger alert-block">
                                    <button id="closeAlert" type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <input type="hidden" name="userId" id="userId" value="{{ Auth::user()->name }}">
                            <input type="hidden" name="userRole" id="userRole" value="{{ Auth::user()->role }}">
                            <button id="btnTambah" class="btn fit-bg-color-primary mx-1 mb-2" data-toggle="modal" data-target="#modalTambah" style="width: 120px">Tambah</button>
                            {{-- Start Modal Tambah Tanggal Merah --}}
                            <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <form id="formTambahTanggalMerah" action="{{ route('tanggalmerah.tambah') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah Tanggal Merah</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group mb-2">
                                                    <label for="tanggal" class="col-form-label">Tanggal</label>
                                                    <input type="date" data-date="" data-date-format="DD MMMM YYYY" value="2023-01-01" name="tanggal" id="tanggal" data-provide="datepicker" class="datepicker form-control">
                                                    <div class="form-group">
                                                        <label for="keterangan">Keterangan</label>
                                                        <input class="form-control" name="keterangan" id="keterangan" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                                                <button id="btnTambah" class="btn fit-bg-color-primary text-left">Tambah</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- End Modal Tambah Tanggal Merah --}}
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table w100p">
                                            <thead class="text-center fit-bg-color-primary">
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Tanggal Merah</th>
                                                    <th class="text-center">Keterangan</th>
                                                    <th class="text-center">Pilih</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                
                                            </tbody>
                                        </table>
                                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready( function () {
    var userRole = $('#userRole').val();
    
    function load() {
        loadTanggalMerah();
    }
    // INIT LOAD ALL DATA
    load();

    $(document).on('click', 'btnTambah', function() {
    });

    $(document).on('click', '.btnHapus', function(event) {
        event.preventDefault();
        var tanggalmerah = $(this).attr('id');
        alertify.confirm("PERINGATAN","Apakah anda yakin?",
            function(){
                alertify.success('Berhasil hapus tanggal merah');
                window.location.href = '/tanggalmerah/hapus/'+tanggalmerah;
            },
            function(){
            alertify.error('Cancel');
        });
    });

    // LOAD DATA TANGGAL MERAH FROM API
    function loadTanggalMerah() {
        $.ajax({
            type: 'POST',
            url: '/api/tanggalmerah',
            // data: data,
            beforeSend: function() {
                loadingProses();
                console.log("berfore");
            },
            success: function(data) {
                loadingSelesai();
            // $('#dataTable').DataTable().destroy();
            console.log(data);
            var i = 1;
                $('#dataTable').DataTable({
                    "data": data.tanggalmerah,
                    "columns": [{
                        "data": "no",
                        "render": function(data, type, row, meta) {
                            return i++;
                        }
                    },
                    {
                        "data": "tanggal_merah"
                    },
                    {
                        "data": "ket"
                    },
                    {
                        "data": "tanggal_merah", "width" : "50px", 
                        "render": function (data) {
                            return '<button type="button" id="' + data + '" class="btn btn-danger m-1 btnHapus">Hapus</button>'
                        }
                    },
                ],
                });
            }
        });
    }

    

    // Loading Proses
    function loadingProses() {
        $('#content').css("display", "none");
        $('#loading').css("display", "block");
    }
    function loadingSelesai() {
        $('#loading').css("display", "none");
        $('#content').css("display", "block");
    }

});
</script>
@endsection