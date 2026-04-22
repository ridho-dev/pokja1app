@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-0 mb-10">
    <div class="w-full max-w-screen-md px-4 md:px-0 flex flex-col gap-4">
        
        {{-- TOMBOL KEMBALI --}}
        <div class="mt-4">
            <a href="javascript:history.back()" class="btn btn-sm btn-ghost pl-0 hover:bg-transparent text-gray-500 hover:text-[#102C57]">
                &larr; Kembali
            </a>
        </div>

        {{-- HEADER --}}
        <div class="flex flex-col mb-2">
            <h2 class="text-2xl font-bold text-[#102C57]">Pengaturan Profil</h2>
            <p class="text-sm text-gray-500">Perbarui informasi pribadi dan foto profil Anda.</p>
        </div>

        {{-- AREA PESAN --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm rounded-lg text-white text-sm py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- FORM UTAMA --}}
        <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
            <div class="card-body p-6">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    {{-- 2. INFORMASI DASAR --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Lengkap --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium text-gray-700">Nama Lengkap</span></label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="input input-bordered focus:outline-none focus:border-[#102C57] @error('name') border-error @enderror" required />
                            @error('name') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- 3. PASSWORD (OPSIONAL) --}}
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <h4 class="font-bold text-sm text-gray-700 mb-4 italic">Ganti Password (Kosongkan jika tidak ingin mengubah)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-xs">Password Baru</span></label>
                                <input type="password" name="password" class="input input-bordered input-sm focus:outline-none focus:border-[#102C57]" />
                                @error('password') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-xs">Konfirmasi Password</span></label>
                                <input type="password" name="password_confirmation" class="input input-bordered input-sm focus:outline-none focus:border-[#102C57]" />
                            </div>
                        </div>
                    </div>

                    {{-- 4. TOMBOL AKSI --}}
                    <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-3">
                        <button type="button" onclick="javascript:history.back()" class="btn btn-ghost">Batal</button>
                        <button type="submit" class="btn bg-[#102C57] hover:bg-blue-900 text-white border-none px-8">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
</script>
@endsection