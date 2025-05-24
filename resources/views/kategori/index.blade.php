@extends('layout.main')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">DataTable Kategori</h3>
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
                        <a href="{{ route('kategori.index') }}">Datatables</a>
                    </li>
                </ul>
            </div>

            <!-- Kategori Aktif -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title">Manajemen Kategori</h4>
                            <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Kategori
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="overflow-x: visible;">
                                <table id="kategoriAktif" class="table table-striped table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Jenis</th>
                                            <th>Deskripsi</th>
                                            <th style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aktif as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama_kategori }}</td>
                                                <td
                                                    class="{{ $item->jenis === 'Pemasukan' ? 'text-success' : 'text-danger' }}">
                                                    {{ $item->jenis }}
                                                </td>
                                                <td>{{ $item->deskripsi }}</td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex gap-1">
                                                        {{-- Tombol Edit --}}
                                                        <a href="{{ route('kategori.edit', $item->id_kategori) }}"
                                                            class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                            title="Edit Data">
                                                            {{-- <i class="fa fa-edit"></i> --}}
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        {{-- Tombol Hapus --}}
                                                        <form id="form-hapus-{{ $item->id_kategori }}"
                                                            action="{{ route('kategori.destroy', $item->id_kategori) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger btn-konfirmasi"
                                                                data-id="{{ $item->id_kategori }}" title="Hapus Data">
                                                                {{-- <i class="fa fa-trash"></i> --}}
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

            <!-- Kategori Terhapus -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3>Data Kategori Terhapus</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="overflow-x: visible;">
                                <table id="kategoriTerhapus" class="table table-striped table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Jenis</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($terhapus as $kategori)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $kategori->nama_kategori }}</td>
                                                <td
                                                    class="{{ $kategori->jenis === 'Pemasukan' ? 'text-success' : 'text-danger' }}">
                                                    {{ $kategori->jenis }}
                                                </td>
                                                <td>{{ $kategori->deskripsi }}</td>
                                                <td class="d-flex gap-2">
                                                    <form action="{{ route('kategori.restore', $kategori->id_kategori) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Pulihkan data ini?')">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm">Pulihkan</button>
                                                    </form>
                                                    <form id="form-hapus-{{ $kategori->id_kategori }}"
                                                        action={{ route('kategori.forceDelete', $kategori->id_kategori) }}"
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
                $('[data-bs-toggle="tooltip"]').tooltip();
                $('#kategoriAktif').DataTable({
                    retrieve: true,
                    destroy: true,
                    responsive: false,
                    paging: true,
                    scrollX: false,
                    autoWidth: false,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                        infoEmpty: "Tidak ada data tersedia",
                        infoFiltered: "(difilter dari total _MAX_ data)"
                    }
                });

                $('#kategoriTerhapus').DataTable({
                    retrieve: true,
                    destroy: true,
                    responsive: false,
                    paging: true,
                    scrollX: false,
                    autoWidth: false,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                        infoEmpty: "Tidak ada data tersedia",
                        infoFiltered: "(difilter dari total _MAX_ data)"
                    }
                });

                // Konfirmasi hapus
                $('.btn-konfirmasi').click(function() {
                    let id = $(this).data('id');
                    Swal.fire({
                        title: 'Yakin hapus data ini?',
                        text: "Data akan dipindahkan ke arsip.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form-hapus-' + id).submit();
                        }
                    });
                });
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
