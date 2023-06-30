@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
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
                    <h2 class="text-center mb-2" id="titleModal"></h2>
                    <h6 class="text-center mb-2">Rekomendasi</h6>
                    <div class="containerCardRekomendasi">
                        <div class="cardRekomendasi">
                            Card 1
                            <ul>
                                <li>Hari : </li>
                                <li>Tanggal : </li> {{-- if sementara --}}
                                <li>Ruangan : </li>
                                <li></li>
                            </ul>
                        </div>
                        <div class="cardRekomendasi">Card 2</div>
                        <div class="cardRekomendasi">Card 3</div>
                        <div class="cardRekomendasi">Card 4</div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btnModalClose" data-dismiss="modal">Close</button>
                        <form action="{{ route('check') }}" method="GET">
                            <input type="hidden" name="type" id="type">
                            <input type="hidden" name="listId" id="listId">
                            <button type="submit" class="btn btn-success">Pilih Manual</button>
                        </form>
                        {{-- <a href="{{ route('check') }}" class="btn btn-success">Pilih Manual</a> --}}
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
    console.log(dosen);
    
    function load() {
        if (userRole != 1 && userRole != 2) {
            detailDosen(dosen); 
        }
        jadwal(dosen);
    }
    // load function and data
    load();

    $(document).on('click', '.open-modal', function() {
    // Code to display the modal here
        
        // Load sugest Jadwal
        // loadSuggest();

        var type = $(this).text();
        $('#type').val(type);
        console.log(type);
        var tmpId = $(this).attr('id');
        listId = tmpId.substring(6);
        listId = listId.replace(/-/g, '/');

        // var listId = $(this).closest('tr').find('td:nth-child(5)').text();
        $('#listId').val(listId);
        console.log(listId);
        // input data hidden
        // $('#type').val('sementara');
        // $('#count').val('3');
        // $('#listId').val('1-2-3');
        
        // Title Modal
        var elementText = $(this).text();
        $('#titleModal').html("Perubahan " + elementText );
        $('#myModal').show();
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


    function detailDosen(dosen) {
        var dataParam = { kodeDosen: dosen };
        var data = $.param(dataParam);
        console.log(data);
        $.ajax({
            type: 'POST',
            url: '/api/dosen',
            data: data,
            beforeSend: function() {
                console.log("beforeSend");
            },
            success: function(data) {
                console.log(data);
                $('#kodeDosen').html('Kode Dosen : ' + data.dosen.kode);
                $('#namaDosen').html('Nama Dosen : ' + data.dosen.dosen);
            }
        });
    }

    function jadwal(dosen) {
        var dataParam = { kode_dosen: dosen };
        var data = $.param(dataParam);
        $.ajax({
            type: 'POST',
            url: '/api/jadwal',
            // dataType: "json",
            data: data,
            beforeSend: function() {
                // setting a timeout
                console.log("beforeSend");
            },
            success: function(data) {
            // $('#dataTable').DataTable().destroy();
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

});
</script>
@endsection