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

            <div id="content" class="row hide">
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
                                            
                                            {{-- <div class="input-group row mb-2">
                                                <label class="col-sm-2 col-form-label">Waktu</label> 
                                                <select name="timeStart" id="timeStart" class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="-">Pilih Semua</option>
                                                    <option value="1">1 | 07:30-08:30</option>
                                                    <option value="2">2 | 08:30-09:30</option>
                                                    <option value="3">3 | 09:30-10:30</option>
                                                    <option value="4">4 | 10:30-11:30</option>
                                                    <option value="5">5 | 11:30-12:30</option>
                                                    <option value="6">6 | 12:30-13:30</option>
                                                    <option value="7">7 | 13:30-14:30</option>
                                                    <option value="8">8 | 14:30-15:30</option>
                                                    <option value="9">9 | 15:30-16:30</option>
                                                    <option value="10">10 | 16:30-17:30</option>
                                                </select>
                                                <label class="col-sm-1 col-form-label text-center">sd</label>
                                                <select name="timeEnd" id="timeEnd" class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="-">Pilih Semua</option>
                                                    <option value="1">1 | 07:30-08:30</option>
                                                    <option value="2">2 | 08:30-09:30</option>
                                                    <option value="3">3 | 09:30-10:30</option>
                                                    <option value="4">4 | 10:30-11:30</option>
                                                    <option value="5">5 | 11:30-12:30</option>
                                                    <option value="6">6 | 12:30-13:30</option>
                                                    <option value="7">7 | 13:30-14:30</option>
                                                    <option value="8">8 | 14:30-15:30</option>
                                                    <option value="9">9 | 15:30-16:30</option>
                                                    <option value="10">10 | 16:30-17:30</option>
                                                </select>
                                            </div> --}}
                                            <div class="text-right mr-2">
                                                <button id="submitBtn" type="submit" class="btn btn-primary btn-custom-submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- <div class="row justify-content-end mt-3">
                                    <div class="col-lg-3">
                                        <form action="{{ route('home.search') }}" method="GET">
                                            <div class="input-group mb-3">
                                                <label class="form-label" for="search"></label>
                                                <input type="search" name="search" id="search" class="form-control"  placeholder="Hari / Kelas / Mata Kuliah" aria-label="Hari /Kelas / Mata Kuliah" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                                </p>
                                <div class="row mt-3">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table w100p">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Hari</th>
                                                        <th>Tanggal</th>
                                                        <th>Kode Ruangan</th>
                                                        <th>kode Jam</th>
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
            {{-- Modal --}}
            {{-- <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close btnModalClose">&times;</span> --}}
                    <!-- Modal content -->
                    {{-- <h2 class="text-center mb-2" id="titleModal"></h2>
                    <div class="input-group row mb-2">
                        <label for="selPindah" class="col-sm-2 col-form-label">Pindah Jam dari</label>
                        <select name="selPindah" id="selPindah" class="custom-select select2" aria-label="Default select example">
                            <option selected value="-">Pilih Semua</option>
                        </select>
                    </div>

                    <div class="containerCardListJam">
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btnModalClose" data-dismiss="modal">Close</button>
                        <form action="{{ route('check') }}" method="get">
                            <input type="hidden">
                            <input type="hidden">
                            <input type="hidden">
                            <button type="submit" class="btn btn-success">Pilih Manual</button>
                        </form> --}}
                        {{-- <a href="{{ route('check') }}" class="btn btn-success">Pilih Manual</a> --}}
                    {{-- </div>
                </div>
            </div> --}}
            {{-- End Modal --}}
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
    var listIdBaru = $('#listIdBaru').val()
    var tmpDosen = $('#dosen').val();
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

    /** START BLOCK VALIDATE WAKTU **/ 
    // $('#timeStart').change(function() {
    // startTime = parseInt($(this).val());
    // // Remove options in timeEnd select that are less than the selected start time
    // $('#timeEnd option').each(function() {
    //     endTime = parseInt($(this).val());
    //     if (endTime < startTime) {
    //         $(this).remove();
    //     }
    //     });
    // });

    // $('#timeStart, #timeEnd').change(function() {
    // startTime = parseInt($('#timeStart').val());
    // endTime = parseInt($('#timeEnd').val());
    // if (startTime > endTime) {
    //     alertify.alert("Perhatian","Invalid time range. Start time cannot be greater than end time.");
    //     // Reset the values to the default option
    //     $('#timeStart').val('-');
    //     $('#timeEnd').val('-');
    //     }
    // });
    /** END BLOCK VALIDATE WAKTU **/ 



    function load() {
        if (userRole != 1 && userRole != 2) {
            detailDosen(dosen); 
        }
        loadGedung(lokasi);
        loadRuangan(lokasi, gedung, lantai);
        $('#loading').hide();
        $('#content').show();
    }

    load();

    $(document).on('click', '.open-modal', function() {
        var tmpId = $(this).attr('id');
        listIdBaru = tmpId.substring(9);
        listIdBaru = listIdBaru.replace(/-/g, '/');

        alertify.confirm("PERINGATAN","Apakah anda yakin?",
        function(){
            // UPDATE JADWAL VIA API
            var dataParam = { kode_dosen: dosen, list_id_awal: listId , list_id_baru: listIdBaru};
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
                    console.log(data.status);
                    if (data.status == '200') {
                        alertify.success('Update berhasil');
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
        // if (isUpdate == 'Y') {
        //     console.log('update');
        //     updateJadwal(dosen, listId, listIdBaru);
        // }
    });

    // UPDATE JADWAL VIA API
    // function updateJadwal(kode_dosen, list_id_awal, list_id_baru) {
    //     var dataParam = { kode_dosen: dosen, list_id_awal: list_id_awal , list_id_baru:list_id_baru};
    //     var data = $.param(dataParam);
    //     $.ajax({
    //         url: 'api/jadwal',
    //         method: 'PUT',
    //         data: data,
    //         beforeSend: function () {
    //             // $('#content').hide();
    //             // $('#loading').show();
    //             console.log("before update");
    //         },
    //         success: function(data) {
    //             console.log("after update");
    //             console.log(data.status);
    //             if (data.status == '200') {
    //                 window.status = '200';
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.log(error);
    //         }
    //     });
    // }


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
                // $('#content').hide();
                // $('#loading').show();
                // console.log("before gedung");
            },
            success: function(data) {
                // console.log("after gedung");
                // console.log(data);
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
                // $('#content').hide();
                // $('#loading').show();
                // console.log("before lantai");
            },
            success: function(data) {
                // console.log("after lantai");
                // console.log(data);
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
                // $('#content').hide();
                // $('#loading').show();
                // console.log("before ruangan");
            },
            success: function(data) {
                // console.log("after ruangan");
                // console.log(data);
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
        console.log(encodeDataDosen);
        $.ajax({
            type: 'POST',
            url: '/api/dosen',
            data: encodeDataDosen,
            beforeSend: function() {
                // console.log("beforeSend");
            },
            success: function(data) {
                // console.log(data);
                $('#kodeDosen').html('Kode Dosen : ' + data.dosen.kode);
                $('#namaDosen').html('Nama Dosen : ' + data.dosen.dosen);
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
                console.log("berfore get jadwal available");
            },
            success: function(data) {
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
                        "data": "kode_ruangan"
                    },
                    {
                        "data": "concat_jam"
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
        // console.log('lokasi ' + lokasi + ' gedung ' + gedung + ' lantai ' + lantai);
        // console.log('tanggal mulai ' + startDate + ' tanggal selesai ' + endDate);
    });

});

</script>
@endsection
