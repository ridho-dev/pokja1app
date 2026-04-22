@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex justify-center mt-0 mb-10">
        {{-- Pembungkus utama konten --}}
        <div class="w-full max-w-screen-xl px-4 md:px-0 flex flex-col gap-4">
            
            {{-- Bagian Teks Header --}}
            <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
                <div class="card-body">
                    <h2 class="text-2xl font-bold text-start text-[#102C57]">Selamat Datang, {{ Auth::user()->name }}</h2>
                    <p class="text-start text-gray-600">Kelola dan pantau surat masuk dengan mudah melalui dashboard ini.</p>
                </div>
            </div>

            {{-- Bagian Grid Layout --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2 flex flex-col gap-6">
                    
                    <div class="w-full">
                        <h1 class="text-[#102C57] font-bold text-2xl divider">Proses Surat</h1>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                        
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Total Surat</h4>
                                <p class="text-2xl font-bold text-[#102C57]">{{ $totalSurat }}</p>
                            </div>
                        </div>
                        
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Izin Baru</h4>
                                <p class="text-2xl font-bold text-success">{{ $totalIzinBaru }}</p>
                            </div>
                        </div>
                        
                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Perpanjangan</h4>
                                <p class="text-2xl font-bold text-warning">{{ $totalPerpanjangan }}</p>
                            </div>
                        </div>

                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Adendum</h4>
                                <p class="text-2xl font-bold text-secondary">0</p>
                            </div>
                        </div>

                        <div class="card bg-base-100 shadow-sm border border-gray-200">
                            <div class="card-body p-5 items-center text-center">
                                <h4 class="text-sm font-semibold text-gray-500">Ditolak</h4>
                                <p class="text-2xl font-bold text-error">0</p>
                            </div>
                        </div>

                    </div>

                    <div class="card w-full bg-base-100 shadow-xl border border-gray-200 flex-grow">
                        <div class="card-body">
                            <h3 class="card-title text-[#102C57] text-lg">Grafik atau Tabel Data</h3>
                            <div class="mt-4 h-48 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center text-gray-400">
                                Area Konten Bawah
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="md:col-span-1">
                    
                    <div class="card w-full bg-base-100 shadow-xl border border-gray-200 h-full">
                        <div class="card-body">
                            <h3 class="card-title text-primary text-lg">Aktivitas Terbaru</h3>
                            
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
                                <th class="text-center">Aksi</th>
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
                                            {{-- Looping untuk menampilkan setiap OPD di baris baru --}}
                                            @foreach($letter->opds as $opd)
                                                <div class="mb-1 truncate max-w-xs" title="{{ $opd->name }}">
                                                    <a href="{{ route('opd.show', $opd->id) }}" class="cursor-pointer hover:!underline text-[#102C57] hover:text-blue-600 border-b border-transparent hover:border-blue-600 transition-colors pb-0.5">
                                                        {{ $opd->name }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if($letter->opds->isNotEmpty())
                                            {{-- Looping untuk menampilkan setiap OPD di baris baru --}}
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

                                    {{-- Kolom Aksi --}}
                                    <td class="text-center">
                                        <div class="tooltip tooltip-left md:tooltip-top" data-tip="Detail">
                                            
                                            <a href="{{ route('surat.show', $letter->id) }}" 
                                            class="btn btn-sm btn-square bg-slate-100 text-primary-600 hover:bg-[#c4c4c4] !hover:text-red border-none shadow-sm transition-all duration-300 p-2">
                                                <x-icons.magnifying-glass />
                                            </a>
                                            
                                        </div>
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