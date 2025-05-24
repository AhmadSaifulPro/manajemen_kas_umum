@include('layout.head')

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('layout.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ asset('/') }}template/index.html" class="logo">
                            <img src="{{ asset('/') }}template/assets/img/kaiadmin/logo_light.svg" alt="navbar brand"
                                class="navbar-brand" height="20" />
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
                </div>

                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    @include('layout.header')
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                @yield('content')
                @livewireScripts
            </div>

            <footer class="footer">
                @include('layout.footer')
            </footer>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
            @include('layout.template')
        </div>
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    @include('layout.script')

    @stack('scripts')
</body>

</html>
