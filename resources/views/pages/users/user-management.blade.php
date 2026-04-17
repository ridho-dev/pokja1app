@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-0 mb-10">
    <div class="w-full max-w-screen-xl px-4 md:px-0 flex flex-col gap-4">
        
        {{-- AREA HEADER & TOMBOL TAMBAH --}}
        <div class="flex items-center justify-between mt-4 mb-2">
            <div>
                <h2 class="text-2xl font-bold text-[#102C57]">Manajemen Pengguna</h2>
                <p class="text-sm text-gray-500">Kelola hak akses dan data pegawai</p>
            </div>
            
            {{-- Tombol untuk membuka Modal Tambah User --}}
            <button onclick="modal_tambah_user.showModal()" class="btn btn-sm bg-[#102C57] text-white hover:bg-blue-900 border-none shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Pengguna
            </button>
        </div>

        {{-- AREA PESAN SUKSES / ERROR (Jika ada) --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm rounded-lg text-white text-sm py-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- AREA TABEL PENGGUNA --}}
        <div class="card w-full bg-base-100 shadow-sm border border-gray-200">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full text-sm">
                        <thead class="bg-gray-100 text-[#102C57]">
                            <tr>
                                <th class="w-10 text-center">No</th>
                                <th>Nama Pegawai</th>
                                <th>Username</th>
                                <th>NIP</th>
                                <th>Peran (Role)</th>
                                <th class="text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="font-medium text-gray-800">{{ $user->name }}</td>
                                <td>{{ $user->nip ?? '-' }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    {{-- Badge Role --}}
                                    @if($user->role_id === 1)
                                        <span class="badge badge-sm badge-primary badge-outline text-[10px]">Admin</span>
                                    @else
                                        <span class="badge badge-sm badge-ghost text-[10px]">User</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- Cegah admin menghapus dirinya sendiri --}}
                                    @if(Auth::id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Data yang dihapus tidak dapat dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <div class="tooltip tooltip-left" data-tip="Hapus Pengguna">
                                                <button type="submit" class="btn btn-xs btn-square bg-red-50 text-red-600 hover:!bg-red-600 hover:!text-white border-none transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-4 h-4">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <span class="text-[10px] text-gray-400 italic">Anda</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">Belum ada data pengguna.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<dialog id="modal_tambah_user" class="modal">
    <div class="modal-box bg-white">
        <h3 class="font-bold text-lg text-[#102C57] border-b pb-3 mb-4">Tambah Pengguna Baru</h3>
        
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                
                {{-- Input Nama --}}
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium text-gray-700">Nama Lengkap</span></label>
                    <input type="text" name="name" required placeholder="Masukkan nama lengkap" class="input input-bordered input-sm w-full focus:outline-none focus:border-[#102C57]" />
                </div>

                {{-- Input NIP --}}
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium text-gray-700">NIP <span class="text-gray-400 text-xs font-normal">(Opsional)</span></span></label>
                    <input type="number" name="nip" placeholder="Masukkan 18 digit NIP" class="input input-bordered input-sm w-full focus:outline-none focus:border-[#102C57]" />
                </div>

                {{-- Input Username (Pengganti Email) --}}
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium text-gray-700">Username</span></label>
                    <input type="text" name="username" required placeholder="Masukkan username unik" class="input input-bordered input-sm w-full focus:outline-none focus:border-[#102C57]" />
                </div>

                {{-- Input Password --}}
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium text-gray-700">Password Sementara</span></label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" minlength="8" class="input input-bordered input-sm w-full focus:outline-none focus:border-[#102C57]" />
                </div>

                {{-- Select Role --}}
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium text-gray-700">Peran Akses (Role)</span></label>
    
                    <select name="role_id" required class="select select-bordered select-sm w-full focus:outline-none focus:border-[#102C57]">
                        <option value="" disabled selected>Pilih Peran Akses</option>
                        
                        {{-- Looping data dari tabel roles --}}
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            
            <div class="modal-action mt-6">
                <button type="button" class="btn btn-sm btn-ghost" onclick="modal_tambah_user.close()">Batal</button>
                <button type="submit" class="btn btn-sm bg-[#102C57] hover:bg-blue-900 text-white border-none">Simpan Pengguna</button>
            </div>
        </form>
    </div>
    
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
@endsection