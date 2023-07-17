@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div id="test" class="col-sm-6">
                    {{-- <h1 class="m-0">{{ __('Dashboard') }}</h1> --}}
                    <h1 class="ml-2">Halaman Jadwal Mengajar di Tanggal Merah</h1>
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
                            @if(Auth::user()->role == 3)
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
                            <input type="hidden" name="userId" id="userId" value="{{ Auth::user()->name }}">
                            <input type="hidden" name="userRole" id="userRole" value="{{ Auth::user()->role }}">
                            <input type="hidden" name="lastLogin" id="lastLogin" value="{{ Auth::user()->last_login }}">
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table w100p">
                                            <thead class="text-center fit-bg-color-secondary">
                                                <tr>
                                                    <th class="text-center fit-text-color-2">No</th>
                                                    <th class="text-center fit-text-color-2">Hari</th>
                                                    <th class="text-center fit-text-color-2">Tanggal</th>
                                                    <th class="text-center fit-text-color-2">Mata Kuliah</th>
                                                    <th class="text-center fit-text-color-2">Jam</th>
                                                    <th class="text-center fit-text-color-2">Kode Ruangan</th>
                                                    <th class="text-center fit-text-color-2">Kode Kelas</th>
                                                    <th class="text-center fit-text-color-2">Pertemuan</th>
                                                    <th class="text-center fit-text-color-2">Kode Dosen</th>
                                                    <th class="text-center fit-text-color-2">Dosen</th>
                                                    <th class="text-center fit-text-color-2">Detail</th>
                                                    <th class="text-center fit-text-color-2">Pilih</th>
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
            {{-- Modal Detail--}}
            <div id="modalDetail" class="modal" tabindex='-1'>
                <div class="modal-content">
                    <span class="close btnModalClose">&times;</span>
                    <!-- Modal content -->
                    <h2 class="text-center mb-3 mt-4">Detail Jadwal</h2>
                    <div id="keteranganTanggal" class="text-center">
                        <div class="alert alert-danger" role="alert">
                            Tanggal <span id="tanggal" class="font-weight-bold"></span> bertepatan dengan <span id="detailKetranganTanggal" class="font-weight-bold"></span>. Mohon lakukan perubahan jadwal.
                        </div>
                    </div>
                    <div id="perubahanFalse" class="text-center">
                        <span class="list-decorate-none">Tidak ada perubahan jadwal</span>
                    </div>
                    <div id="perubahanTrue" >
                        <ul>
                            <li id="kdKelas" class="list-decorate-none">Kode Kelas : </li>
                            <li id="kdDosen" class="list-decorate-none">Kode Dosen : </li>
                            <li id="nmDosen" class="list-decorate-none">Nama Dosen : </li>
                            <li id="tglAwal" class="list-decorate-none color-salmon">Tanggal Awal : </li>
                            <li id="wktAwal" class="list-decorate-none color-salmon">Waktu Awal : </li>
                            <li id="rgAwal" class="list-decorate-none color-salmon">Ruang Awal : </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btnModalClose" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            {{-- End Modal Detail--}}
            {{-- Modal Rekomendasi--}}
            <div id="modalRekomendasi" class="modal">
                <div class="modal-content">
                    <span class="close btnModalClose">&times;</span>
                    <!-- Modal content -->
                    <h2 class="text-center mb-3 mt-4" id="titleModal">Pilih Rerkomendasi Jadwal</h2>
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
            {{-- End Modal Rekomendasi--}}
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready( function () {

    
    var tmpDosen = $('#dosen').val();
    var userId = $('#userId').val();
    var userRole = $('#userRole').val();
    var dosen = (userRole == 3) ? tmpDosen : '-';
    var type = '';
    var listIdAwal = '';
    var listIdBaru = '';
    
    function load() {
        if (userRole != 1 && userRole != 2) {
            detailDosen(dosen); 
        }
        jadwalTanggalMerah(dosen);
    }
    // INIT LOAD ALL DATA
    load();

    $(document).on('click', '.btnDetail', function() {
        // get detail row
        let rowData = this.parentElement.parentElement.childNodes;
        let tanggal = rowData[2].textContent;
        let kodeKelas = rowData[6].textContent;
        let kodeDosen = rowData[7].textContent;
        let namaDosen = rowData[8].textContent;
        let flag = rowData[11].childNodes[1].getAttribute('class');
        let ketTanggalMerah = rowData[11].childNodes[2].getAttribute('class');

        // cek tanggal merah
        if (flag == 'L') {
            $('#tanggal').text(tanggal);
            $('#detailKetranganTanggal').text(ketTanggalMerah);
            $('#keteranganTanggal').show();
        } else {
            $('#keteranganTanggal').hide();
        }

        let ketJadwal = this.id;
        let arrKetJadwal = ketJadwal.split("|");
        let detailKet = arrKetJadwal[1];
        // console.log(detailKet);
        if (detailKet != 'null') {
            // console.log('masuk if');
            let detailPerubahan = detailKet;
            let arrDetail = detailPerubahan.split(";");
            let exTanggal = arrDetail[0];
            let exWaktu = arrDetail[1];
            let exRuangan = arrDetail[2];

            // Isi detial jadwal
            $('#perubahanFalse').hide();
            $('#perubahanTrue').show();
            $('#kdKelas').text('Kode Kelas : ' + kodeKelas);
            $('#kdDosen').text('Kode Dosen : ' + kodeDosen);
            $('#nmDosen').text('Nama Dosen : ' + namaDosen);
            $('#tglAwal').text('Tanggal Awal : ' + exTanggal);
            $('#wktAwal').text('Waktu Awal : ' + exWaktu);
            $('#rgAwal').text('Ruangan Awal : ' + exRuangan);
            
        } else {
            // console.log("masuk else");
            $('#perubahanTrue').hide();
            $('#perubahanFalse').show();
        }
        

        
        $('#modalDetail').show();
    });

    $(document).on('click', '.open-modal', function() {
        // type = $(this).text();
        type = 'sementara';
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
        $('#modalRekomendasi').show();
    });


    $(document).on('click', '.cardRekomendasi', function() {
        $('#modalRekomendasi').hide();
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
            var dataParam = { type: type, kode_dosen: dosen, list_id_awal: listIdAwal , list_id_baru: listIdBaru, user_id: userId};
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
                        window.location.href = '/menu/jadwaltanggalmerah';
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

    // LOAD DATA JADWAL TANGGAL MERAH FROM API
    function jadwalTanggalMerah(dosen) {
        var dataParam = { kode_dosen: dosen };
        var data = $.param(dataParam);
        $.ajax({
            type: 'POST',
            url: '/api/jadwal/tanggalmerah',
            data: data,
            beforeSend: function() {
                loadingProses();
                console.log("berfore jadwal");
            },
            success: function(data) {
                loadingSelesai();
            // $('#dataTable').DataTable().destroy();
            console.log(data);
            var i = 1;
                $('#dataTable').DataTable({
                    "data": data.jadwal,
                    columnDefs: [
                        { width: '20px', targets: [0,4] }, // 0 is first column
                        { width: '50px', targets: [1,2,7] },
                        { width: '120px', targets: [5,6,8] },
                        { width: '150px', targets: [3,9] },
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
                        "data": "ket_jadwal", "width" : "50px", 
                        "render": function (data) {
                            return '<button type="button" id="btnDetail' + i + '|' + data + '" class="btn btn-info m-1 btnDetail" data-toggle="modal" data-target="#modalDetail">Detail</button>'
                        }
                    },
                    {
                        "data": null, "width" : "70px", 
                        "render": function (data, type, row) {
                            return '<button type="button" id="btnSem' + data.concat_kode_jam + '" class="btn btn-primary m-1 open-modal btnSementara" data-toggle="modal" data-target="#modalRekomendasi">Pindah</button><input type="hidden" class="' + data.flag + '"><input type="hidden" class="' + data.ket_tanggal_merah + '">'
                        }
                    }
                ],
                // row merah if hari libur
                // "rowCallback": function(row, data, index) {
                //     if ($(row).find('input').hasClass('L')) {
                //     $(row).addClass('bg-danger');
                //     }
                // }
                });
            }
        });
    }

    // Hapus data global
    function removeModalData() {
        $('#containerCardRekomendasi').empty();
        $('.modal-backdrop.show').remove();
        type = '';
        listIdAwal = '';
        listIdBaru = '';
        $('#keteranganTanggal').hide();
        $('#tanggal').text();
        $('#detailKetranganTanggal').text();
    }

    $(document).keydown(function(e) {
        // Check if the escape key was pressed (key code 27)
        if (e.which === 27) {
            $('.modal').hide();
            removeModalData();
        }
    });

    // Close button click event handler
    $('.btnModalClose').click(function() {
        removeModalData();
        $('.modal').hide();
    });

    $('.btnModalClose').click(function() {
        removeModalData();
        $('.modal').hide();
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

    $('#closeAlert').on('click', function() {
        $('#alertFlash').hide();
    });


});
</script>
@endsection