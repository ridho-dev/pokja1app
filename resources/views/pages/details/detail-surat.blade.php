@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-0 mb-10">
    <div class="w-full max-w-screen-xl px-4 md:px-0 flex flex-col gap-4">
        {{-- AREA HEADER --}}
        <div class="flex items-center justify-between mt-4 mb-2">
            <h2 class="text-2xl font-bold text-[#102C57]">{{ preg_replace('/^\d{8}_\d{6}\s/', '', $letter->file_name) }}</h2>
            
            <button onclick="history.back()" class="btn btn-sm btn-outline border-gray-300">
                &larr; Kembali
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 flex flex-col">
                
                {{-- View Dokumen --}}
                <div class="card w-full bg-base-100 shadow-sm border border-gray-200 flex-grow min-h-[650px] flex flex-col overflow-hidden">
                    {{-- LOGIKA DOC VIEWER (Ditaruh langsung di bawah card, tanpa div tambahan) --}}
                    @php
                        $extension = strtolower(pathinfo($letter->file_path, PATHINFO_EXTENSION));
                        $fileUrl = route('surat.file', $letter->id);
                    @endphp

                    <div class="flex-grow w-full h-full flex flex-col items-center justify-center bg-gray-200/50 relative">
                        @if($extension === 'pdf')
                            <iframe 
                                src="{{ $fileUrl }}#toolbar=1&view=FitH" 
                                class="w-full h-full min-h-[600px] border-none"
                                title="PDF Viewer">
                            </iframe>
                        @elseif(in_array($extension, ['jpg', 'jpeg', 'png']))
                            <div class="w-full h-full overflow-auto flex justify-center p-4">
                                <img src="{{ $fileUrl }}" alt="Preview Surat" class="max-w-full h-auto object-contain shadow-sm border border-gray-300">
                            </div>
                        @else
                            <div class="text-center text-gray-500 p-8">
                                <h3 class="text-lg font-bold text-gray-700">Pratinjau Tidak Tersedia</h3>
                                <p class="text-sm mb-6">Format <b>.{{ $extension }}</b> tidak didukung viewer browser.</p>
                                <a href="{{ $fileUrl }}" download class="btn btn-primary px-8">Unduh Dokumen</a>
                            </div>
                        @endif
                    </div>
                </div> 
            </div> 

            <div class="md:col-span-1 flex flex-col gap-4">
                
                {{-- Detail Informasi Surat --}}
                <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
                    <div class="card-body p-5">
                        <h3 class="card-title text-base text-[#102C57] border-b pb-2 mb-2">Informasi Surat</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-500 text-sm">Nomor</span>
                                <span class="font-semibold text-gray-800 text-sm text-right">{{ $letter->letter_number ?? '-' }}</span>
                            </div>
                            
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-500 text-sm">Jenis</span>
                                <span class="font-semibold text-primary text-sm text-right">{{ $letter->letterType->letter_type ?? '-' }}</span>
                            </div>

                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-500 text-sm">Tanggal</span>
                                <span class="font-semibold text-gray-800 text-sm text-right">
                                    {{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->format('d F Y') : '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-500 text-sm">Kloter</span>
                                <span class="font-semibold text-gray-800 text-sm text-right">{{ $letter->kloter ?? '-' }}</span>
                            </div>

                            @if($letter->start_date)
                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 mt-2">
                                <span class="text-blue-700 text-xs block font-medium">Masa Berlaku PKS</span>
                                <span class="font-bold text-blue-900 text-sm">
                                    {{ \Carbon\Carbon::parse($letter->start_date)->format('d/m/Y') }} 
                                    &mdash; 
                                    {{ \Carbon\Carbon::parse($letter->end_date)->format('d/m/Y') }}
                                </span>
                            </div>
                            @endif

                            <div class="mt-3">
                                <span class="text-gray-500 text-xs block mb-1">Perihal / Keterangan</span>
                                <p class="text-gray-800 text-sm bg-gray-50 p-3 rounded-md border border-gray-100 min-h-[3rem]">
                                    {{ $letter->information ?? 'Tidak ada keterangan.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Daftar OPD --}}
                <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
                    <div class="card-body p-5">
                        <h3 class="card-title text-base text-[#102C57] border-b pb-2 mb-2">Tujuan OPD</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="table table-xs table-zebra w-full">
                                <thead class="bg-gray-100 text-gray-600">
                                    <tr>
                                        <th class="w-8">No</th>
                                        <th>Perangkat Daerah</th>
                                        <th>P1</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($letter->opds as $index => $opd)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="whitespace-normal">
                                            <div class="font-medium text-gray-800 leading-tight">{{ $opd->name }}</div>
                                            <div class="text-[10px] text-gray-500 mt-0.5">{{ $opd->regency->name ?? '-' }}</div>
                                        </td>
                                        <td>
                                            @if($opd->pivot->p1Type)
                                                <span class="badge badge-sm badge-outline badge-info text-[10px]">
                                                    {{ $opd->pivot->p1Type->type_name }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-gray-500">Tidak ada data OPD.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Informasi Sistem --}}
                <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
                    <div class="card-body p-5">
                        <h3 class="card-title text-base text-[#102C57] border-b pb-2 mb-2">Sistem</h3>
                        <div class="text-sm space-y-2 text-gray-600">
                            <div class="flex justify-between">
                                <span>Diunggah Oleh:</span>
                                <span class="font-medium">{{ $letter->uploader->name ?? 'Sistem' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Waktu Unggah:</span>
                                <span class="font-medium">{{ $letter->created_at->format('d/m/Y H:i:s') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>
@endsection