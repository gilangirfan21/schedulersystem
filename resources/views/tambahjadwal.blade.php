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
                                    <h1 class="mb-3">Export / Import Jadwal ke Database</h1>
                                    <a id="exportJadwal" class="btn btn-success" href="#">Export File</a>
                                    <a id="importJadwal" class="btn btn-primary" href="#">Import File</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered table-full-width">
                                            <thead class="">
                                                <th>No</th>
                                                <th>Kode Kelas</th>
                                                <th>Hari</th>
                                                <th>Tanggal</th>
                                                <th>Kode Mata Kuliah</th>
                                                <th>Pertemuan</th>
                                                <th>Kode Ruangan</th>
                                                <th>Kode Jam</th>
                                                <th>Kode Dosen</th>
                                            </thead>
                                            <tbody>
                                                @php $no = 0; @endphp
                                                @foreach($jadwal as $jad)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $jad->kode_kelas }}</td>
                                                    <td>{{ $jad->hari }}</td>
                                                    <td>{{ $jad->tanggal }}</td>
                                                    <td>{{ $jad->kode_matkul }}</td>
                                                    <td>{{ $jad->pertemuan }}</td>
                                                    <td>{{ $jad->kode_ruangan }}</td>
                                                    <td>{{ $jad->kode_jam }}</td>
                                                    <td>{{ $jad->kode_dosen }}</td>
                                                </tr>
                                                @php $no++; @endphp
                                                @endforeach
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
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection