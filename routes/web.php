<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // PEMBATASAN AKSES
    // PERLU KETIKA MEMBUAT HALAMAN MANAJEMEN USER
    // Route::middleware('can:manage-users')->group(function () {
    //     Route::get('/users', [])
    // })
});

