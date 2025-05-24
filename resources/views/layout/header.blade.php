<div class="container-fluid">
    <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
        {{-- <div class="input-group">
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-search pe-1">
                    <i class="fa fa-search search-icon"></i>
                </button>
            </div>
            <input type="text" placeholder="Search ..." class="form-control" />
        </div> --}}
    </nav>

    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        <li class="nav-item topbar-user dropdown hidden-caret">
            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                <div class="avatar-sm">
                    <img src="{{ asset('/') }}template/logo.png" alt="..." width="10"
                        class="avatar-img rounded-circle" />
                </div>
                <span class="profile-username">
                    <span class="op-7">Hi,</span>
                    <span class="fw-bold">{{ Auth::user()->name }}</span>
                </span>
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
                <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                        <div class="user-box">
                            <div class="avatar-lg">
                                <img src="{{ asset('/') }}template/logo.png" alt="image profile"
                                    class="avatar-img rounded" />
                            </div>
                            <div class="u-text">
                                <h4>{{ Auth::user()->name }}</h4>
                                <p class="text-muted">{{ Auth::user()->email }}</p>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-secondary btn-sm">Logout</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </div>
            </ul>
        </li>
    </ul>
</div>
