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
                                {{-- {{ __('You are logged in!') }} --}}
                                <form>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <h5>Kode Dosen</h5>
                                            </div>
                                            <div class="col-lg-1">
                                                <h5>:</h5>
                                            </div>
                                            <div class="col-lg-5">
                                                <h5>{{ $jadwal[0]->kode_dosen }}</h5>
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
                                                <h5>{{ $jadwal[0]->tb_dosen->dosen }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table">
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
                                                <th>Pindah Jadwal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($no=$jadwal->firstItem())

                                            @foreach($jadwal as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->tb_hari->hari }}</td>
                                                    <td>{{ $item->tanggal }}</td>
                                                    <td>{{ $item->tb_matkul->matkul }}</td>
                                                    <td>{{ $item->kode_jam }}</td>
                                                    <td>{{ $item->kode_ruangan }}</td>
                                                    <td>{{ $item->kode_kelas }}</td>
                                                    <td>{{ $item->kode_dosen }}</td>
                                                    <td>{{ $item->tb_dosen->dosen }}</td>
                                                    <td>
                                                        <button class="btn btn-primary">Sementara</button>
                                                        <button class="btn btn-warning">Permanen</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            {{-- @dd($jadwal); --}}
                                        </tbody>
                                    </table>
                                    @if(count($jadwal) > 0)
                                    <div>
                                        <div class="float-left">
                                            Showing {{ $jadwal->firstItem() }} to {{ $jadwal->lastItem() }} of {{ $jadwal->total() }} enteries
                                        </div>
                                        <div class="float-right">
                                            {{ $jadwal->links() }}
                                        </div> 
                                    </div>
                                    @else
                                        <h5 class="text-center">Data Not Found</h5>
                                    @endif
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