@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-0 mb-10">
    <div class="w-full max-w-screen-xl px-4 md:px-0 flex flex-col gap-6">
        
        {{-- TOMBOL KEMBALI --}}
        <div class="mt-4">
            <a href="javascript:history.back()" class="btn btn-sm btn-ghost pl-0 hover:bg-transparent text-gray-500 hover:text-[#102C57]">
                &larr; Kembali
            </a>
        </div>

        <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
            <div class="card-body p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                
                {{-- Info Utama --}}
                <div>
                    <h1 class="text-2xl font-bold text-[#102C57] mb-1">
                        {{ $opd->name ?? 'Nama Instansi OPD' }}
                    </h1>
                    <div class="flex items-center text-sm text-gray-500 gap-4">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            {{ $opd->regency->name ?? 'Kabupaten' }}, {{ $opd->regency->province->name ?? 'Provinsi' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            {{ $totalDokumen ?? 0 }} Dokumen Terunggah
                        </span>
                    </div>
                </div>

                {{-- Status & Periode --}}
                <div class="flex flex-col items-end gap-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
                    {{-- Status Badge Logic --}}
                    @if($statusOpd == 'Aktif')
                        <div class="badge badge-success text-white font-medium px-3 py-3 rounded-md">Aktif</div>
                        <div class="text-xs text-gray-500">
                            Periode: <span class="font-semibold text-gray-700">{{ $startDate }} s/d {{ $endDate }}</span>
                        </div>
                    @elseif($statusOpd == 'Tidak Aktif')
                        <div class="badge badge-error text-white font-medium px-3 py-3 rounded-md">PKS Berakhir</div>
                        <div class="text-xs text-error font-medium">Berakhir pada: {{ $endDate }}</div>
                    @else
                        <div class="badge bg-gray-200 text-gray-600 border-none font-medium px-3 py-3 rounded-md">Belum Aktif</div>
                        <div class="text-xs text-gray-400">Belum ada dokumen P2 yang diunggah</div>
                    @endif
                </div>

            </div>
        </div>

        <div class="space-y-6 mt-6">
            @forelse($groupedLetters as $idSurat => $suratList)
                
                {{-- Kelompok Jenis Surat --}}
                <div>
                    {{-- Judul Kategori --}}
                    <h3 class="text-lg font-bold text-[#102C57] mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" /></svg>
                        {{ $namaJenisSurat[$idSurat] ?? 'Dokumen Lainnya' }}
                    </h3>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex flex-col gap-3">
                            
                            @foreach($suratList as $surat)
                                <div class="card cursor-pointer bg-white border border-gray-200 hover:border-blue-400 hover:shadow-md transition-all duration-300" onclick="window.location.href='{{ route('surat.show', $surat->id) }}'">
                                    <div class="card-body py-2 px-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                                        <div>
                                            <h4 class="font-bold text-gray-800 text-md mb-1">
                                                {{ $surat->letter_number ?? 'Tanpa Nomor Surat' }}
                                            </h4>
                                        </div>

                                        {{-- Tombol Aksi --}}
                                        <div>
                                            <a href="#" class="btn btn-sm btn-outline text-blue-600 hover:bg-red-600 hover:text-white hover:border-red-600 px-6">
                                                Unduh
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            @empty
                {{-- ... Bagian kosong belum ada dokumen (Tetap seperti sebelumnya) ... --}}
            @endforelse
        </div>
</div>
@endsection