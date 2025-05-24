<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Kas Bulan {{ $bulan_tahun }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
            font-size: 12px;
        }

        h2,
        h3 {
            text-align: center;
            margin: 0;
        }
    </style>
</head>

<body>
    {{--
    <h2>LAPORAN KEUANGAN KAS BULAN</h2>
    <h2>{{ strtoupper($bulan_tahun) }}</h2> --}}

    @php
        $tanggal_dari = request()->tanggal_dari;
        $tanggal_sampai = request()->tanggal_sampai;
    @endphp
    <h2>
        {{ empty($tanggal_dari) && empty($tanggal_sampai)
            ? 'LAPORAN KEUANGAN KAS KESELURUHAN'
            : 'LAPORAN KEUANGAN KAS BULAN' }}
    </h2>
    @if (!empty($tanggal_dari) && !empty($tanggal_sampai))
        <h2>{{ strtoupper($bulan_tahun) }}</h2>
    @endif

    <br>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Keterangan</th>
                <th>Kategori</th>
                <th>Saldo Berjalan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataWithSaldo as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>
                        @if ($item->jenis == 'Pemasukan')
                            Rp{{ number_format($item->nominal, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        @if ($item->jenis == 'Pengeluaran')
                            Rp{{ number_format($item->nominal, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ optional($item->Kategori)->nama_kategori }}</td>
                    <td>Rp{{ number_format($item->saldo_berjalan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <table>
        <tr>
            <td><strong>
                    {{ empty($tanggal_dari) && empty($tanggal_sampai) ? 'Total Pemasukan Keseluruhan' : 'Total Pemasukan Bulan Ini' }}</strong>
            </td>
            <td>Rp{{ number_format($total_pemasukan_bulan_ini, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>{{ empty($tanggal_dari) && empty($tanggal_sampai) ? 'Total Pemasukan Keseluruhan' : 'Total Pemasukan Bulan Ini' }}</strong>
            </td>
            <td>Rp{{ number_format($total_pengeluaran_bulan_ini, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>{{ empty($tanggal_dari) && empty($tanggal_sampai) ? 'Total Pemasukan Keseluruhan' : 'Total Pemasukan Bulan Ini' }}</strong>
            </td>
            <td>Rp{{ number_format($sisa_bulan_ini, 0, ',', '.') }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td>Saldo Awal</td>
            <td>Rp{{ number_format($saldo_awal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Saldo Akhir</td>
            <td>Rp{{ number_format(optional($dataWithSaldo->last())->saldo_berjalan ?? $saldo_awal, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <h4>LAPORAN PEMASUKAN PER KATEGORI</h4>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapKategoriPemasukan as $kategori => $total)
                <tr>
                    <td>{{ $kategori }}</td>
                    <td>Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>LAPORAN PENGELUARAN PER KATEGORI</h4>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapKategoriPengeluaran as $kategori => $total)
                <tr>
                    <td>{{ $kategori }}</td>
                    <td>Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    {{-- <table width="100%">
    <tr>
        <td></td>
        <td align="right">
            Pati, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><br><br><br><br>
            <b>{{ Auth::user()->name }}</b><br>
            Admin Kas Umum
        </td>
    </tr>
</table> --}}

</body>

</html>
