@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 flex justify-center">
    <div class="w-full max-w-3xl">
        
        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-[#102C57]">Edit Dokumen Surat</h2>
            <button onclick="history.back()" class="btn btn-sm btn-ghost border-gray-300">
                Batal & Kembali
            </button>
        </div>

        {{-- FORM CARD --}}
        <div class="card w-full bg-base-100 shadow-xl border border-gray-200">
            <div class="card-body p-6 md:p-8">
                
                {{-- Validation error message --}}
                @if ($errors->any())
                    <div class="alert alert-error text-white text-sm mb-6 rounded-lg p-3">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.update', $letter->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Nomor Surat --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium text-gray-700">Nomor Surat <span class="text-error">*</span></span></label>
                            <input type="text" name="letter_number" value="{{ old('letter_number', $letter->letter_number) }}" class="input input-bordered focus:outline-none focus:border-[#102C57] w-full" required />
                        </div>

                        {{-- Tanggal Surat --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium text-gray-700">Tanggal Surat <span class="text-error">*</span></span></label>
                            <input type="date" name="letter_date" value="{{ old('letter_date', $letter->letter_date) }}" class="input input-bordered focus:outline-none focus:border-[#102C57] w-full" required />
                        </div>

                        {{-- Kloter --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label"><span class="label-text font-medium text-gray-700">Kloter</span></label>
                            <input type="number" name="kloter" value="{{ old('kloter', $letter->kloter) }}" class="input input-bordered focus:outline-none focus:border-[#102C57] w-full" placeholder="Contoh: 1" />
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label"><span class="label-text font-medium text-gray-700">Keterangan / Perihal</span></label>
                            <textarea name="information" rows="4" class="textarea textarea-bordered focus:outline-none focus:border-[#102C57] w-full" placeholder="Masukkan keterangan surat...">{{ old('information', $letter->information) }}</textarea>
                        </div>

                        {{-- Upload File --}}
                        <div class="form-control w-full md:col-span-2 mt-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <label class="label pt-0"><span class="label-text font-bold text-[#102C57]">Ganti Dokumen (Opsional)</span></label>
                            
                            <p class="text-xs text-gray-500 mb-3">
                                File saat ini: <span class="font-semibold text-gray-700">{{ $letter->file_name ?? 'Tidak ada file' }}</span>
                                <br>
                                <span class="italic text-error">Biarkan kosong jika Anda tidak ingin mengubah dokumen ini.</span>
                            </p>
                            
                            <input type="file" name="file" class="file-input file-input-bordered file-input-sm w-full max-w-md focus:outline-none focus:border-[#102C57]" accept=".pdf,.jpg,.jpeg,.png" />
                        </div>

                    </div>

                    <div class="mt-8 pt-4 border-t border-gray-100 flex justify-between items-center">
                        {{-- Delete Button --}}
                        <button 
                            type="button" 
                            class="btn btn-error text-white"
                            onclick="showDeleteModal()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Surat
                        </button>

                        {{-- Save & Cancel Button --}}
                        <div class="flex gap-3">
                            <button type="button" onclick="history.back()" class="btn btn-ghost">Batal</button>
                            <button type="submit" class="btn bg-[#102C57] hover:bg-blue-900 text-white border-none px-8">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<form id="form-delete" action="{{ route('surat.destroy', $letter->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

{{-- MODAL DELETE CONFIRMATION --}}
<div id="delete-modal" class="fixed inset-0 bg-black/60 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity duration-300" onclick="closeOnBackdrop(event)">
    
    {{-- MODAL CARD --}}
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm mx-4 transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
        <div class="p-6">
            {{-- Warning Icon --}}
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-red-100 p-3 rounded-full flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
            </div>
            
            <p class="text-gray-600 text-sm mb-6">
                Apakah Anda yakin ingin menghapus dokumen surat ini? Aksi ini akan menghapus data dan dokumen fisik secara permanen dan tidak dapat dibatalkan.
            </p>
            
            <div class="flex justify-end gap-3">
                <button type="button" class="btn btn-sm btn-ghost text-gray-600" onclick="hideDeleteModal()">
                    Batal
                </button>
                <button type="button" class="btn btn-sm btn-error text-white px-6" onclick="submitDelete()">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('delete-modal');
    const modalInner = modal.querySelector('div'); 

    // Menampilkan Modal
    function showDeleteModal() {
        modal.classList.remove('hidden');
        // Animasi
        setTimeout(() => {
            modalInner.classList.remove('scale-95');
            modalInner.classList.add('scale-100');
        }, 10);
    }

    // Cancel Modal
    function hideDeleteModal() {
        modalInner.classList.remove('scale-100');
        modalInner.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }

    // Close on Backdrop
    function closeOnBackdrop(event) {
        if (event.target === modal) {
            hideDeleteModal();
        }
    }

    function submitDelete() {
        document.getElementById('form-delete').submit();
    }
</script>
@endsection