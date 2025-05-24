<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h1 align="center">Aplikasi Manajemen Kas Umum</h1>
<p align="center">Aplikasi Laravel 12 untuk mencatat pemasukan, pengeluaran, dan saldo kas berjalan — dilengkapi rekap & export PDF dan Excel.</p>

---

## 🚀 Fitur Utama

- CRUD Kategori
- CRUD Data Kas (Pemasukan & Pengeluaran)
- Saldo Berjalan Otomatis
- Filter Tanggal dan Kategori
- Rekap Per Kategori dan Per Bulan
- Export PDF dan Excel
- UI Responsif (jika pakai Livewire atau Bootstrap)
- Laravel 12 + Livewire 3 + Maatwebsite Excel + DOMPDF


## 🛠️ Tech Stack

- **PHP 8.2**
- **Laravel 12**
- **Livewire 3**
- **DOMPDF** untuk export PDF
- **Maatwebsite Excel** untuk export Excel
- **PhpSpreadsheet** (pendukung Excel)
- **MySQL** 

---

## 🧑‍💻 Cara Menjalankan (Local Development)

1. Clone Repository:
    ```bash
    git clone https://github.com/username/nama-repo-kamu.git
    cd nama-repo-kamu

2. Install Dependency:
    ```bash
    composer install

3. Copy File Environment:
    ```bash
    cp .env.example .env

4. Set Konfigurasi Database di .env:
    ```bash
    DB_DATABASE=kas_umum
    DB_USERNAME=root
    DB_PASSWORD=

5. Generate App Key:
    ```bash
    php artisan key:generate

6. Migrasi Database:
    ```bash
    php artisan migrate

7. Jalankan Server:
    ```bash
    php artisan serve
Lalu buka: http://localhost:8000


📦 Package Laravel yang Digunakan
```bash
json
Salin
Edit
"require": {
    "php": "^8.2",
    "barryvdh/laravel-dompdf": "^3.1",
    "doctrine/dbal": "^4.2",
    "laravel/framework": "^12.0",
    "laravel/tinker": "^2.10.1",
    "livewire/livewire": "^3.6",
    "maatwebsite/excel": "^3.1",
    "phpoffice/phpspreadsheet": "^1.29"
}
```



## 👨‍💻 Developer
Ahmad Saiful – [AhmadSaifulPro](https://github.com/AhmadSaifulPro)<br>
Email: ahmadsaifullpro@gmail.com<br>
Universitas: Universitas Safin Pati<br>
Prodi: Teknik Informatika<br>
