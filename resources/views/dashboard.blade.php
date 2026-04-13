@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex justify-center mt-0 mb-10">
        {{-- Pembungkus utama konten (w-full max-w-5xl) --}}
        <div class="w-full max-w-5xl px-4 md:px-0 flex flex-col gap-4">
            
            {{-- 1. Bagian Teks Header (Tetap Penuh Lebarnya) --}}
            <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
                <div class="card-body">
                    <h2 class="text-2xl font-bold text-start text-[#102C57]">Selamat Datang, {{ Auth::user()->name }}</h2>
                    <p class="text-start text-gray-600">Kelola dan pantau surat masuk dengan mudah melalui dashboard ini.</p>
                </div>
            </div>

            {{-- 2. Bagian Grid Layout --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                {{-- SISI KIRI (Mengambil 2 dari 3 kolom) --}}
                <div class="md:col-span-2 flex flex-col gap-6">

                    {{-- Box 1: Atas (Panjang) --}}
                    <div class="w-full">
                        <h1 class="text-[#102C57] font-bold text-2xl divider">Proses Surat</h1>
                    </div>
                    {{-- Box 2: Tengah (3 Kotak Kecil) --}}
                    {{-- sm:grid-cols-3 membuat kotak menumpuk di HP, berjajar 3 di layar yang agak besar --}}
                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                        
                        {{-- Kotak Kecil 1 --}}
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Total Surat</h4>
                                <p class="text-2xl font-bold text-[#102C57]">150</p>
                            </div>
                        </div>
                        
                        {{-- Kotak Kecil 2 --}}
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Izin Baru</h4>
                                <p class="text-2xl font-bold text-success">85</p>
                            </div>
                        </div>
                        
                        {{-- Kotak Kecil 3 --}}
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Perpanjangan</h4>
                                <p class="text-2xl font-bold text-warning">65</p>
                            </div>
                        </div>

                        {{-- Kotak Kecil 4 --}}
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Adendum</h4>
                                <p class="text-2xl font-bold text-secondary">2</p>
                            </div>
                        </div>

                        {{-- Kotak Kecil 5 --}}
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Ditolak</h4>
                                <p class="text-2xl font-bold text-error">13</p>
                            </div>
                        </div>

                    </div>

                    {{-- Box 3: Bawah (Besar) --}}
                    <div class="card w-full bg-base-100 shadow-xl border border-gray-200 flex-grow">
                        <div class="card-body">
                            <h3 class="card-title text-[#102C57] text-lg">Grafik atau Tabel Data</h3>
                            {{-- Dummy area konten agar kotak membesar --}}
                            <div class="mt-4 h-48 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center text-gray-400">
                                Area Konten Bawah
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- SISI KANAN (Mengambil 1 dari 3 kolom) --}}
                <div class="md:col-span-1">
                    
                    {{-- Box 4: Sidebar / Notifikasi (Tinggi penuh) --}}
                    <div class="card w-full bg-base-100 shadow-xl border border-gray-200 max-h-xl">
                        <div class="card-body">
                            <h3 class="card-title text-primary text-lg">Aktivitas Terbaru</h3>
                            
                            {{-- Contoh isi sidebar --}}
                            <ul class="mt-4 space-y-4">
                                <li class="text-sm">
                                    <span class="font-bold text-[#102C57]">System</span> menambah surat P1.
                                    <div class="text-xs text-gray-400 mt-1">5 menit yang lalu</div>
                                </li>
                                <li class="text-sm">
                                    <span class="font-bold text-[#102C57]">Admin</span> menghapus surat balasan P2.
                                    <div class="text-xs text-gray-400 mt-1">1 jam yang lalu</div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                
            </div>


            {{-- Bagian Pelaporan --}}
            {{-- 1. Bagian Teks Header (Tetap Penuh Lebarnya) --}}
            <div class="w-full">
                <h1 class="text-[#102C57] font-bold text-2xl divider">Pelaporan</h1>
            </div>
            <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
                <div class="card-body">
                    <h2 class="text-2xl font-bold text-start text-[#102C57]">Selamat Datang, {{ Auth::user()->name }}</h2>
                    <p class="text-start text-gray-600">Kelola dan pantau surat masuk dengan mudah melalui dashboard ini.</p>
                </div>
            </div>
        </div>
    </div>
@endsection