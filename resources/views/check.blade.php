@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="ml-2">PERUBAHAN JADWAL MENGAJAR</h1>
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
            <div id="content" class="row hide" style="display: none">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">
                                @if( Auth::user()->role == 3)
                                <form action="{{ route('check') }}" class="ml-1 mt-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 id="kodeDosen"> Kode Dosen : - </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 id="namaDosen">Nama Dosen : - </h5>
                                            </div>
                                            <input type="hidden" name="dosen" id="dosen" value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                </form>
                                @endif
                                <input type="hidden" name="userId" id="userId" value="{{ Auth::user()->name }}">
                                <input type="hidden" name="userRole" id="userRole" value="{{ Auth::user()->role }}">
                                <div class="row justify-content-md-center">
                                    <div class="col-lg-6">
                                        <div class="input-group row mb-2">
                                            <div class="col-lg-2"></div>
                                            <div class="col lg 4">
                                                <h5 id="titlePerubahanJadwal" class="text-center">PERUBAHAN JADWAL {{ strtoupper($perubahanData['type']) }}</h5>
                                            </div>
                                        </div>
                                        <form id="formFilter">
                                            <div class="input-group row mb-2">
                                                <label for="selLokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                                <select name="selLokasi" id="selLokasi" class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="E">E</option>
                                                    <option value="D">D</option>
                                                    <option value="G">G</option>
                                                    <option value="C">C</option>
                                                </select>
                                            </div>
                                            <div class="input-group row mb-2">
                                                <label for="selGedung" class="col-sm-2 col-form-label">Gedung</label>
                                                <select name="selGedung" id="selGedung" class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="-">Pilih Semua</option>
                                                </select>
                                            </div>
                                            <div class="input-group row mb-2">
                                                <label for="selLantai" class="col-sm-2 col-form-label">Lantai</label>
                                                <select name="selLantai" id="selLantai" class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="-">Pilih Semua</option>
                                                </select>
                                            </div>
                                            <div class="input-group row mb-2">
                                                <label for="selRuangan" class="col-sm-2 col-form-label">Ruangan</label>
                                                <select name="selRuangan" id="selRuangan" class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="-">Pilih Semua</option>
                                                </select>
                                            </div>
                                            <div class="input-group row mb-2">
                                                <label for="" class="col-sm-2 col-form-label">Tanggal</label>
                                                <input type="date" data-date="" data-date-format="DD MMMM YYYY" value="2023-01-01" name="startDate" id="startDate" data-provide="datepicker" class="col-sm-5 datepicker form-control">
                                                <label for="" class="col-sm-1 col-form-label text-center">sd</label>
                                                <input type="date" data-date="" data-date-format="DD MMMM YYYY" value="2030-12-31" name="endDate" id="endDate" data-provide="datepicker" class="col-sm-5 datepicker form-control">
                                            </div>
                                            <div class="text-right mr-2">
                                                <button id="submitBtn" type="submit" class="btn btn-primary btn-custom-submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </p>
                                <div class="row my-3">
                                    <div class="col-sm 12">
                                        <div class="table-responsive">
                                            <h5 id="" class="text-center">DATA JADWAL AWAL</h5>
                                            <table id="tableDataAwal" class="table w100p">
                                                <thead>
                                                    <th>No</th>
                                                    <th>Hari</th>
                                                    <th>Tanggal</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>Jam</th>
                                                    <th>Kode Ruangan</th>
                                                    <th>Kode Kelas</th>
                                                    <th>Pertemuan</th>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <h5 id="" class="text-center">DATA JADWAL YANG TERSEDIA</h5>
                                            <table id="dataTable" class="table w100p">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Hari</th>
                                                        <th>Tanggal</th>
                                                        <th>Mata Kuliah</th>
                                                        <th>Jam</th>
                                                        <th>Kode Ruangan</th>
                                                        <th>Pertemuan</th>
                                                        <th>Pindah Jadwal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
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
            <div id="hiddenData">
                <input type="hidden" name="type" id="type" value="{{ $perubahanData['type'] }}">
                <input type="hidden" name="count_time" id="count_time" value="{{ $perubahanData['count_time'] }}">
                <input type="hidden" name="listId" id="listId" value="{{ $perubahanData['listId'] }}">
                <input type="hidden" name="listIdBaru" id="listIdBaru" value="">
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
<script type="module">
$( document ).ready(function() {
    var type = $('#type').val();
    var count_time = $('#count_time').val();
    var listId = $('#listId').val()
    console.log(listId);
    var listIdBaru = $('#listIdBaru').val()
    var tmpDosen = $('#dosen').val();
    var userId = $('#userId').val();
    var userRole = $('#userRole').val();
    var dosen = (userRole == 3) ? tmpDosen : '-';
    var lokasi = $('#selLokasi').val();
    var gedung = $('#selGedung').val();
    var lantai = $('#selLantai').val();
    var ruangan = $('#selRuangan').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var startTime = parseInt($('#timeStart').val());
    var endTime = parseInt($('#timeEnd').val());

    $('#startDate, #endDate').change(function() {
        startDate = $('#startDate').val();
        endDate = $('#endDate').val();
        if (startDate > endDate) {
        alertify.alert("Perhatian","Tanggal Awal harus lebih kecil dari Tanggal Akhir");
            // Reset the values to the default option
            $('#startDate').val('-');
            $('#endDate').val('-');
        }

        console.log('Start Date:', startDate);
        console.log('End Date:', endDate);
    });

    function load() {
        if (userRole != 1 && userRole != 2) {
            detailDosen(dosen);
        }
        loadJadwalAwal(listId);
        loadGedung(lokasi);
        loadRuangan(lokasi, gedung, lantai);
        loadingSelesai();
    }
    // INIT LOAD ALL DATA
    load();

    $(document).on('click', '.open-modal', function() {
        var tmpId = $(this).attr('id');
        listIdBaru = tmpId.substring(9);
        listIdBaru = listIdBaru.replace(/-/g, '/');

        alertify.confirm("PERINGATAN","Apakah anda yakin?",
        function(){
            // UPDATE JADWAL VIA API
            var dataParam = { type: type, kode_dosen: dosen, list_id_awal: listId , list_id_baru: listIdBaru, user_id: userId};
            var data = $.param(dataParam);
            $.ajax({
                url: 'api/jadwal',
                method: 'PUT',
                data: data,
                beforeSend: function () {
                    // $('#content').hide();
                    // $('#loading').show();
                    console.log("before update");
                },
                success: function(data) {
                    console.log("after update");
                    if (data.status == '200') {
                        alertify.success('Update berhasil');
                        window.location.href = '\home';
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        },
        function(){
            alertify.error('Cancel');
        });
    });

    $(document).keydown(function(e) {
        // Check if the escape key was pressed (key code 27)
        if (e.which === 27) {
            $('#myModal').hide();
        }
    });

    // Close button click event handler
    $('.btnModalClose').click(function() {
        $('#titleModal').html("");
        $('#myModal').hide();
    });

    $('#selLokasi').change(function() {
        $('#selGedung option').remove();
        $('#selLantai option').remove();
        $('#selRuangan option').remove();
        $('#selGedung').append('<option value="-">Pilih Semua</option>');
        $('#selLantai').append('<option value="-">Pilih Semua</option>');
        $('#selRuangan').append('<option value="-">Pilih Semua</option>');
        lokasi = $('#selLokasi').val();
        if (lokasi != 'E') {
            alertify.alert("Perhatian","Akses ditolak!");
            $('#selLokasi').val('E');
        } 
        lokasi = $('#selLokasi').val();
        loadGedung(lokasi);
        
    });

    $('#selGedung').change(function() {
        $('#selLantai option').remove();
        $('#selRuangan option').remove();
        $('#selLantai').append('<option value="-">Pilih Semua</option>');
        $('#selRuangan').append('<option value="-">Pilih Semua</option>');
        lokasi = $('#selLokasi').val();
        gedung = $('#selGedung').val();
        if (lokasi != '-' && lokasi != null) {
            loadLantai(lokasi,gedung);
            loadRuangan(lokasi, gedung, lantai);
        } else {
            alertify.alert("Perhatian","Pilih Lokasi terlebih dulu!");
        }
    });

    $('#selLantai').change(function() {
        $('#selRuangan option').remove();
        $('#selRuangan').append('<option value="-">Pilih Semua</option>');
        lokasi = $('#selLokasi').val();
        gedung = $('#selGedung').val();
        lantai = $('#selLantai').val();
        if (lokasi != '-' && lokasi != null) {
            if (gedung != '-' && gedung != null) {
                var selLantai = $('#selLantai');
                loadRuangan(lokasi, gedung, lantai);
            } else {
                alertify.alert("Perhatian","Pilih Gedung terlebih dulu!");
            }
        } else {
            alertify.alert("Perhatian","Pilih Lokasi terlebih dulu!");
        }
    });

    $('#selRuangan').change(function() {
        ruangan = $('#selRuangan').val();
    });




    // DATA GEDUNG FROM API
    function loadGedung(lokasi) {
        var dataParam = { kodeLokasi: lokasi, available: 'Y' };
        var data = $.param(dataParam);
        $.ajax({
            url: 'api/gedung',
            method: 'POST',
            data: data,
            beforeSend: function () {
            },
            success: function(data) {
                var selGedung = $('#selGedung');
                selGedung.empty();
                var defaultOption = $('<option></option>').text('Pilih Semua').val('-');
                selGedung.append(defaultOption);
                for (var i = 0; i < data.gedung.length; i++) {
                    var option = $('<option></option>').text(data.gedung[i].gedung).val(data.gedung[i].gedung);
                    selGedung.append(option);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    // DATA LANTAI FROM API
    function loadLantai(lokasi, gedung) {
        var dataParam = { kodeLokasi: lokasi , kodeGedung: gedung, available: 'Y'};
        var data = $.param(dataParam);
        $.ajax({
            url: 'api/lantai',
            method: 'POST',
            data: data,
            beforeSend: function () {
            },
            success: function(data) {
                var selLantai = $('#selLantai');
                selLantai.empty();
                var defaultOption = $('<option></option>').text('Pilih Semua').val('-');
                selLantai.append(defaultOption);
                for (var i = 0; i < data.lantai.length; i++) {
                    var option = $('<option></option>').text(data.lantai[i].lantai).val(data.lantai[i].lantai);
                    selLantai.append(option);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    // DATA RUANGAN FROM API
    function loadRuangan(lokasi, gedung = '-', lantai = '-') {
        var dataParam = { kodeLokasi: lokasi , kodeGedung: gedung, kodeLantai: lantai, available: 'Y' };
        var data = $.param(dataParam);
        $.ajax({
            url: 'api/ruangan',
            method: 'POST',
            data: data,
            beforeSend: function () {
            },
            success: function(data) {
                var selRuangan = $('#selRuangan');
                selRuangan.empty();
                var defaultOption = $('<option></option>').text('Pilih Semua').val('-');
                selRuangan.append(defaultOption);
                for (var i = 0; i < data.ruangan.length; i++) {
                    var option = $('<option></option>').text(data.ruangan[i].kode).val(data.ruangan[i].kode);
                    selRuangan.append(option);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    // DETAIL DOSEN FROM API
    function detailDosen(dosen) {
        var dataParam = { kodeDosen: dosen };
        var encodeDataDosen = $.param(dataParam);
        $.ajax({
            type: 'POST',
            url: '/api/dosen',
            data: encodeDataDosen,
            beforeSend: function() {
            },
            success: function(data) {
                $('#kodeDosen').html('Kode Dosen : ' + data.dosen.kode);
                $('#namaDosen').html('Nama Dosen : ' + data.dosen.dosen);
            }
        });
    }

    // LOAD DATA JADWAL FROM API
    function loadJadwalAwal(list_id) {
        var dataParam = { list_id: list_id};
        var data = $.param(dataParam);
        $.ajax({
            type: 'POST',
            url: '/api/jadwal',
            data: data,
            beforeSend: function() {
                loadingProses();
            },
            success: function(data) {
                loadingSelesai();
                // $('#tableDataAwal').DataTable().destroy();
                var i = 1;
                $('#tableDataAwal').DataTable({
                    searching: false,
                    paging: false,
                    language: {
                    info: ""
                    },
                    "data": data.jadwal,
                    "columns": [{
                        "data": "no",
                        "render": function(data, type, row, meta) {
                            return i++;
                        }
                    },
                    {
                        "data": "hari"
                    },
                    {
                        "data": "tanggal"
                    },
                    {
                        "data": "matkul"
                    },
                    {
                        "data": "concat_jam"
                    },
                    {
                        "data": "kode_ruangan"
                    },
                    {
                        "data": "kode_kelas"
                    },
                    {
                        "data": "pertemuan"
                    },
                ],
                "rowCallback": function(row, data, index) {
                    if (index === 0) {
                        $(row).addClass('bg-color-lightgray');
                    }
                }
                });
            }
        });
    }

    // LOAD DATA JADWAL AVAILABLE FROM API
    function loadJadwalAvailable(dataParam) {
        var data = $.param(dataParam);
        $.ajax({
            type: 'POST',
            url: '/api/jadwalavailable',
            data: data,
            beforeSend: function() {
                loadingProses();
                console.log("berfore get jadwal available");
            },
            success: function(data) {
                loadingSelesai();
                $('#dataTable').DataTable().destroy();
                console.log("after jawal available");
                console.log(data);
                var i = 1;
                $('#dataTable').DataTable({
                    "data": data.jadwalavailable,
                    "columns": [{
                        "data": "no",
                        "render": function(data, type, row, meta) {
                            return i++;
                        }
                    },
                    {
                        "data": "hari"
                    },
                    {
                        "data": "tanggal"
                    },
                    {
                        "data": "kode_matkul"
                    },
                    {
                        "data": "concat_jam"
                    },
                    {
                        "data": "kode_ruangan"
                    },
                    {
                        "data": "pertemuan"
                    },
                    {
                        "data": "concat_kode_jam", "width" : "50px", 
                        "render": function (data) {
                            return '<button type="button" id="btnPindah' + data + '" class="btn btn-primary open-modal" data-toggle="modal" data-target="#modal' + data + '">Pindah</button>'
                        }
                    }
                ]
                });
            }
        });
    }



    $("#submitBtn").click(function(event){   
        event.preventDefault();
        var dataParam = {
            type: type,
            list_id: listId,
            kode_dosen: dosen,
            kode_lokasi: lokasi,
            kode_gedung: gedung,
            kode_lantai: lantai,
            kode_ruangan: ruangan,
            start_date: startDate,
            end_date: endDate,
            count_time: count_time
        };
        console.log(dataParam);
        loadJadwalAvailable(dataParam);
        console.log('lokasi ' + lokasi + ' gedung ' + gedung + ' lantai ' + lantai);
        console.log('tanggal mulai ' + startDate + ' tanggal selesai ' + endDate);
    });


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
