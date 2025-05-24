<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Kas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Collection;


use function Ramsey\Uuid\v1;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function exportPdf(Request $request)
    // {
    //     $query = Kas::query();

    //     if ($request->jenis) {
    //         $query->where('jenis', $request->jenis);
    //     }

    //     if ($request->tanggal_dari && $request->tanggal_sampai) {
    //         $query->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai]);
    //     }

    //     $data = $query->get();
    //     $pdf = PDF::loadView('pdf', compact('data'));
    //     return $pdf->download('laporan_kas.pdf');
    // }

    public function exportPdf(Request $request)
    {
        $query = Kas::query();

        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->tanggal_dari && $request->tanggal_sampai) {
            $query->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai]);
        }

        $data = $query->orderBy('tanggal')->get();

        // Saldo awal = total pemasukan - pengeluaran sebelum tanggal_dari
        $saldo_awal = 0;
        if ($request->tanggal_dari) {
            $total_pemasukan = Kas::where('jenis', 'Pemasukan')->where('tanggal', '<', $request->tanggal_dari)->sum('nominal');
            $total_pengeluaran = Kas::where('jenis', 'Pengeluaran')->where('tanggal', '<', $request->tanggal_dari)->sum('nominal');
            $saldo_awal = $total_pemasukan - $total_pengeluaran;
        }

        // Saldo berjalan
        $runningSaldo = $saldo_awal;
        $dataWithSaldo = $data->map(function ($item) use (&$runningSaldo) {
            if ($item->jenis === 'Pemasukan') {
                $runningSaldo += $item->nominal;
            } else {
                $runningSaldo -= $item->nominal;
            }
            $item->saldo_berjalan = $runningSaldo;
            return $item;
        });

        // Rekap kategori
        $rekapKategoriPemasukan = $data->where('jenis', 'Pemasukan')
            ->groupBy('Kategori.nama_kategori')
            ->map(function ($group) {
                return $group->sum('nominal');
            });

        $rekapKategoriPengeluaran = $data->where('jenis', 'Pengeluaran')
            ->groupBy('Kategori.nama_kategori')
            ->map(function ($group) {
                return $group->sum('nominal');
            });

        // Rekap bulan
        $total_pemasukan_bulan_ini = $data->where('jenis', 'Pemasukan')->sum('nominal');
        $total_pengeluaran_bulan_ini = $data->where('jenis', 'Pengeluaran')->sum('nominal');
        $sisa_bulan_ini = $total_pemasukan_bulan_ini - $total_pengeluaran_bulan_ini;

        $bulan_tahun = Carbon::parse($request->tanggal_dari ?? now())->translatedFormat('F Y');
        $isFiltered = $request->filled('from_date') && $request->filled('to_date');

        return PDF::loadView('pdf2', compact(
            'dataWithSaldo',
            'saldo_awal',
            'bulan_tahun',
            'rekapKategoriPemasukan',
            'rekapKategoriPengeluaran',
            'total_pemasukan_bulan_ini',
            'total_pengeluaran_bulan_ini',
            'sisa_bulan_ini',
            'isFiltered',
            'request'
        ))->download('laporan_kas.pdf');
    }


    public function exportExcel(Request $request)
    {
        $request->validate([
            'tanggal_dari' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date',
        ]);

        // Optional validasi agar tidak salah urutan tanggal
        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            if ($request->tanggal_sampai < $request->tanggal_dari) {
                return back()->with('error', 'Tanggal sampai tidak boleh lebih awal dari tanggal dari.');
            }
        }

        $jenis = request('jenis') ?: null;
        $tanggal_dari = request('tanggal_dari') ?: null;
        $tanggal_sampai = request('tanggal_sampai') ?: null;


        // dd($request->all());
        return Excel::download(
            new LaporanExport(
                $jenis,
                $tanggal_dari,
                $tanggal_sampai
            ),
            'laporan-kas.xlsx'
        );
    }

    public function index(Request $request)
    {
        $query = Kas::with('Kategori');

        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->tanggal_dari && $request->tanggal_sampai) {
            $query->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai]);
        }

        $laporan_kas = $query->orderBy('tanggal', 'desc')->get();
        return view('laporan.index', compact('laporan_kas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
