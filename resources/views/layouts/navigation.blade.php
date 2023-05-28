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
            {{-- <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li> --}}

            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        {{ __('Users') }}
                    </p>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a href="{{ route('about') }}" class="nav-link">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>
                        {{ __('About us') }}
                    </p>
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-circle nav-icon"></i>
                    <p>
                        Menu
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <p>
                            <i class="far fa-circle nav-icon"></i>
                            Jadwal
                        </p>
                        </a>
                    </li>
                </ul>
            </li> --}}

            {{-- START SIDE NAVBAR CUSTOM--}}
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fa fa-calendar" aria-hidden="true"></i>
                    <p>
                        JADWAL
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('daftar') }}" class="nav-link">
                    <i class="nav-icon fa fa-plus-square" aria-hidden="true"></i>
                    <p>
                        DAFTAR
                    </p>
                </a>
            </li>

            {{-- END SIDEBAR CUSTOM --}}
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->