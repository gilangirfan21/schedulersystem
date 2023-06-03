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
                                <form class="ml-1">
                                    <div class="form-group">
                                        <div class="row">
                                            {{-- <div class="col-lg-1"></div> --}}
                                            <div class="col-lg-1">
                                                <h5>Kode Dosen</h5>
                                            </div>
                                            <div class="col-lg-5">
                                                <h5>: {{ $dosen[0]->kode }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            {{-- <div class="col-lg-1"></div> --}}
                                            <div class="col-lg-1">
                                                <h5>Nama</h5>
                                            </div>
                                            <div class="col-lg-5">
                                                <h5>: {{ $dosen[0]->dosen }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                                <div class="row justify-content-end mt-3">
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
                                </div>
                                
                                <div class="table-responsive">
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
                                            
                                            @php $no=$jadwal->firstItem() @endphp

                                            @foreach($jadwal as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->tb_hari->hari }}</td>
                                                    <td>{{ $item->tanggal }}</td>
                                                    <td>{{ $item->tb_matkul->matkul }}</td>
                                                    <td>{{ $item->kode_jam }}</td>
                                                    <td></td>
                                                    <td>{{ $item->kode_ruangan }}</td>
                                                    <td>{{ $item->kode_kelas }}</td>
                                                    <td>{{ $item->kode_dosen }}</td>
                                                    <td>{{ $item->tb_dosen->dosen }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Sementara</button>
                                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Rekomendasi Jadwal</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <ul>
                                                                        <li>1</li>
                                                                        <li>2</li>
                                                                        <li>3</li>
                                                                        <li>4</li>
                                                                    </ul>
                                                                  </div>
                                                                  {{-- <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                  </div> --}}
                                                            </div>
                                                        </div>
                                                        </div>
                                                        {{-- <form method="POST" action="/check">
                                                            <input type="hidden" value="{{ $item->id }}">
                                                            <button type="submit" class="btn btn-warning">Permanen</button>
                                                            
                                                        </form> --}}
                                                        <form action="{{ route('check') }}">
                                                            <input class="btn btn-secondary" type="hidden" value="12" />
                                                            <button class="btn btn-secondary" type="submit" value="12">Permanen</button>
                                                        </form>
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