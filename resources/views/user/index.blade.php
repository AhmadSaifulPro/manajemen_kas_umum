@extends('layout.main')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">DataTable Manajemen User</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.index') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}">Datatables</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <h4 class="card-title">Manajemen Users</h4>
                                <a class="btn btn-primary btn-round ms-auto" href="{{ route('user.create') }}">
                                    <i class="fa fa-plus"></i>
                                    User Admin
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="userAktifTable" class="table table-striped table-hover mt-5">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>email</th>
                                            <th>password</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->password }}</td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('user.edit', $item->id) }}"
                                                            class="btn btn-sm btn-warning" title="Edit Data">
                                                            {{-- <i class="fa fa-edit"></i> --}}
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form id="form-hapus-{{ $item->id }}"
                                                            action="{{ route('user.destroy', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger btn-konfirmasi"
                                                                data-id="{{ $item->id }}" title="Hapus Data">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
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

    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h3>Data User Terhapus</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="userTerhapusTable" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($terhapus as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->password }}</td>
                                                <td class="d-flex gap-2">
                                                    <form action="{{ route('users.restore', $user->id) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Pulihkan data ini?')">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm">Pulihkan</button>
                                                    </form>
                                                    <form id="form-hapus-{{ $user->id }}"
                                                            action={{ route('user.forceDelete', $user->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus permanen data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                title="Hapus Permanen">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                </td>
                                            </tr>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                // console.log('jQuery version:', $.fn.jquery); // debug
                $('[data-bs-toggle="tooltip"]').tooltip();
                $('#userAktifTable').DataTable({
                    retrieve: true,
                    destroy: true,
                    responsive: false,
                    paging: true,
                    scrollX: false,
                    autoWidth: false,
                    language: {
                        emptyTable: "Tidak ada data yang tersedia", // ini tampil otomatis
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                        infoEmpty: "Tidak ada data tersedia",
                        infoFiltered: "(difilter dari total _MAX_ data)"
                    }
                });
                columnDefs: [{
                        targets: 0,
                        width: "5%"
                    },
                    {
                        targets: 6,
                        orderable: false,
                        searchable: false
                    }
                ]
                $('#userTerhapusTable').DataTable({
                    retrieve: true,
                    destroy: true,
                    responsive: false,
                    paging: true,
                    scrollX: false,
                    autoWidth: false,
                    language: {
                        emptyTable: "Tidak ada data yang tersedia", // ini tampil otomatis
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                        infoEmpty: "Tidak ada data tersedia",
                        infoFiltered: "(difilter dari total _MAX_ data)"
                    }
                });
                columnDefs: [{
                        targets: 0,
                        width: "5%"
                    },
                    {
                        targets: 6,
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        </script>

        @if (session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: @json(session('success')),
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            </script>
        @endif
    @endpush
@endsection
