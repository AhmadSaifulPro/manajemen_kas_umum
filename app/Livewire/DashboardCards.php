<?php

namespace App\Livewire;

use App\Models\Kas;
use Carbon\Carbon;
use Livewire\Component;

class DashboardCards extends Component
{
    public $today;
    public $currentMonth;
    public $currentYear;

    public function mount()
    {
        $this->today = Carbon::today();
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    public function render()
    {
        // Total keseluruhan
        $pemasukanKeseluruhan = Kas::where('jenis', 'Pemasukan')->sum('nominal');
        $pengeluaranKeseluruhan = Kas::where('jenis', 'Pengeluaran')->sum('nominal');
        $sisaKeseluruhan = $pemasukanKeseluruhan - $pengeluaranKeseluruhan;

        // Bulan ini
        $pemasukanBulan = Kas::where('jenis', 'Pemasukan')
            ->whereMonth('tanggal', $this->currentMonth)
            ->whereYear('tanggal', $this->currentYear)
            ->sum('nominal');

        $pengeluaranBulan = Kas::where('jenis', 'Pengeluaran')
            ->whereMonth('tanggal', $this->currentMonth)
            ->whereYear('tanggal', $this->currentYear)
            ->sum('nominal');

        $sisaBulan = $pemasukanBulan - $pengeluaranBulan;

        // Hari ini
        $pemasukanHari = Kas::where('jenis', 'Pemasukan')
            ->whereDate('tanggal', $this->today)
            ->sum('nominal');

        $pengeluaranHari = Kas::where('jenis', 'Pengeluaran')
            ->whereDate('tanggal', $this->today)
            ->sum('nominal');

        $sisaHari = $pemasukanHari - $pengeluaranHari;

        return view('livewire.dashboard-cards', compact(
            'pemasukanKeseluruhan', 'pengeluaranKeseluruhan', 'sisaKeseluruhan',
            'pemasukanBulan', 'pengeluaranBulan', 'sisaBulan',
            'pemasukanHari', 'pengeluaranHari', 'sisaHari'
        ));
    }
}
