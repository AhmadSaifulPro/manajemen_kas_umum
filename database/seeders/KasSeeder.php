<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kas;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KasSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Kategori::all();

        if ($kategori->isEmpty()) {
            $this->command->warn("Kategori belum tersedia. Jalankan KategoriSeeder terlebih dahulu.");
            return;
        }

        $bulanTahun = [
            ['bulan' => 1, 'tahun' => 2025],
            ['bulan' => 2, 'tahun' => 2025],
            ['bulan' => 3, 'tahun' => 2025],
            ['bulan' => 4, 'tahun' => 2025],
            ['bulan' => 5, 'tahun' => 2025],
        ];

        $keteranganPemasukan = [
            'Donasi siswa', 'Iuran bulanan kelas', 'Penjualan barang', 'Transfer masuk', 'Pemasukan tambahan'
        ];

        $keteranganPengeluaran = [
            'Beli alat tulis', 'Bayar internet', 'Konsumsi kegiatan', 'Biaya transportasi', 'Pengeluaran operasional'
        ];

        foreach ($bulanTahun as $bt) {
            for ($i = 0; $i < 10; $i++) {
                $isPemasukan = rand(0, 1) === 1;
                $jenis = $isPemasukan ? 'Pemasukan' : 'Pengeluaran';

                $tanggal = Carbon::create($bt['tahun'], $bt['bulan'], rand(1, 28))->setTime(rand(8, 17), rand(0, 59));

                Kas::create([
                    'jenis' => $jenis,
                    'tanggal' => $tanggal,
                    'nominal' => rand(10000, 100000),
                    'keterangan' => $isPemasukan
                        ? $keteranganPemasukan[array_rand($keteranganPemasukan)]
                        : $keteranganPengeluaran[array_rand($keteranganPengeluaran)],
                    'kategori_id' => $kategori->where('jenis', $jenis)->random()->id_kategori,
                    'user_id' => 1,
                ]);
            }
        }
    }
}
