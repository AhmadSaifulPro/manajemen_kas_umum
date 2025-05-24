@php
    function formatRupiah($number)
    {
        return 'Rp' . number_format($number ?? 0, 0, ',', '.');
    }

    $max = max(count($dataWithSaldo), count($pemasukanPerKategori), count($pengeluaranPerKategori));
@endphp

<table>
    <tr>
        <td colspan="7" align="center" style="font-weight: bold; font-size: 16px;">
            {{ $isFiltered ? 'LAPORAN KEUANGAN KAS BULAN' : 'LAPORAN KEUANGAN KAS' }}
        </td>
    </tr>
    <tr>
        <td colspan="7" align="center" style="font-weight: bold; font-size: 16px;">
            {{ $isFiltered ? \Carbon\Carbon::now()->translatedFormat('F Y') : 'KESELURUHAN' }}
        </td>
    </tr>
</table>


<table>
    <thead>
        <tr>
            <th align="center">NO</th>
            <th align="center">Tanggal</th>
            {{-- <th colspan="2">Jenis Transaksi</th> --}}
            <th align="center">Pemasukan</th>
            <th align="center">Pengeluaran</th>
            <th align="center">Keterangan</th>
            <th align="center">Kategori</th>
            <th align="center">Saldo Berjalan</th>
            <th></th>
            <th colspan="2" align="center">LAPORAN PEMASUKAN PER KATEGORI</th>
            <th></th>
            <th colspan="2" align="center">LAPORAN PENGELUARAN PER KATEGORI</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($dataWithSaldo as $item) --}}
        @for ($i = 0; $i < $max; $i++)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($dataWithSaldo[$i]->tanggal)->format('d/m/Y') }}</td>
                {{-- <td>{{ $dataWithSaldo[$i]->tanggal }}</td> --}}
                {{-- <td>{{ $dataWithSaldo[$i]->jenis == 'Pemasukan' ? number_format($dataWithSaldo[$i]->nominal)  }}</td> --}}
                <td>
                    @if ($dataWithSaldo[$i]->jenis == 'Pemasukan')
                        Rp{{ number_format($dataWithSaldo[$i]->nominal, 2, ',', '.') }}
                    @endif
                </td>
                <td>
                    @if ($dataWithSaldo[$i]->jenis == 'Pengeluaran')
                        Rp{{ number_format($dataWithSaldo[$i]->nominal, 2, ',', '.') }}
                    @endif
                </td>
                {{-- <td>{{ $dataWithSaldo[$i]->jenis == 'Pengeluaran' ? number_format($dataWithSaldo[$i]->nominal)  }}</td> --}}
                {{-- <td>{{ number_format($dataWithSaldo[$i]->nominal) }}</td> --}}
                <td>{{ $dataWithSaldo[$i]->keterangan }}</td>
                <td>{{ optional($dataWithSaldo[$i]->kategori)->nama_kategori }}</td>
                <td>{{ formatRupiah($dataWithSaldo[$i]->saldo) }}</td>

                {{-- Spacer --}}
                <td></td>

                {{-- Tabel Pemasukan per Kategori --}}
                <td>
                    {{ $pemasukanPerKategori[$i]['nama_kategori'] ?? '' }}
                </td>
                <td>
                    {{-- {{ isset($pemasukanPerKategori[$i]) ? 'Rp' . number_format($pemasukanPerKategori[$i]['total'], 2, ',', '.') : '' }} --}}
                    {{ isset($pemasukanPerKategori[$i]) ? formatRupiah($pemasukanPerKategori[$i]['total']) : '' }}
                </td>

                {{-- Spacer --}}
                <td></td>

                {{-- Pengeluaran Kategori --}}
                <td>
                    {{ $pengeluaranPerKategori[$i]['nama_kategori'] ?? '' }}</td>
                <td>
                    {{ isset($pengeluaranPerKategori[$i]) ? formatRupiah($pengeluaranPerKategori[$i]['total']) : '' }}
                </td>
            </tr>
        @endfor
        {{-- @endforeach --}}
    </tbody>
</table>

{{-- Spacer between tables --}}
<table>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>

<br>

<!-- TABEL KEDUA: REKAP KEUANGAN, DIMULAI DARI KOLOM H -->
<table style="border-collapse: collapse; margin-top: 10px;">
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td> <!-- spasi hingga kolom G -->
        <td style="border: 1px solid #000; font-weight: bold;">
            <strong>{{ $isFiltered ? 'Total Pemasukan Bulan Ini' : 'Total Pemasukan Keseluruhan' }}</strong>
        </td>
        <td style="border: 1px solid #000; font-weight: bold;">{{ formatRupiah($totalPemasukan) }}</td>
    </tr>
    <tr style="border: 1px solid #000; font-weight: bold;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border: 1px solid #000; font-weight: bold;">
            <strong>{{ $isFiltered ? 'Total Pengeluaran Bulan Ini' : 'Total Pengeluaran Keseluruhan' }}</strong>
        </td>
        <td style="border: 1px solid #000; font-weight: bold;">{{ formatRupiah($totalPengeluaran) }}</td>
    </tr>
    <tr style="border: 1px solid #000; font-weight: bold;">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border: 1px solid #000; font-weight: bold;">
            <strong>{{ $isFiltered ? 'Sisa Keuangan Kas Bulan Ini' : 'Sisa Keuangan Keseluruhan' }}</strong>
        </td>
        <td style="border: 1px solid #000; font-weight: bold;">{{ formatRupiah($sisa) }}</td>
    </tr>
</table>
<br>

<table>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border: 1px solid #000; font-weight: bold;"><strong>Saldo Awal</strong></td>
        <td style="border: 1px solid #000; font-weight: bold;">{{ formatRupiah($saldoAwal) }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border: 1px solid #000; font-weight: bold;"><strong>Saldo Akhir</strong></td>
        <td style="border: 1px solid #000; font-weight: bold;">{{ formatRupiah($saldoAkhir) }}</td>
    </tr>
</table>
