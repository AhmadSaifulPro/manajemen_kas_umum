<div class="sidebar" data-background-color="dark">
    {{-- <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header justify-center">
            <a href="{{ route('dashboard.index') }}" class="logo">
                <img src="{{ asset('/') }}template/logo.png" alt="navbar brand"
                    class="navbar-brand" height="55" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div> --}}
    {{-- <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header">
            <a href="{{ route('dashboard.index') }}" class="logo mb-2 mt-4 mx-4">
                <img src="{{ asset('/') }}template/logo.png" alt="navbar brand" class="navbar-brand" height="65" />
            </a>
            <h4 class="text-white font-bold mt-5 pr-4">KAS Umum</h4>
            <div class="nav-toggle absolute top-2 right-2">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more absolute top-2 right-10">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div> --}}
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header d-flex align-items-center">
            <a href="{{ route('dashboard.index') }}" class="logo">
                <img src="{{ asset('/') }}template/logo.png" alt="navbar brand" class="navbar-brand mt-3" height="56" />
            </a>
            <h4 class="text-white font-bold ml-2 mt-4 mb-0">KAS Umum</h4>
            <div class="nav-toggle absolute top-2 right-2">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more absolute top-2 right-10">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner mt-4">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    {{-- <a data-bs-toggle="collapse" href="{{ route('dashboard.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a> --}}
                    <a href="{{ route('dashboard.index') }}" class="collapsed">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">KELOLA KAS</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#forms">
                        <i class="fas fa-pen-square"></i>
                        <p>Manajemen Kas</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('kas.index') }}">
                                    <span class="sub-item">Catatan Keuangan</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kategori.index') }}">
                                    <span class="sub-item">Kategori</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}">
                        <i class="fas fa-table"></i>
                        <p>laporan Keunagan Kas</p>
                    </a>
                    <a href="{{ route('user.index') }}">
                        <i class="fas fa-user"></i>
                        <p>Manajemen User</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
