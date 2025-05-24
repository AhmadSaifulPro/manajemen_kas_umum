<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('do-login', [AuthController::class, 'do_login'])->name('do_login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    });

    Route::resource('dashboard', DashboardController::class);

    Route::resource('kategori', KategoriController::class);
    Route::post('/kategori/restore/{id_kategori}', [KategoriController::class, 'restore'])->name('kategori.restore');
    Route::delete('/kategori/force-delete/{id_kategori}', [KategoriController::class, 'forceDelete'])->name('kategori.forceDelete');

    Route::resource('kas', KasController::class);
    Route::post('/kas/restore/{id_kas}', [KasController::class, 'restore'])->name('kas.restore');
    Route::delete('/kas/force-delete/{id_kas}', [kasController::class, 'forceDelete'])->name('kas.forceDelete');

    Route::resource('user', UserController::class);
    Route::post('/user/restore/{id_users}', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/user/force-delete/{id_user}', [UserController::class, 'forceDelete'])->name('user.forceDelete');

    Route::resource('laporan', LaporanController::class);
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('export.excel');


    Route::get('/riwayat-kas', [DashboardController::class, 'riwayatKas'])->name('riwayat.kas');
});
