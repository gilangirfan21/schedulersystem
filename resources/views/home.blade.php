@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div id="test" class="col-sm-6">
                    {{-- <h1 class="m-0">{{ __('Dashboard') }}</h1> --}}
                    <h1 class="ml-2">JADWAL MENGAJAR</h1>
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
                        <div class="card-body">
                            <p class="card-text">
                                @if( Auth::user()->role == 3)
                                <form class="ml-1 mt-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 id="kodeDosen">Kode Dosen : - </h5>
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
                                                    <th>Mata Kuliah</th>
                                                    <th>Jam</th>
                                                    <th>Kode Ruangan</th>
                                                    <th>Kode Kelas</th>
                                                    <th>Pertemuan</th>
                                                    <th>Kode Dosen</th>
                                                    <th>Dosen</th>
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
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close btnModalClose">&times;</span>
                    <!-- Modal content -->
                    <h2 class="text-center mb-3 mt-4" id="titleModal"></h2>
                    <div id="containerCardRekomendasi" class="containerCardRekomendasi">
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('check') }}" method="GET">
                            <input type="hidden" name="type" id="type">
                            <input type="hidden" name="listId" id="listId">
                            <button type="submit" class="btn btn-success">Pilih Manual</button>
                        </form>
                        <button type="button" class="btn btn-secondary btnModalClose" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            {{-- End Modal --}}
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
<script>
$(document).ready( function () {

    var tmpDosen = $('#dosen').val();
    var userRole = $('#userRole').val();
    var dosen = (userRole == 3) ? tmpDosen : '-';
    var type = '';
    var listIdAwal = '';
    var listIdBaru = '';
    
    function load() {
        if (userRole != 1 && userRole != 2) {
            detailDosen(dosen); 
        }
        jadwal(dosen);
    }
    // INIT LOAD ALL DATA
    load();





    $(document).on('click', '.open-modal', function() {
        type = $(this).text();
        $('#type').val(type);
        var tmpId = $(this).attr('id');
        listId = tmpId.substring(6);
        if (listId.length > 2) {
            listId = listId.replace(/-/g, '/');
        }
        $('#listId').val(listId);
        listIdAwal = listId;

        // REKOMENDASI JADWAL FROM API
        var tr = $(this).closest('tr');
        var kodeDosen = tr.find('td').eq(8).text();
        var kodeRuangan = tr.find('td').eq(5).text();
        var tanggal = tr.find('td').eq(2).text();
        var hari = tr.find('td').eq(1).text();
        var listJam = tr.find('td').eq(4).text();
        var dataParam = { 
            type: type,
            kode_dosen: kodeDosen,
            kode_ruangan: kodeRuangan,
            tanggal: tanggal,
            hari: hari,
            list_id: listId,
            list_jam: listJam,
            count_time: null
        };
        var data = $.param(dataParam);
        $.ajax({
            type: 'POST',
            url: '/api/jadwalrekomendasi',
            data: data,
            beforeSend: function() {
                console.log("berfore rekomendasi");
            },
            success: function(data) {
                var listJadwal = data.jadwalavailable.length;
                if (listJadwal > 0) {
                    console.log('after rekomendasi');
                    var i = 1;
                    data.jadwalavailable.forEach(function(jadwal) {
                    var card = $('<div id="cardRekomendasi' + jadwal.concat_kode_jam + '" class="cardRekomendasi"></div>');
                    var ul = $('<ul></ul>');
                    card.append('<h6>Rekomendasi ' + i + '</h6>');
                    card.append(ul);
                    // Append the data to the ul
                    ul.append('<li> Hari     : ' + jadwal.hari + '</li>');
                    ul.append('<li> Tanggal  : ' + jadwal.tanggal + '</li>');
                    ul.append('<li> Jam      : ' + jadwal.concat_jam + '</li>');
                    ul.append('<li> Ruangan  : ' + jadwal.kode_ruangan + '</li>');
                    $('#containerCardRekomendasi').append(card);
                    i++;
                    });
                } else {
                    $('#containerCardRekomendasi').append('<h5 class="mt-5">Tidak Ada Jadwal Tersedia</h5>');
                }
            }
        });

        // Title Modal
        var elementText = $(this).text();
        $('#titleModal').html("Perubahan " + elementText );
        $('#myModal').show();
    });


    $(document).on('click', '.cardRekomendasi', function() {
        $('#myModal').hide();
        var id = $(this).attr('id');
        listIdBaru = id.substring(15);
        if (listIdBaru.length > 2) {
            listIdBaru = listIdBaru.replace(/-/g, '/');
        }
        console.log('type : ' + type);
        console.log('listIdAwal : ' + listIdAwal);
        console.log('listIdBaru : ' + listIdBaru);

        alertify.confirm("PERINGATAN","Apakah anda yakin?",
        function(){
            // UPDATE JADWAL VIA API
            var dataParam = { type: type, kode_dosen: dosen, list_id_awal: listIdAwal , list_id_baru: listIdBaru};
            var data = $.param(dataParam);
            $.ajax({
                url: 'api/jadwal',
                method: 'PUT',
                data: data,
                beforeSend: function () {
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
            $('#containerCardRekomendasi').empty();
            alertify.error('Cancel');
        });
    });

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
    function jadwal(dosen) {
        var dataParam = { kode_dosen: dosen };
        var data = $.param(dataParam);
        $.ajax({
            type: 'POST',
            url: '/api/jadwal',
            data: data,
            beforeSend: function() {
                console.log("berfore jadwal");
            },
            success: function(data) {
            // $('#dataTable').DataTable().destroy();
            console.log(data);
            var i = 1;
                $('#dataTable').DataTable({
                    "data": data.jadwal,
                    columnDefs: [
                        { width: '20px', targets: [0,4] }, // 0 is first column
                        { width: '50px', targets: [1,2,7] },
                        { width: '110px', targets: [5,6,8] },
                        { width: '180px', targets: [3,9] },
                    ],
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
                    {
                        "data": "kode_dosen"
                    },
                    {
                        "data": "dosen"
                    },
                    {
                        "data": "concat_kode_jam", "width" : "50px", 
                        "render": function (data) {
                            return '<button type="button" id="btnSem' + data + '" class="btn btn-primary m-1 open-modal btnSementara" data-toggle="modal" data-target="#modalSem' + data + '">Sementara</button><button type="button" id="btnPer' + data + '" class="btn btn-secondary m-1 open-modal btnPermanen">Permanen</button>'
                        }
                    }
                ]
                });
            }
        });
    }

    // Hapus data global
    function removeModalData() {
        $('#titleModal').html("");
        $('#containerCardRekomendasi').empty();
        type = '';
        listIdAwal = '';
        listIdBaru = '';
    }

    $(document).keydown(function(e) {
        // Check if the escape key was pressed (key code 27)
        if (e.which === 27) {
            $('#myModal').hide();
            removeModalData();
        }
    });

    // Close button click event handler
    $('.btnModalClose').click(function() {
        removeModalData();
        $('#myModal').hide();
    });

});
</script>
@endsection