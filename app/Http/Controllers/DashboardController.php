<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Total Keseluruhan
        $pemasukanKeseluruhan = Kas::where('jenis', 'Pemasukan')->sum('nominal');
        $pengeluaranKeseluruhan = Kas::where('jenis', 'Pengeluaran')->sum('nominal');
        $sisaKeseluruhan = $pemasukanKeseluruhan - $pengeluaranKeseluruhan;

        // Bulan Ini
        $pemasukanBulan = Kas::where('jenis', 'Pemasukan')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('nominal');

        $pengeluaranBulan = Kas::where('jenis', 'Pengeluaran')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('nominal');

        $sisaBulan = $pemasukanBulan - $pengeluaranBulan;

        // Hari Ini
        $pemasukanHari = Kas::where('jenis', 'Pemasukan')
            ->whereDate('tanggal', $today)
            ->sum('nominal');

        $pengeluaranHari = Kas::where('jenis', 'Pengeluaran')
            ->whereDate('tanggal', $today)
            ->sum('nominal');

        $sisaHari = $pemasukanHari - $pengeluaranHari;

        $riwayatKas = Kas::latest('tanggal')->take(10)->get();

        // \Log::info('Masuk dashboard', ['user' => auth()->user()]);
    // return view('dashboard.index');
        return view('dashboard.index', compact(
            'sisaKeseluruhan',
            'pengeluaranKeseluruhan',
            'pemasukanKeseluruhan',
            'sisaBulan',
            'pengeluaranBulan',
            'pemasukanBulan',
            'sisaHari',
            'pengeluaranHari',
            'pemasukanHari',
            'riwayatKas'
        ));
    }

    public function riwayatKas()
    {
        $riwayatKas = Kas::orderBy('tanggal', 'desc')->paginate(20); // Bisa disesuaikan jumlah per halaman
        return view('dashboard.riwayat-kas', compact('riwayatKas'));
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
