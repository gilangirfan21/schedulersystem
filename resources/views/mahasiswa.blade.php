@extends('layouts.mhs')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">{{ __('Dashboard') }}</h1> --}}
                    <h1 class="ml-2 fit-fs-26px">Jadwal Perkuliahan</h1>
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
                            <p class="card-text">
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table w100p">
                                                <thead class="fit-bg-color-primary fit-text-color-2">
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
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            {{-- Modal --}}
            <div id="myModal" class="modal" tabindex='-1'>
                <div class="modal-content">
                    <!--<span class="close btnModalClose">&times;</span>-->
                    <!-- Modal content -->
                    <h2 class="text-center mb-3 mt-4">Detail Jadwal</h2>
                    <div id="perubahanFalse" class="text-center">
                        <ul>
                            <li class="list-decorate-none">Tidak ada keterangan tambahan.</li>
                        </ul>
                    </div>
                    <div id="perubahanTrue" >
                        <h5 class="text-center">Telah Melakukan Perubahan</h5>
                        <h5 id="pertemuan" class="text-center">Pertemuan : </h5>
                        <ul class="font-weight-bold">
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-3">
                                    <li id="kdKelas" class="list-decorate-none">Kelas      : </li>
                                    <li id="nmDosen" class="list-decorate-none">Dosen      : </li>
                                    <li id="matkul" class="list-decorate-none">Mata Kuliah : </li>
                                </div>
                                <div class="col-sm-3">
                                    <li id="tglAwal" class="list-decorate-none">Tanggal Awal : </li>
                                    <li id="wktAwal" class="list-decorate-none">Waktu Awal   : </li>
                                    <li id="rgAwal" class="list-decorate-none">Ruang Awal    : </li>
                                </div>
                                <div class="col-sm-3">
                                    <li id="tglBaru" class="list-decorate-none">Tanggal Baru : </li>
                                    <li id="wktBaru" class="list-decorate-none">Waktu Baru   : </li>
                                    <li id="rgBaru" class="list-decorate-none">Ruang Baru    : </li>
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
            {{-- End Modal --}}
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    function load() {
        loadJadwal();
    }

    load();


    $(document).on('click', '.open-modal', function() {
        // get detail row
        let rowData = this.parentElement.parentElement.childNodes;
        let pertemuan = rowData[8].textContent;
        let kodeKelas = rowData[3].textContent;
        let namaDosen = rowData[7].textContent;
        let matkul = rowData[6].textContent; 
        let newTanggal = rowData[2].textContent; 
        let newWaktu = rowData[4].textContent; 
        let newRuangan = rowData[5].textContent; 

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
        

        
        // let modalTarget = 
        $('#myModal').show();
        // Update modal content dynamically if needed
        });

        $(document).keydown(function(e) {
            // Check if the escape key was pressed (key code 27)
            if (e.which === 27) {
                $('#myModal').hide();
            }
        });

        // Close button click event handler
        $('.btnModalClose').click(function() {
            $('#myModal').hide();
        });



    function loadJadwal() {
        $.ajax({
            type: 'POST',
            url: 'api/jadwal',
            // dataType: "json",
            beforeSend: function() {
                loadingProses();
                console.log("beforeSend");
            },
            success: function(data) {
                loadingSelesai();
            console.log(data);
            var i = 1;
                $('#dataTable').DataTable({
                    "data": data.jadwal,
                    columnDefs: [
                      { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 8, 9] },
                      { className: 'text-left', targets: [6, 7] },
                      { width: '300px', targets: [6] },
                      { width: '200px', targets: [7] },
                    ],
                                // "responsive": true,
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
                        "data": "ket_jadwal", "width" : "50px", 
                        "render": function (data) {
                            if (data != null) {
                            return '<button type="button" id="btnDetail' + i + '|' + data + '" class="btn fit-bg-color-primary fit-text-color-2 m-1 open-modal btnDetail borderGreen" data-toggle="modal">Detail</button>'
                            } else {
                                return '<button type="button" id="btnDetail' + i + '|' + data + '" class="btn fit-bg-color-primary fit-text-color-2 m-1 open-modal btnDetail" data-toggle="modal">Detail</button>'
                            }
                        }
                    }
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