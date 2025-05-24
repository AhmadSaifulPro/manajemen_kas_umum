@extends('layout.main')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">DataTable Laporan Keuangan</h3>
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
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Laporan Keuangan Kas</h4>
                                {{-- <a href="" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Kategori</a> --}}
                            </div>
                            <form id="laporan-form" method="GET">
                                <div class="row g-3 align-items-end mb-4">
                                    <div class="col-md-2">
                                        <label for="jenis" class="form-label">Jenis</label>
                                        <select name="jenis" id="jenis" class="form-select">
                                            <option value="">-- Semua Jenis --</option>
                                            <option value="Pemasukan"
                                                {{ request('jenis') == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                            <option value="Pengeluaran"
                                                {{ request('jenis') == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tanggal_dari" class="form-label">Dari Tanggal</label>
                                        <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control"
                                            value="{{ request('tanggal_dari') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                                        <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control"
                                            value="{{ request('tanggal_sampai') }}">
                                    </div>
                                    <div class="col-md-4 d-flex gap-2">
                                        <button type="submit" formaction="{{ route('laporan.index') }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>

                                        <button type="button" onclick="submitForm('{{ route('export.pdf') }}')"
                                            class="btn btn-danger">
                                            <i class="fas fa-file-pdf"></i> Export PDF
                                        </button>

                                        <button type="button" onclick="submitForm('{{ route('export.excel') }}')"
                                            class="btn btn-success">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="laporanTable" class="table table-striped table-hover mt-4">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis</th>
                                            <th>Tanggal</th>
                                            <th>Nominal</th>
                                            <th>Keterangan</th>
                                            <th>Nama Kategori</th>
                                            {{-- <th style="width: 10%">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($laporan_kas as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td
                                                    class="{{ $item->jenis === 'Pemasukan' ? 'text-success' : ($item->jenis === 'Pengeluaran' ? 'text-danger' : '') }}">
                                                    {{ $item->jenis ?? '-' }}
                                                </td>
                                                {{-- <td>{{ $item->tanggal }}</td> --}}
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}</td>
                                                {{-- <td>{{ $item->jumlah }}</td> --}}
                                                <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                {{-- <td>{{ $item->Kategori->nama }}</td> --}}
                                                <td>{{ optional($item->Kategori)->nama_kategori }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- {{ $aktif->count() }} data ditampilkan dari total {{ $aktif->total() }} --}}
                                {{-- {{ $laporan_kas->links('pagination::bootstrap-5') }} --}}
                                {{-- {{ $aktif->links() }} --}}
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
                $('#laporanTable').DataTable({
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
