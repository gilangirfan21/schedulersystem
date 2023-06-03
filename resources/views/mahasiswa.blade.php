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
                                        <form action="{{ route('mahasiswa.search') }}" method="GET">
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
                                                        <th>Detail</th>
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
                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg{{ $item->id }}">Detail </button>
                                                                <div class="modal fade bd-example-modal-lg{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Detail Jadwal</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                              <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                          </div>
                                                                          <div class="modal-body">
                                                                            {{-- @dd($item->keterangan) --}}
                                                                            @if($item->keterangan !== NULL && $item->keterangan !== '')
                                                                            <?php $ket = explode(";",$item->keterangan) ?>
                                                                            <ul>
                                                                                <li class="list-decorate-none">Kode Kelas : {{ $item->kode_kelas }}</li>
                                                                                <li class="list-decorate-none">Kode Dosen : {{ $item->kode_dosen }}</li>
                                                                                <li class="list-decorate-none">Nama Dosen : {{ $item->tb_dosen->dosen }}</li>
                                                                                <li class="list-decorate-none color-salmon">Tanggal Awal : {{ $ket[0] }}</li>
                                                                                <li class="list-decorate-none color-salmon">Waktu Awal : {{ $ket[1] }}</li>
                                                                                <li class="list-decorate-none color-salmon">Ruang Awal : {{ $ket[2] }}</li>
                                                                            </ul>
                                                                            @else
                                                                            <ul>
                                                                                <li style="list-decorate-none; ">Tidak ada keterangan tambahan.</li>
                                                                            </ul>
                                                                            @endif
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
                                                                {{-- <form action="{{ route('check') }}">
                                                                    <input class="btn btn-secondary" type="hidden" name="id" value="12" />
                                                                    <button class="btn btn-secondary" type="submit">Premanen</button>
                                                                </form> --}}
                                                            </td>
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