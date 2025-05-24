@extends('layout.main')

@section('content')
<div class="page-inner">
    <div class="page-header position-relative d-flex align-items-center" style="min-height: 50px;">
    <a href="{{ route('dashboard.index') }}" class="btn btn-sm btn-secondary">← Kembali</a>
    <h4 class="page-title position-absolute top-50 start-50 translate-middle">Riwayat Kas Lengkap</h4>
</div>


    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-body table-responsive">
                    <table class="table table-hover">
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
                                    <td>{{ $riwayatKas->firstItem() + $index }}</td>
                                    {{-- <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d M Y, H:i') }}</td> --}}
                                    <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('M d, Y, g.i a') }}</td>
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
                    <div class="mt-3">
                        {{ $riwayatKas->links() }} {{-- pagination --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
