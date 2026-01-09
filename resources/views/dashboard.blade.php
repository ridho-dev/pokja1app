@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex justify-center mt-10">
        
        <div class="card w-96 bg-base-100 shadow-xl border border-gray-200" x-data="{ terbuka: false }">
            
            <div class="card-body">
                <h2 class="card-title text-primary">Halo, {{ Auth::user()->name }}!</h2>
                <p>Ini adalah halaman Dashboard. Saat ini masih dalam proses pengembangan.</p>
            </div>

        </div>
    </div>
@endsection