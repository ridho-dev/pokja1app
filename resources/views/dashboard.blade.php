@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex justify-center mt-10">
        
        <div class="card w-96 bg-base-100 shadow-xl border border-gray-200" x-data="{ terbuka: false }">
            
            <div class="card-body">
                <h2 class="card-title text-primary">Uji Coba Sistem</h2>
                <p>Klik tombol di bawah untuk mengetes Alpine.js</p>
                
                <div class="card-actions justify-end mt-4">
                    <button class="btn btn-primary" @click="terbuka = !terbuka">
                        <span x-text="terbuka ? 'Tutup Detail' : 'Buka Detail'"></span>
                    </button>
                </div>

                <div x-show="terbuka" x-transition class="mt-4">
                    <div class="alert alert-success text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Berhasil! Alpine & Daisy berjalan.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection