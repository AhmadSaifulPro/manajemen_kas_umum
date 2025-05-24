@extends('layout.main')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">DataTable Catatan Keuangan</h3>
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
                        <a href="{{ route('kas.index') }}">Datatables</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Manajemen Keungan Kas</h4>
                                <a href="{{ route('kas.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Catatan Kas</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Set a min-width for the table container to prevent horizontal scrolling -->
                            <div class="table-responsive">
                                <table id="kasAktifTable" class="table table-striped table-hover"
                                    style="width: 100%; table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 13%;">Jenis</th>
                                            <th style="width: 16%;">tanggal</th>
                                            <th style="width: 12%;">Nominal</th>
                                            <th style="width: 15%;">Keterangan</th>
                                            <th style="width: 14%;">Nama Kategori</th>
                                            <th style="width: 10%; white-space: nowrap;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aktif as $item)
                                            <tr>
                                                {{-- 7 kolom wajib --}}
                                                <td>{{ isset($loop) ? $loop->iteration : '-' }}</td>
                                                <td class="{{ $item->jenis === 'Pemasukan' ? 'text-success' : ($item->jenis === 'Pengeluaran' ? 'text-danger' : '') }}"
                                                    style="white-space: nowrap;">
                                                    {{ $item->jenis ?? '-' }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') ?? '-' }}</td>
                                                <td>Rp {{ number_format($item->nominal ?? 0, 0, ',', '.') }}</td>
                                                <td>{{ $item->keterangan ?? '-' }}</td>
                                                <td>{{ optional($item->Kategori)->nama_kategori ?? '-' }}</td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex gap-1">
                                                        {{-- Tombol Edit --}}
                                                        <a href="{{ route('kas.edit', $item->id_kas) }}"
                                                            class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                            title="Edit Data">
                                                            {{-- <i class="fa fa-edit"></i> --}}
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>

                                                        {{-- Tombol Hapus --}}
                                                        <form id="form-hapus-{{ $item->id_kas }}"
                                                            action="{{ route('kas.destroy', $item->id_kas) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger btn-konfirmasi"
                                                                data-id="{{ $item->id_kas }}" title="Hapus Data">
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
        </div>
    </div>

    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h3>Data Kategori Terhapus</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kasTerhapusTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis</th>
                                            <th>Tanggal</th>
                                            <th>Nominal</th>
                                            <th>Keterangan</th>
                                            <th>Nama Kategori</th>
                                            <th style="white-space: nowrap;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($terhapus as $item)
                                            <tr>
                                                <td>{{ isset($loop) ? $loop->iteration : '-' }}</td> {{-- <td>{{ $loop->iteration ?? '-' }}</td> --}}
                                                <td
                                                    class="{{ $item->jenis === 'Pemasukan' ? 'text-success' : ($item->jenis === 'Pengeluaran' ? 'text-danger' : '') }}">
                                                    {{ $item->jenis ?? '-' }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') ?? '-' }}
                                                </td>
                                                <td>Rp {{ number_format($item->nominal, 0, ',', '.') ?? '-' }}</td>
                                                <td>{{ $item->keterangan ?? '-' }}</td>
                                                <td>{{ optional($item->Kategori)->nama_kategori ?? '-' }}</td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex gap-1">
                                                        <form action="{{ route('kas.restore', $item->id_kas) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Pulihkan data ini?')">
                                                            @csrf
                                                            <button class="btn btn-success btn-sm">Pulihkan</button>
                                                        </form>
                                                        <form id="form-hapus-{{ $item->id_kas }}"
                                                            action={{ route('kas.forceDelete', $item->id_kas) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus permanen data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                title="Hapus Permanen">
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                // console.log('jQuery version:', $.fn.jquery); // debug
                $('[data-bs-toggle="tooltip"]').tooltip();
                $('#kasAktifTable').DataTable({
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
                $('#kasTerhapusTable').DataTable({
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
