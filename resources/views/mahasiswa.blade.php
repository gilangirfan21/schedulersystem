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
                                <div class="row justify-content-end">
                                    <div class="col-lg-3">
                                        <form action="{{ route('mahasiswa') }}" method="GET">
                                            <div class="input-group mb-3">
                                                <label class="form-label" for="search"></label>
                                                <input type="search" name="search" id="search" class="form-control"  placeholder="Kelas / Dosen / Mata Kuliah" aria-label="Kelas / Dosen / Mata Kuliah" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                  <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
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
                                                        </tr>
                                                    @endforeach
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
                                    </div>
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