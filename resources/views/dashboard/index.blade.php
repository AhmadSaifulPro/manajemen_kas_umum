@extends('layout.main')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h5 class="op-7 mb-2">Manajemen Keuangan Kas</h5>
            </div>
        </div>
        <div class="row">
            <livewire:dashboard-cards />
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Riwayat Pemasukan & Pengeluaran</div>
                            <div class="card-tools">
                                <div class="card-tools">
                                    <a href="{{ route('riwayat.kas') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                        Lihat Semua
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Nominal</th>
                                        <th>Keterangan</th>
                                        <th>Kategori</th>
                                        <th>Pencatat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($riwayatKas as $index => $kas)
                                        <tr>
                                            <th>{{ $index + 1 }}</th>
                                            {{-- <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('M d, Y, g.i a') }}</td> --}}
                                            <td>{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d F Y, H:i A') }}</td>
                                            <td>
                                                @if ($kas->jenis === 'Pemasukan')
                                                    <span class="badge badge-success">Pemasukan</span>
                                                @else
                                                    <span class="badge badge-danger">Pengeluaran</span>
                                                @endif
                                            </td>
                                            <td>Rp {{ number_format($kas->nominal, 0, ',', '.') }}</td>
                                            <td>{{ $kas->keterangan }}</td>
                                            <td>{{ optional($kas->Kategori)->nama_kategori }}</td>
                                            <td>{{ Auth::user()->name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada data kas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
