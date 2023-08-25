@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div id="test" class="col-sm-6">
                    {{-- <h1 class="m-0">{{ __('Dashboard') }}</h1> --}}
                    <h1 class="ml-2">Halaman Jadwal Mengajar</h1>
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
                                            <h5 id="kodeDosen" class="fit-fs-16px">Kode Dosen : - </h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 id="namaDosen" class="fit-fs-16px">Nama Dosen : - </h5>
                                        </div>
                                        <input type="hidden" name="dosen" id="dosen" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                            </form>
                            @endif
                            @if(in_array(Auth::user()->role, [1,2]))
                            <div class="mb-3 text-center">
                                <div class="d-flex justify-content-center">
                                    <a id="btnExportJadwal" class="btn btn-success text-right mx-1" href="{{ route('exportjadwal') }}">Export Jadwal</a>
                                    <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#modalImportExcel">Import Jadwal</button> 
                                    <!-- Delete button -->
                                    <a type="button" href="/jadwal/hapus" id="btnHapusSemuaJadwal" class="btn btn-danger">Hapus Semua Jadwal</a> 
                                </div>
                                <!-- Start Modal Export Import Excel -->
                                <div class="modal fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <form id="formImportExoport" action="{{ route('importjadwal') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left w-75">
                                                            <input type="file" name="file" class="custom-file-input" id="inputFile">
                                                            <label class="custom-file-label" for="inputFile" id="labelInputFile">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                                                    <button id="btnImportJadwal" class="btn btn-primary text-left">Import</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Modal Export Import Excel -->
                            @endif
                            <input type="hidden" name="userId" id="userId" value="{{ Auth::user()->name }}">
                            <input type="hidden" name="userRole" id="userRole" value="{{ Auth::user()->role }}">
                            <input type="hidden" name="lastLogin" id="lastLogin" value="{{ Auth::user()->last_login }}">
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table w100p">
                                            <thead class="text-center fit-bg-color-primary">
                                                <tr>
                                                    <th class="text-center fit-text-color-2">No</th>
                                                    <th class="text-center fit-text-color-2">Hari</th>
                                                    <th class="text-center fit-text-color-2">Tanggal</th>
                                                    <th class="text-center fit-text-color-2">Kelas</th>
                                                    <th class="text-center fit-text-color-2">Waktu</th>
                                                    <th class="text-center fit-text-color-2">Ruang</th>
                                                    <th class="text-center fit-text-color-2">Mata Kuliah</th>
                                                    <th class="text-center fit-text-color-2">Dosen</th>
                                                    <th class="text-center fit-text-color-2">Pertemuan</th>
                                                    <th class="text-center fit-text-color-2">Detail</th>
                                                    <th id="thPilih" class="text-center fit-text-color-2">Pilih</th>
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
                    <!--<span class="close btnModalClose">&times;</span>-->
                    <!-- Modal content -->
                    <h2 class="text-center mb-3 mt-4 fit-fs-26px">Detail Jadwal</h2>
                    <div id="keteranganTanggal" class="text-center">
                        <div class="alert alert-danger" role="alert">
                            Tanggal <span id="tanggal" class="font-weight-bold"></span> bertepatan dengan <span id="detailKetranganTanggal" class="font-weight-bold"></span>. Mohon lakukan perubahan jadwal.
                        </div>
                    </div>
                    <div id="perubahanFalse" class="text-center">
                        <span class="list-decorate-none fit-fs-16px">Tidak ada perubahan jadwal</span>
                    </div>
                    <div id="perubahanTrue" >
                        <h5 class="text-center fit-fs-16px">Telah Melakukan Perubahan</h5>
                        <h5 id="pertemuan" class="text-center fit-fs-16px">Pertemuan : </h5>
                        <ul class="font-weight-bold">
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-3">
                                    <li id="kdKelas" class="list-decorate-none fit-fs-16px">Kelas      : </li>
                                    <li id="nmDosen" class="list-decorate-none fit-fs-16px">Dosen      : </li>
                                    <li id="matkul" class="list-decorate-none fit-fs-16px">Mata Kuliah : </li>
                                </div>
                                <div class="col-sm-3">
                                    <li id="tglAwal" class="list-decorate-none fit-fs-16px">Tanggal Awal : </li>
                                    <li id="wktAwal" class="list-decorate-none fit-fs-16px">Waktu Awal   : </li>
                                    <li id="rgAwal" class="list-decorate-none fit-fs-16px">Ruang Awal    : </li>
                                </div>
                                <div class="col-sm-3">
                                    <li id="tglBaru" class="list-decorate-none fit-fs-16px">Tanggal Baru : </li>
                                    <li id="wktBaru" class="list-decorate-none fit-fs-16px">Waktu Baru   : </li>
                                    <li id="rgBaru" class="list-decorate-none fit-fs-16px">Ruang Baru    : </li>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-close btnModalClose" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            {{-- End Modal Detail--}}
            {{-- Modal Rekomendasi--}}
            <div id="modalRekomendasi" class="modal">
                <div class="modal-content">
                    {{-- <span class="close btnModalClose">&times;</span> --}}
                    <!-- Modal content -->
                    <h2 class="text-center mb-3 mt-4 fit-fs-26px" id="titleModal">Pilih Rekomendasi Jadwal</h2>
                    <div id="containerCardRekomendasi" class="containerCardRekomendasi">
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('check') }}" method="GET">
                            <input type="hidden" name="type" id="type">
                            <input type="hidden" name="listId" id="listId">
                            <button type="submit" class="btn fit-bg-color-primary">Pilih Manual</button>
                        </form>
                        <button type="button" class="btn btn-close btnModalClose" data-dismiss="modal">Close</button>
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
    var currentDatetime = new Date();

    function NotifTanggalMerah(dosen) {
        if(userRole != 1 && userRole != 2) {
            $.ajax({
                url: 'api/jadwal/tanggalmerah/popup',
                method: 'POST',
                data: $.param({kode_dosen: dosen}),
                beforeSend: function () {
                    console.log("before popup");
                },
                success: function(data) {
                    console.log("after popup");
                    console.log(data.jadwal);
                    if (data.jadwal.tanggalMerah != '') {
                        $(document).Toasts('create', {
                            title: 'PERHATIAN!',
                            body: 'Mohon melakukan perubahan jadwal pada tanggal berikut.<br><span class="font-weight-bold">' + data.jadwal.tanggalMerah + '</span>'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
    
        }
    }

    
    function load() {
        if (userRole != 1 && userRole != 2) {
            detailDosen(dosen); 
        } else {
            $('#thPilih').hide();
        }
        NotifTanggalMerah(dosen);
        jadwal(dosen);
    }
    // INIT LOAD ALL DATA
    load();

    $(document).on('click', '.btnDetail', function() {
        // get detail row
        let rowData = this.parentElement.parentElement.childNodes;
        let pertemuan = rowData[8].textContent;
        let kodeKelas = rowData[3].textContent;
        let namaDosen = rowData[7].textContent;
        let matkul = rowData[6].textContent;
        let tanggal = rowData[2].textContent;
        let newTanggal = rowData[2].textContent;
        let newWaktu = rowData[4].textContent;
        let newRuangan = rowData[5].textContent;
        let flag = rowData[10].childNodes[1].getAttribute('class');
        let ketTanggalMerah = rowData[10].childNodes[2].getAttribute('class');

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
            let exTanggal = arrDetail[2];
            let exWaktu = arrDetail[1];
            let exRuangan = arrDetail[3];

            // Isi detial jadwal
            $('#perubahanFalse').hide();
            $('#perubahanTrue').show();
            $('#pertemuan').text('Pertemuan : ' + pertemuan);
            $('#kdKelas').text('Kelas : ' + kodeKelas);
            $('#nmDosen').text('Dosen : ' + namaDosen);
            $('#matkul').text('Mata Kuliah : ' + matkul);
            $('#tglAwal').text('Tanggal Awal : ' + exTanggal);
            $('#wktAwal').text('Waktu Awal : ' + exWaktu);
            $('#rgAwal').text('Ruangan Awal : ' + exRuangan);
            $('#tglBaru').text('Tanggal Baru : ' + newTanggal);
            $('#wktBaru').text('Waktu Baru : ' + newWaktu);
            $('#rgBaru').text('Ruangan Baru : ' + newRuangan);
            
            
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
        var kodeDosen = dosen;
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
                        window.location.href = '/home';
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        },
        function(){
            $('#containerCardRekomendasi').empty();
            removeModalData();
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
                        { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 8, 9] },
                        { className: 'text-left', targets: [6, 7] },
                        { className: 'rowPindah', targets: 10 },
                        { width: '300px', targets: [6] },
                        { width: '200px', targets: [7] },
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
                        "data": "kode_kelas"
                    },
                    {
                        "data": "concat_jam"
                    },
                    {
                        "data": "kode_ruangan"
                    },
                    {
                        "data": "matkul"
                    },
                    {
                        "data": "dosen"
                    },
                    {
                        "data": "pertemuan"
                    },
                    {
                        "data": null, "width" : "50px", 
                        "render": function (data, type, row) {
                            var dk = data.kode_kelas;
                            var lastChar = dk.charAt(dk.length - 1);
                            if (lastChar == 'A' || lastChar == 'B' || lastChar == 'C') {
                                return '<button type="button" id="btnDetail' + i + '|' + data.ket_jadwal + '" class="btn fit-bg-color-primary m-1 btnDetail btnHide" data-toggle="modal" data-target="#modalDetail">Detail</button>'
                            } else {
                                if (data.ket_jadwal != null) {
                                return '<button type="button" id="btnDetail' + i + '|' + data.ket_jadwal + '" class="btn fit-bg-color-primary m-1 btnDetail borderGreen" data-toggle="modal" data-target="#modalDetail">Detail</button>'
                                } else {
                                    return '<button type="button" id="btnDetail' + i + '|' + data.ket_jadwal + '" class="btn fit-bg-color-primary m-1 btnDetail" data-toggle="modal" data-target="#modalDetail">Detail</button>'
                                }
                            }
                                
                        }
                    },
                    {
                        "data": null, "width" : "70px", 
                        "render": function (data, type, row) {
                            var dk = data.kode_kelas;
                            var lastChar = dk.charAt(dk.length - 1);
                            if (lastChar == 'A' || lastChar == 'B' || lastChar == 'C' || dosen == '-') {
                            return '<button type="button" id="btnSem' + data.concat_kode_jam + '" class="btn fit-bg-color-primary  m-1 open-modal btnSementara btnHide" data-toggle="modal" data-target="#modalRekomendasi">Pindah</button><input type="hidden" class="' + data.flag + '"><input type="hidden" class="' + data.ket_tanggal_merah + '">'
                            } else {
                                return '<button type="button" id="btnSem' + data.concat_kode_jam + '" class="btn fit-bg-color-primary  m-1 open-modal btnSementara" data-toggle="modal" data-target="#modalRekomendasi">Pindah</button><input type="hidden" class="' + data.flag + '"><input type="hidden" class="' + data.ket_tanggal_merah + '">'
                            }
                        }
                    }
                ],
                });
                // hide row pindah jika login sebagai admin
                if (userRole == 1 || userRole == 2) {
                    $('.rowPindah').hide();
                }
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

    // Loading Proses
    function loadingProses() {
        $('#content').css("display", "none");
        $('#loading').css("display", "block");
    }
    function loadingSelesai() {
        $('#loading').css("display", "none");
        $('#content').css("display", "block");
    }


    // START EXPORT, IMPORT, DELETE
    $('#closeAlert').on('click', function() {
        $('#alertFlash').hide();
    });

    $('#inputFile').change(function() {
        // File input has changed
        var fileName = $(this).val().split('\\').pop(); // Get the filename
        $('#labelInputFile').text(fileName);
    });

    $('#btnImportJadwal').on('click', function(event) {
        event.preventDefault();
        var inputFile = $('#inputFile')[0];
        if (inputFile.files.length === 0) {
            alertify.alert("Pemberitahuan","File jadwal kosong! <br>Mohon uhnggah jadwal dalam bentuk file Excel.", function(){
            });
        } else {
            $('#formImportExoport').submit();
        }
    });

    // DELETE FORM
    $('#btnHapusSemuaJadwal').on('click', function(event) {
        event.preventDefault();
        var angkaPertama = Math.floor(Math.random() * 11);
        var angkaKedua = Math.floor(Math.random() * 11);
        var total = angkaPertama + angkaKedua;
        
        alertify.prompt( 'Hapus Semua Jadwal?', 'Hitung penjumlahan dari ' + angkaPertama + ' + ' + angkaKedua + ' = ' , ''
        , function(evt, value) { 
            if (value == total) {
                alertify.success('Semua Jadwal Berhasil Dihapus');
                // location.reload();
                // window.location.href = $(this).attr('href');
                var url = $('#btnHapusSemuaJadwal').attr('href');
                window.location.href = url;
                } else {
                    alertify.error('Penjumlahan Anda Salah');
                }
            }
            , function() { alertify.error('Batal Menghapus Jadwal') 
        });
    });
    // END EXPORT, IMPORT, DELETE

});
</script>
@endsection