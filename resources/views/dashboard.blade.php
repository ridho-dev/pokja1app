@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex justify-center mt-0 mb-10">
        {{-- Pembungkus utama konten (w-full max-w-5xl) --}}
        <div class="w-full max-w-screen-xl px-4 md:px-0 flex flex-col gap-4">
            
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
                                <p class="text-2xl font-bold text-[#102C57]">{{ $totalSurat }}</p>
                            </div>
                        </div>
                        
                        {{-- Kotak Kecil 2 --}}
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Izin Baru</h4>
                                <p class="text-2xl font-bold text-success">{{ $totalIzinBaru }}</p>
                            </div>
                        </div>
                        
                        {{-- Kotak Kecil 3 --}}
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Perpanjangan</h4>
                                <p class="text-2xl font-bold text-warning">{{ $totalPerpanjangan }}</p>
                            </div>
                        </div>

                        {{-- Kotak Kecil 4 --}}
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Adendum</h4>
                                <p class="text-2xl font-bold text-secondary">0</p>
                            </div>
                        </div>

                        {{-- Kotak Kecil 5 --}}
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Ditolak</h4>
                                <p class="text-2xl font-bold text-error">0</p>
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
                    <div class="card w-full bg-base-100 shadow-xl border border-gray-200 h-full">
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

            <div class="w-full">
                <h1 class="text-[#102C57] font-bold text-2xl divider">Daftar Surat</h1>
            </div>
            <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="w-10">No</th>
                                <th class="px-0 mx-0">Jenis Surat</th>
                                <th>Provinsi</th>
                                <th>Kab/Kota</th>
                                <th>OPD</th>
                                <th>Jenis P1</th>
                                <th>Kloter</th>
                                <th>Tanggal Surat</th>
                                <th>Nomor Surat</th>
                                {{-- <th class="text-center">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($letters as $index => $letter)
                                <tr class="hover">
                                    {{-- Nomor Urut --}}
                                    <th>{{ $letters->firstItem() + $index }}</th>

                                    {{-- Kolom Jenis --}}
                                    <td>
                                        <div class="flex items-center">
                                            @php
                                                // 1. Daftar pemetaan ID Jenis Surat ke kode warna HEX yang kontras
                                                $badgeColors = [
                                                    11 => '#2563EB', // Biru Terang
                                                    12 => '#16A34A', // Hijau Daun
                                                    21 => '#9333EA', // Ungu
                                                    22 => '#0891B2', // Tosca Gelap
                                                    23 => '#EA580C', // Oranye
                                                    24 => '#DB2777', // Merah Muda
                                                    25 => '#DC2626', // Merah Terang
                                                    26 => '#4B5563', // Abu-abu Gelap
                                                ];

                                                $hexColor = $badgeColors[$letter->letter_type_id] ?? '#9CA3AF'; 
                                            @endphp

                                            <span class="badge bg-transparent h-auto text-xs text-center py-0 px-2 leading-tight"
                                                style="color: {{ $hexColor }}; border: 1px solid {{ $hexColor }};">
                                                {{ $letter->letterType->letter_type ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    {{-- Nama Provinsi --}}
                                    <td>
                                        <div>
                                            {{ $letter->opds->pluck('regency.province.name')->unique()->filter()->implode(', ') }}
                                        </div>
                                    </td>

                                    {{-- Nama Kabupaten --}}
                                    <td>
                                        <div>
                                            {{ $letter->opds->pluck('regency.name')->unique()->filter()->implode(', ') }}
                                        </div>
                                    </td>

                                    {{-- Kolom Asal (OPD, Kab, Prov) --}}
                                    <td class="">
                                        @if($letter->opds->isNotEmpty())
                                            {{-- Lakukan looping untuk menampilkan setiap OPD di baris baru --}}
                                            @foreach($letter->opds as $opd)
                                                <div class="mb-1 truncate max-w-xs" title="{{ $opd->name }}">
                                                    {{ $opd->name }}
                                                </div>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if($letter->opds->isNotEmpty())
                                            {{-- Lakukan looping untuk menampilkan setiap OPD di baris baru --}}
                                            @foreach($letter->opds as $opd)
                                                <div class="mb-1 truncate " title="{{ $opd->name }}">
                                                    {{ $opd->pivot->p1Type?->type_name }}
                                                </div>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if($letter->kloter)
                                            <span>{{ $letter->kloter }}</span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($letter->letter_date)
                                            <span>
                                            {{ \Carbon\Carbon::parse($letter->letter_date)->format('d F Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($letter->letter_number)
                                            <span>{{ $letter->letter_number }}</span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">
                                        Belum ada surat yang diupload.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection