@extends('layouts.app')

@section('content')
<div class="card bg-base-100 shadow-xl border border-gray-200">
    <div class="card-body">
        <h3 class="card-title text-error text-lg border-b pb-2">Manajemen Database</h3>
        
        @if (session('success'))
            <div class="alert alert-success shadow-sm mb-6 text-white rounded-lg flex items-center p-4 bg-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error shadow-sm mb-6 text-white rounded-lg flex items-center p-4 bg-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            
            {{-- AREA EXPORT --}}
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                <h4 class="font-bold text-[#102C57] mb-2">Backup Database</h4>
                <p class="text-sm text-gray-600 mb-4">Unduh seluruh isi database aplikasi beserta struktur tabelnya dalam format .sql.</p>
                <form action="{{ route('database.export') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm bg-[#102C57] hover:bg-blue-900 text-white w-full">
                        Mulai Export (.sql)
                    </button>
                </form>
            </div>

            {{-- AREA IMPORT --}}
            <div class="p-4 bg-red-50 rounded-lg border border-red-100">
                <h4 class="font-bold text-red-700 mb-2">Restore Database</h4>
                <p class="text-sm text-gray-600 mb-4">Peringatan: Melakukan import akan menimpa data yang ada saat ini. Pastikan file valid.</p>
                <form action="{{ route('database.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                    @csrf
                    <input type="file" name="sql_file" class="file-input file-input-bordered file-input-sm w-full file-input-error bg-white" accept=".sql" required />
                    <button type="submit" class="btn btn-sm btn-error text-white w-full" onclick="return confirm('Apakah Anda yakin ingin menimpa database saat ini? Aksi ini tidak dapat dibatalkan.')">
                        Mulai Import (.sql)
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
