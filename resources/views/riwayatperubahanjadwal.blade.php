@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div id="test" class="col-sm-6">
                    {{-- <h1 class="m-0">{{ __('Dashboard') }}</h1> --}}
                    <h1 class="ml-2">Halaman Riwayat Perubahan Jadwal</h1>
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
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table w100p">
                                            <thead class="text-center fit-bg-color-secondary">
                                                <tr>
                                                    <th class="text-center fit-text-color-2">No</th>
                                                    <th class="text-center fit-text-color-2">Kode Kelas</th>
                                                    <th class="text-center fit-text-color-2">Hari Awal</th>
                                                    <th class="text-center fit-text-color-2">Hari</th>
                                                    <th class="text-center fit-text-color-2">Tanggal Awal</th>
                                                    <th class="text-center fit-text-color-2">Tanggal</th>
                                                    <th class="text-center fit-text-color-2">Mata Kuliah</th>
                                                    <th class="text-center fit-text-color-2">Pertemuan</th>
                                                    <th class="text-center fit-text-color-2">Kode Ruangan Awal</th>
                                                    <th class="text-center fit-text-color-2">Kode Ruangan</th>
                                                    <th class="text-center fit-text-color-2">Kode Jam Awal</th>
                                                    <th class="text-center fit-text-color-2">Kode Jam</th>
                                                    <th class="text-center fit-text-color-2">Dirubah Oleh</th>
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
    var userId = $('#userId').val();
    var dosen = (userRole == '1' || userRole == '2') ? '-' : userId;
    console.log(dosen);
    
    function load() {
        loadRiwayatPerubahanJadwal();
    }
    // INIT LOAD ALL DATA
    load();


    // LOAD DATA TANGGAL MERAH FROM API
    function loadRiwayatPerubahanJadwal() {
        var data = $.param({kode_dosen: dosen});
        $.ajax({
            type: 'POST',
            url: '/api/jadwal/riwayat',
            data: data,
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
                        "data": data.jadwal,
                        language: {
                            zeroRecords: "Tidak ada perubahan jadwal"
                        },
                        "columns": [{
                            "data": "no",
                            "render": function(data, type, row, meta) {
                                return i++;
                            }
                        },
                        {
                            "data": "kode_kelas"
                        },
                        {
                            "data": "hari"
                        },
                        {
                            "data": "hari_new"
                        },
                        {
                            "data": "tanggal"
                        },
                        {
                            "data": "tanggal_new"
                        },
                        {
                            "data": "matkul"
                        },
                        {
                            "data": "pertemuan"
                        },
                        {
                            "data": "kode_ruangan"
                        },
                        {
                            "data": "kode_ruangan_new"
                        },
                        {
                            "data": "concat_jam"
                        },
                        {
                            "data": "concat_jam"
                        },
                        {
                            "data": "nama"
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