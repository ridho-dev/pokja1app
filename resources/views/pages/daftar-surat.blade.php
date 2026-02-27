@extends('layouts.app')

@section('title', 'Daftar Surat Masuk')

@section('content')
<div class="card bg-base-100 shadow-xl w-full">
    <div class="card-body">
        <div class="flex justify-between items-center mb-6">
            <h2 class="card-title text-2xl font-bold text-[#102C57]">Daftar Surat Masuk</h2>
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
                        <th>Nomor & Tanggal</th>
                        <th>Jenis Surat</th>
                        <th>Asal Surat (OPD/Daerah)</th>
                        <th>Masa Berlaku</th> <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($letters as $index => $letter)
                        <tr class="hover">
                            {{-- Nomor Urut (sesuai pagination) --}}
                            <th>{{ $letters->firstItem() + $index }}</th>
                            
                            {{-- Kolom Nomor & Tanggal --}}
                            <td>
                                <div class="font-bold">{{ $letter->letter_number }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($letter->letter_date)->translatedFormat('d F Y') }}
                                </div>
                            </td>

                            {{-- Kolom Jenis --}}
                            <td>
                                <div class="flex items-center">
                                    <span class="badge badge-outline badge-primary font-semibold h-auto">
                                        {{ $letter->letterType->letter_type ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Kolom Asal (OPD, Kab, Proov) --}}
                            <td>
                                <div class="font-bold text-sm">{{ $letter->opd->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $letter->regency->name ?? '' }}, {{ $letter->province->name ?? '' }}
                                </div>
                            </td>

                            {{-- Kolom Masa Berlaku (Hanya muncul jika ada datanya) --}}
                            <td>
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
                            </td>

                            {{-- Kolom Aksi (Download) --}}
                            <td class="text-center">
                                <a href="{{ route('surat.download', $letter->id) }}" class="btn btn-ghost btn-xs text-blue-600 tooltip" data-tip="Download File">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </a>
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

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $letters->links() }} 
        </div>
    </div>
</div>
@endsection