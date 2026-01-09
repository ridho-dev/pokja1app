<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// 1. Halaman Login (Tamu only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
    
    // Redirect root '/' ke login jika belum login
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

// 2. Halaman Dashboard (Hanya yang sudah Login)
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Halaman Logout
Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
});