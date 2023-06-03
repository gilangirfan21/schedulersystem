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

            <div id="content" class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">
                                @if( Auth::user()->role == 3)
                                <form action="{{ route('check') }}">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <h5>Kode Dosen</h5>
                                            </div>
                                            <div class="col-lg-1">
                                                <h5>:</h5>
                                            </div>
                                            <div class="col-lg-5">
                                                {{-- <h5>{{ $dosen[0]->kode }}</h5> --}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <h5>Nama</h5>
                                            </div>
                                            <div class="col-lg-1">
                                                <h5>:</h5>
                                            </div>
                                            <div class="col-lg-5">
                                                {{-- <h5>{{ $dosen[0]->dosen }}</h5> --}}
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                                <div class="row justify-content-md-center">
                                    <div class="col-lg-6">
                                        <form id="formFilter">
                                            <div class="input-group row mb-2">
                                                <label for="selGedung" class="col-sm-2 col-form-label">Gedung</label>
                                                <select name="selGedung" id="selGedung" class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="-">Pilih Semua</option>
                                                </select>
                                            </div>
                                            <div class="input-group row mb-2">
                                                <label for="selLantai" class="col-sm-2 col-form-label">Lantai</label>
                                                <select name="selLantai" class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="-">Pilih Semua</option>
                                                  </select>
                                            </div>
                                            <div class="input-group row mb-2">
                                                <label for="" class="col-sm-2 col-form-label">Tanggal</label>
                                                <input type="date" data-date="" data-date-format="DD MMMM YYYY" value="2023-01-01" name="selDateStart" id="selDateStart" data-provide="datepicker" class="col-sm-5 datepicker form-control">
                                                <label for="" class="col-sm-1 col-form-label text-center">sd</label>
                                                <input type="date" data-date="" data-date-format="DD MMMM YYYY" value="2023-01-01" name="selDateEnd" id="selDateEnd" data-provide="datepicker" class="col-sm-5 datepicker form-control">
                                            </div>
                                            
                                            <div class="input-group row mb-2">
                                                <label class="col-sm-2 col-form-label">Waktu</label> 
                                                <select name="selTimeStart"  class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="-">Pilih Semua</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                                <label class="col-sm-1 col-form-label text-center">sd</label>
                                                <select name="selTimeEnd"  class="custom-select select2" aria-label="Default select example">
                                                    <option selected value="-">Pilih Semua</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                                  
                                            </div>
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
                                
                                <div class="table-responsive mt-5">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Hari</th>
                                                <th>Tanggal</th>
                                                <th>Mata Kuliah</th>
                                                <th>Waktu</th>
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
                            </p>
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
<script type="module">
$( document ).ready(function() {
    console.log("test");
    $('#loading').hide();
    $('#content').show();

    $('.datepicker').datepicker();

    // GET DATA GEDUNG FROM API
    // $.ajax({
    //     url: 'api/gedung',
    //     method: 'GET',
    //     data: {
    //     },
    //     beforeSend: function () {
    //         $('#content').hide();
    //         $('#loading').show();
    //         console.log("before");
    //     },
    //     success: function(data) {
    //         console.log("after");
    //         var select = $('#selGedung');

    //         $.each(data.gedung, function(index, item) {
    //         console.log(item);
    //             var option = $('<option></option>');
    //             option.val(item.kodeGedung);
    //             option.text(item.kodeGedung);
    //             select.append(option);
    //         });
    //         $('#content').show();
    //         $('#loading').hide();
    //         // Handle the response data here
    //         console.log(data);
    //     },
    //     error: function(xhr, status, error) {
    //         // Handle the error here
    //         console.log(error);
    //     }
    // });

    $("#submitBtn").click(function(){        
        $("#formFilter").submit(); // Submit the form
    });

});

</script>
@endsection
