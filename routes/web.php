<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\PKSController;
use App\Http\Controllers\MasukP1Controller;
use App\Http\Controllers\BalasanP1Controller;
use App\Http\Controllers\MasukP2Controller;
use App\Http\Controllers\BalasanP2Controller;
use App\Http\Controllers\DashboardController;

// 1. Halaman Login 
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
    
    // Redirect root '/' ke login jika belum login
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

// 2. Halaman untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Upload Surat P1
    Route::get('/pages/upload', [SuratController::class, 'create'])->name('surat.create');
    Route::post('/pages/upload', [SuratController::class, 'store'])->name('surat.store');
    Route::get('/api/regencies/{province_id}', [SuratController::class, 'getRegencies']);
    Route::get('/api/opds/{regency_id}', [SuratController::class, 'getOpds']);

    // Upload Surat Masuk P1
    Route::get('/pages/upload-masuk-p1', [MasukP1Controller::class, 'create'])->name('masukP1.create');
    Route::post('/pages/upload-masuk-p1', [MasukP1Controller::class, 'store'])->name('masukP1.store');
    Route::get('/api/regencies/{province_id}', [MasukP1Controller::class, 'getRegencies']);
    Route::get('/api/opds/{regency_id}', [MasukP1Controller::class, 'getOpds']);

    // Upload Surat Balasan P1
    Route::get('/pages/upload-balasan-p1', [BalasanP1Controller::class, 'create'])->name('balasanP1.create');
    Route::post('/pages/upload-balasan-p1', [BalasanP1Controller::class, 'store'])->name('balasanP1.store');
    Route::get('/api/regencies/{province_id}', [BalasanP1Controller::class, 'getRegencies']);
    Route::get('/api/opds/{regency_id}', [BalasanP1Controller::class, 'getOpds']);

    // Upload Surat Masuk P2
    Route::get('/pages/upload-masuk-p2', [MasukP2Controller::class, 'create'])->name('masukP2.create');
    Route::post('/pages/upload-masuk-p2', [MasukP2Controller::class, 'store'])->name('masukP2.store');
    Route::get('/api/regencies/{province_id}', [MasukP2Controller::class, 'getRegencies']);
    Route::get('/api/opds/{regency_id}', [MasukP2Controller::class, 'getOpds']);

    // Upload Balasan Masuk P2
    Route::get('/pages/upload-balasan-p2', [BalasanP2Controller::class, 'create'])->name('balasanP2.create');
    Route::post('/pages/upload-balasan-p2', [BalasanP2Controller::class, 'store'])->name('balasanP2.store');
    Route::get('/api/regencies/{province_id}', [BalasanP2Controller::class, 'getRegencies']);
    Route::get('/api/opds/{regency_id}', [BalasanP2Controller::class, 'getOpds']);

    // Upload PKS
    Route::get('/pages/upload-pks', [PKSController::class, 'create'])->name('pks.create');
    Route::post('/pages/upload-pks', [PKSController::class, 'store'])->name('pks.store');
    Route::get('/api/regencies/{province_id}', [PKSController::class, 'getRegencies']);
    Route::get('/api/opds/{regency_id}', [PKSController::class, 'getOpds']);

    // Halaman Daftar Surat
    Route::get('/pages/daftar-surat', [SuratController::class, 'index'])->name('surat.index');
    Route::get('/pages/download/{id}', [SuratController::class, 'download'])->name('surat.download');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // PEMBATASAN AKSES
    // PERLU KETIKA MEMBUAT HALAMAN MANAJEMEN USER
    // Route::middleware('can:manage-users')->group(function () {
    //     Route::get('/users', [])
    // })
});

