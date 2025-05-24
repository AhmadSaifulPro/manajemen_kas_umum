<?php

namespace App\Exports;

use App\Models\Kas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Events\AfterSheet;


class LaporanExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths, WithEvents
{
    protected $jenis, $tanggal_dari, $tanggal_sampai;

    public function __construct($jenis, $tanggal_dari, $tanggal_sampai)
    {
        $this->jenis = $jenis;
        $this->tanggal_dari = $tanggal_dari ?: null;
        $this->tanggal_sampai = $tanggal_sampai ?: null;
    }

    public function view(): View
    {
        $query = \App\Models\Kas::query();

        if ($this->jenis) {
            $query->where('jenis', $this->jenis);
        }

        // dd([
        //     'jenis' => $this->jenis,
        //     'tanggal_dari' => $this->tanggal_dari,
        //     'tanggal_sampai' => $this->tanggal_sampai,
        // ]);

        if (!empty($this->tanggal_dari) && !empty($this->tanggal_sampai)) {
            $query->whereBetween('tanggal', [
                \Carbon\Carbon::parse($this->tanggal_dari)->format('Y-m-d'),
                \Carbon\Carbon::parse($this->tanggal_sampai)->format('Y-m-d'),
            ]);
        } elseif (!empty($this->tanggal_dari)) {
            $query->whereDate('tanggal', '>=', \Carbon\Carbon::parse($this->tanggal_dari)->format('Y-m-d'));
        } elseif (!empty($this->tanggal_sampai)) {
            $query->whereDate('tanggal', '<=', \Carbon\Carbon::parse($this->tanggal_sampai)->format('Y-m-d'));
        }


        $data = $query->with('kategori')->get();

        // Hitung saldo sebelum tanggal laporan
        $sisaSaldoSebelumnya = 0;

        if (!empty($this->tanggal_dari)) {
            $saldoSebelum = \App\Models\Kas::whereDate('tanggal', '<', \Carbon\Carbon::parse($this->tanggal_dari)->format('Y-m-d'))->get();
            $sisaSaldoSebelumnya = $saldoSebelum->reduce(function ($carry, $item) {
                return $carry + ($item->jenis === 'Pemasukan' ? $item->nominal : -$item->nominal);
            }, 0);
        }

        // $sisaSaldoSebelumnya = \App\Models\Kas::whereDate('tanggal', '<', $this->tanggal_dari)->get()->reduce(function ($carry, $item) {
        //     return $carry + ($item->jenis === 'Pemasukan' ? $item->nominal : -$item->nominal);
        // }, 0);



        // Hitung saldo berjalan
        $runningSaldo = $sisaSaldoSebelumnya;

        $dataWithSaldo = $data->map(function ($item) use (&$runningSaldo) {
            $nominal = $item->nominal ?? 0;

            if ($item->jenis === 'Pemasukan') {
                $runningSaldo += $nominal;
            } elseif ($item->jenis === 'Pengeluaran') {
                $runningSaldo -= $nominal;
            }

            $item->saldo = $runningSaldo;

            // Escape kolom keterangan agar tidak dianggap formula di Excel
            if (Str::startsWith($item->keterangan, ['=', '+', '-', '@'])) {
                $item->keterangan = "'" . $item->keterangan;
            }

            return $item;
        });

        $totalPemasukan = $data->where('jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = $data->where('jenis', 'Pengeluaran')->sum('nominal');
        $sisa = $totalPemasukan - $totalPengeluaran;

        // Pemasukan per kategori
        $pemasukanPerKategori = $data->where('jenis', 'Pemasukan')
            ->groupBy('kategori_id')
            ->map(function ($items) {
                return [
                    'nama_kategori' => optional($items->first()->kategori)->nama_kategori ?? 'Lain-lain',
                    'total' => $items->sum('nominal'),
                ];
            })->values();

        // Pengeluaran per kategori
        $pengeluaranPerKategori = $data->where('jenis', 'Pengeluaran')
            ->groupBy('kategori_id')
            ->map(function ($items) {
                return [
                    'nama_kategori' => optional($items->first()->kategori)->nama_kategori ?? 'Lain-lain',
                    'total' => $items->sum('nominal'),
                ];
            })->values();


        $isFiltered = !empty($this->tanggal_dari) || !empty($this->tanggal_sampai);

        return view('excel3', [
            'data' => $data,
            'dataWithSaldo' => $dataWithSaldo,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'sisa' => $sisa,
            'saldoAwal' => $sisaSaldoSebelumnya,
            'saldoAkhir' => $runningSaldo,
            'pemasukanPerKategori' => $pemasukanPerKategori,
            'pengeluaranPerKategori' => $pengeluaranPerKategori,
            'isFiltered' => $isFiltered,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A4:G4')->getFont()->setBold(true); // Judul
        $sheet->getStyle('I4:J4')->getFont()->setBold(true); // Judul
        $sheet->getStyle('L4:M4')->getFont()->setBold(true); // Judul

        // $sheet->getStyle('A2:F2')->getFont()->setBold(true); // Header kolom

        $lastRow = count($this->getDataForCount()) + 5;

        // Border tabel data
        $sheet->getStyle("A4:G{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ]);

        // Border tabel data
        $sheet->getStyle("I4:J{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ]);

        $sheet->getStyle("L4:M{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ]);

        return [];
    }

    private function getDataForCount()
    {
        $query = \App\Models\Kas::query();

        if ($this->jenis) {
            $query->where('jenis', $this->jenis);
        }

        // dd([
        //     'jenis' => $this->jenis,
        //     'tanggal_dari' => $this->tanggal_dari,
        //     'tanggal_sampai' => $this->tanggal_sampai,
        // ]);

        if (!empty($this->tanggal_dari) && !empty($this->tanggal_sampai)) {
            $query->whereBetween('tanggal', [
                \Carbon\Carbon::parse($this->tanggal_dari)->format('Y-m-d'),
                \Carbon\Carbon::parse($this->tanggal_sampai)->format('Y-m-d'),
            ]);
        } elseif (!empty($this->tanggal_dari)) {
            $query->whereDate('tanggal', '>=', \Carbon\Carbon::parse($this->tanggal_dari)->format('Y-m-d'));
        } elseif (!empty($this->tanggal_sampai)) {
            $query->whereDate('tanggal', '<=', \Carbon\Carbon::parse($this->tanggal_sampai)->format('Y-m-d'));
        }

        // if ($this->tanggal_dari && $this->tanggal_sampai) {
        //     $query->whereBetween('tanggal', [$this->tanggal_dari, $this->tanggal_sampai]);
        // } elseif ($this->tanggal_dari) {
        //     $query->whereDate('tanggal', '>=', $this->tanggal_dari);
        // } elseif ($this->tanggal_sampai) {
        //     $query->whereDate('tanggal', '<=', $this->tanggal_sampai);
        // }
        return $query->get();
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,    // Kolom NO → ramping
            'B' => 22,
            'C' => 20,
            'D' => 20,
            'E' => 30,
            'F' => 20,
            'G' => 25,
            'H' => 5,
            'I' => 23,   // Kolom nilai rekap
            'J' => 18,   // Kolom nilai rekap
            'K' => 5,   //spasi
            'L' => 23,   // Kolom nilai rekap
            'M' => 18,   // Kolom nilai rekap
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Melebarkan kolom yang diperlukan agar teks tidak terpotong
                $sheet->getColumnDimension('J')->setWidth(18); // Spacer (jika dipakai)
                $sheet->getColumnDimension('K')->setWidth(5); // Pengeluaran kategori
                $sheet->getColumnDimension('L')->setWidth(23); // Jumlah pengeluaran
            },
        ];
    }
}
