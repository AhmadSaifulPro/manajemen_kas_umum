<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $pemasukan = [
            'Donasi',
            'Iuran Bulanan',
            'Penjualan Buku',
            'Sponsorship'
        ];

        $pengeluaran = [
            'Pembelian Alat Tulis',
            'Biaya Internet',
            'Konsumsi Kegiatan',
            'Transportasi'
        ];

        foreach ($pemasukan as $item) {
            Kategori::create([
                'nama_kategori' => $item,
                'jenis' => 'Pemasukan',
                'deskripsi' => 'Kategori untuk pemasukan: ' . Str::lower($item)
            ]);
        }

        foreach ($pengeluaran as $item) {
            Kategori::create([
                'nama_kategori' => $item,
                'jenis' => 'Pengeluaran',
                'deskripsi' => 'Kategori untuk pengeluaran: ' . Str::lower($item)
            ]);
        }
    }
}
