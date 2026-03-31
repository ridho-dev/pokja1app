@extends('layouts.app')

@section('title', 'Daftar Surat Masuk')

@section('content')
<div class="card bg-base-100 shadow-xl w-full">
    <div class="card-body">
        <div class="flex justify-between items-center mb-6">
            <h2 class="card-title text-2xl font-bold text-[#102C57]">Daftar Surat P1</h2>
            <a href="{{ route('surat.create') }}" class="btn bg-[#102C57] text-white hover:bg-blue-900 btn-sm">
                + Upload Surat Baru
            </a>
        </div>

        {{-- Tabel Responsive --}}
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="w-10">No</th>
                        <th class="w-1/3">Nama Surat</th>
                        <th>Jenis Surat</th>
                        <th>Asal Surat (OPD/Daerah)</th>
                        <th>Kloter</th> 
                        {{-- <th class="text-center">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($letters as $index => $letter)
                        <tr class="hover">
                            {{-- Nomor Urut (sesuai pagination) --}}
                            <th>{{ $letters->firstItem() + $index }}</th>
                            
                            {{-- Kolom Nomor & Tanggal --}}
                            <td>
                                <div class="truncate max-w-sm" title="{{ $letter->file_name }}">{{ $letter->file_name }}</div>
                                <div class="text-xs text-gray-500">
                                    {{-- {{ \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('d F Y') }} --}}
                                    {{ $letter->opds->pluck('regency.name')->unique()->filter()->implode(', ') }}
                                </div>
                            </td>

                            {{-- Kolom Jenis --}}
                            <td>
                                <div class="flex items-center">
                                    @php
                                        // 1. Daftar pemetaan ID Jenis Surat ke kode warna HEX yang kontras
                                        $badgeColors = [
                                            11 => '#2563EB', // Biru Terang (Blue)
                                            12 => '#16A34A', // Hijau Daun (Green)
                                            21 => '#9333EA', // Ungu (Purple)
                                            22 => '#0891B2', // Tosca Gelap (Cyan)
                                            23 => '#EA580C', // Oranye (Orange)
                                            24 => '#DB2777', // Merah Muda (Pink)
                                            25 => '#DC2626', // Merah Terang (Red)
                                            26 => '#4B5563', // Abu-abu Gelap (Slate)
                                        ];

                                        $hexColor = $badgeColors[$letter->letter_type_id] ?? '#9CA3AF'; 
                                    @endphp

                                    <span class="badge bg-transparent h-auto whitespace-normal text-center py-1 px-2 leading-tight"
                                        style="color: {{ $hexColor }}; border: 1px solid {{ $hexColor }};">
                                        {{ $letter->letterType->letter_type ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Kolom Asal (OPD, Kab, Prov) --}}
                            <td>
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

                            {{-- Kolom Masa Berlaku (Hanya muncul jika ada datanya) --}}
                            {{-- <td>
                                @if($letter->start_date && $letter->end_date)
                                    <div class="text-xs">
                                        <span class="text-green-600 font-bold">Mulai:</span> 
                                        {{ \Carbon\Carbon::parse($letter->start_date)->format('d/m/Y') }}
                                        <br>
                                        <span class="text-red-600 font-bold">Akhir:</span> 
                                        {{ \Carbon\Carbon::parse($letter->end_date)->format('d/m/Y') }}
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td> --}}

                            <td>
                                @if($letter->kloter)
                                    <span>{{ $letter->kloter }}</span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            {{-- Kolom Aksi (Download) --}}
                            {{-- <td class="text-center">
                                <a href="{{ route('surat.download', $letter->id) }}" class="btn btn-ghost btn-xs text-blue-600 tooltip" data-tip="Download File">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </a>
                            </td> --}}
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

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $letters->links() }} 
        </div>
    </div>
</div>
@endsection