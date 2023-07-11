@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">{{ __('Dashboard') }}</h1> --}}
                    <h1 class="ml-2">Halaman Menu Jadwal</h1>
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
                            <div class="row">
                                <div class="col-sm 12 text-center mb-3">
                                    @if ($message = Session::get('success'))
                                    <div id="alertFlash" class="alert alert-success alert-block">
                                        <button id="closeAlert" type="button" class="close" data-dismiss="alert">×</button>	
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @endif
                                    <h1 class="mb-3">Export / Import Jadwal ke Database</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6 text-center">
                                    <!-- Import Excel -->
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
                                                            <div class="custom-file text-left w-50">
                                                                <input type="file" name="file" class="custom-file-input" id="inputFile">
                                                                <label class="custom-file-label" for="inputFile" id="labelInputFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button id="btnImportJadwal" class="btn btn-primary text-left">Import</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <a id="btnExportJadwal" class="btn btn-success text-right" href="{{ route('exportjadwal') }}">Export File Jadwal</a>
                                    {{-- <button id="btnImportJadwal" class="btn btn-primary text-left" data-toggle="modal" data-target="#modalImportExcel">Import File Jadwal</button> --}}
                                    <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#modalImportExcel">
                                        IMPORT EXCEL
                                    </button>                            
                                </div>
                                <div class="col-sm-3"></div>
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
<script>
$( document ).ready(function() {
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

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    });


});
</script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
@endsection