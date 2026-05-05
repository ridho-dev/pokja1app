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
                            <h3 class="card-title text-[#102C57] text-lg">Grafik Data P1</h3>
                            <div class="mt-4 relative h-72 w-full flex items-center justify-center">
                                {{-- KANVAS GRAFIK WAJIB ADA DI SINI --}}
                                <canvas id="grafikKloter"></canvas>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="md:col-span-1">
                    <div class="card w-full bg-base-100 shadow-xl border border-gray-200 h-full">
                        <div class="card-body">
                            <h3 class="card-title text-primary text-lg">Aktivitas Terbaru</h3>
                            
                            <ul class="mt-4 space-y-4">
                                @forelse($recentActivities as $log)
                                    @php
                                        // Jenis Surat
                                        $jenisSurat = $log->letterType->letter_type ?? 'Dokumen';
                                        // Wilayah
                                        $namaWilayah = '';
                                        if ($log->regency) {
                                            $namaWilayah = ucwords(strtolower($log->regency->name)); 
                                        }
                                        // Aktivitas
                                        $kataKerja = strtolower($log->activityType->activity_type ?? 'memproses');
                                    @endphp

                                    <li class="text-sm">
                                        {{-- Nama User --}}
                                        <span class="font-bold text-[#102C57]">
                                            {{ $log->user->name ?? 'System' }}
                                        </span> 
                                        {{-- Aktivitas --}}
                                        {{ $kataKerja }} 
                                        <span class="font-medium text-gray-800">
                                            {{ $jenisSurat }} {{ $namaWilayah}}
                                        </span>.
                                        {{-- Waktu --}}
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $log->created_at->diffForHumans() }}
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-sm text-gray-400 italic">Belum ada aktivitas di sistem.</li>
                                @endforelse
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('grafikKloter').getContext('2d');
    
    // Ambil rincian dinamis dari PHP
    const rincianDinamis = {!! json_encode($typeDetails ?? []) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels ?? []) !!}, 
            datasets: [{
                label: 'Total Surat',
                data: {!! json_encode($dataTotal ?? []) !!},
                backgroundColor: '#102C57',
                borderRadius: 6,
                borderWidth: 0,
                hoverBackgroundColor: '#1a4585' 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(16, 44, 87, 0.95)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            let dataIndex = context.dataIndex;
                            let total = context.raw;
                            
                            // Awali dengan Total
                            let tooltipLines = ['Total : ' + total + ' OPD'];

                            // Tambahkan baris untuk setiap jenis izin yang ada di database secara otomatis
                            Object.keys(rincianDinamis).forEach(function(key) {
                                let label = rincianDinamis[key].label;
                                let nilai = rincianDinamis[key].data[dataIndex];
                                tooltipLines.push('• ' + label + ': ' + nilai);
                            });

                            return tooltipLines;
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endsection