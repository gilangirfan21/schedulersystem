<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link fit-text-color-2">
                    <i class="nav-icon fa fa-calendar fit-text-color-2 fit-fs-16px" aria-hidden="true"></i>
                    <p>
                        Jadwal
                    </p>
                </a>
            </li>
            <li class="nav-item">
                
                <a href="{{ route('riwayatperubahanjadwal') }}" class="nav-link fit-text-color-2">
                    <i class="nav-icon fa fa-history fit-text-color-2 fit-fs-16px"></i>
                    <p>
                        Riwayat Jadwal
                    </p>
                </a>
            </li>
            <li class="nav-item">
                
                <a href="{{ route('jadwaltanggalmerah') }}" class="nav-link fit-text-color-2">
                    <i class="nav-icon fa fa-bell fit-text-color-2 fit-fs-16px"></i>
                    <p>
                        Jadwal Tanggal Merah
                    </p>
                </a>
            </li>

            @if( in_array(Auth::user()->role, [1,2]))
            <li class="nav-item">
                
                <a href="{{ route('tanggalmerah') }}" class="nav-link fit-text-color-2">
                    <i class="nav-icon fa fa-window-close fit-text-color-2 fit-fs-16px"></i>
                    <p>
                        Tanggal Merah
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('daftar') }}" class="nav-link fit-text-color-2">
                    <i class="nav-icon fa fa-user-plus fit-text-color-2 fit-fs-16px" aria-hidden="true"></i>
                    <p>
                        Daftar
                    </p>
                </a>
            </li>
            <li class="nav-item">
                
                <a href="{{ route('users.index') }}" class="nav-link fit-text-color-2">
                    <i class="nav-icon fas fa-users fit-text-color-2 fit-fs-16px"></i>
                    <p>
                        Users
                    </p>
                </a>
            </li>
            @endif

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->