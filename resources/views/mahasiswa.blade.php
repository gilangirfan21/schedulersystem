@extends('layouts.mhs')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">{{ __('Dashboard') }}</h1> --}}
                    <h1 class="ml-2">JADWAL PERKULIAHAN</h1>
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
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table w100p">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Hari</th>
                                                        <th>Tanggal</th>
                                                        <th>Mata Kuliah</th>
                                                        <th>Waktu</th>
                                                        <th>Kode Ruangan</th>
                                                        <th>Kode Kelas</th>
                                                        <th>Kode Dosen</th>
                                                        <th>Dosen</th>
                                                        <th>Detail</th>
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
                    <span class="close btnModalClose">&times;</span>
                    <!-- Modal content -->
                    <h2 class="text-center mb-2">Detail Jadwal</h2>
                    <div id="perubahanFalse" class="text-center">
                        <ul>
                            <li class="list-decorate-none">Tidak ada keterangan tambahan.</li>
                        </ul>
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
            {{-- End Modal --}}
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    function load() {
        jadwal();   
    }

    load();

    $(document).on('click', '.open-modal', function() {
    // Code to display the modal here
            
        // Load sugest Jadwal
        // loadDetail();

        // get detail row
        let rowData = this.parentElement.parentElement.childNodes;
        let kodeKelas = rowData[6].textContent;
        let kodeDosen = rowData[7].textContent;
        let namaDosen = rowData[8].textContent;

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



    function jadwal() {
        $.ajax({
            type: 'POST',
            url: '/api/jadwal',
            // dataType: "json",
            beforeSend: function() {
                // setting a timeout
                console.log("beforeSend");
            },
            success: function(data) {
            console.log(data);
            var i = 1;
                $('#dataTable').DataTable({
                    "data": data.jadwal,
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
                        "data": "kode_dosen"
                    },
                    {
                        "data": "dosen"
                    },
                    {
                        "data": "ket_jadwal", "width" : "50px", 
                        "render": function (data) {
                            return '<button type="button" id="btnDetail' + i + '|' + data + '" class="btn btn-primary m-1 open-modal btnDetail" data-toggle="modal">Detail</button>'
                        }
                    }
                ]
                });
            }
        });
    }


});
</script>
@endsection