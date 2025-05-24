<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Buat user dulu
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admintaqdis@gmail.com',
            'password' => bcrypt('kastaqdis123'),
        ]);

        // Lalu jalankan seeder lainnya
        $this->call([
            KategoriSeeder::class,
            KasSeeder::class,
        ]);
    }
}
