@extends('layouts.app')

@section('title', 'Upload PKS')

@if ($errors->any())
    <div class="alert alert-error mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <div>
            <h3 class="font-bold">Gagal Menyimpan!</h3>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@section('content')
<div class="card bg-base-100 shadow-xl max-w-4xl mx-auto">
    <div class="card-body">
        <h2 class="card-title text-2xl font-bold mb-6 text-[#102C57]">Form Upload PKS</h2>

        {{-- Harus ada enctype="multipart/form-data" untuk upload file --}}
        <form action="{{ route('pks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf


            {{-- TIDAK DIGUNAKAN UNTUK SEMENTARA --}}
            {{-- <div class="form-control mb-6">
                <label class="label"><span class="label-text font-semibold">Jenis Surat</span></label>
                <select name="letter_type_id" id="letter_type" class="select select-bordered w-full" required onchange="checkLetterType(this.value)">
                    <option disabled selected value="">-- Pilih Jenis --</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->letter_type }}</option>
                    @endforeach
                </select>
            </div> --}}


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Provinsi</span></label>
                    <select name="province_id" id="province" class="select select-bordered w-full" onchange="loadRegencies(this.value)">
                        <option disabled selected>-- Pilih Provinsi --</option>
                        @foreach($provinces as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Kabupaten/Kota</span></label>
                    <select name="regency" id="regency" class="select select-bordered w-full" disabled onchange="loadOpds(this.value)">
                        <option disabled selected>-- Pilih Provinsi Terlebih Dahulu --</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">OPD</span></label>
                    <select name="opd" id="opd" class="select select-bordered w-full" disabled>
                        <option disabled selected>-- Pilih Kabupaten Terlebih Dahulu --</option>
                        
                    </select>
                </div>
            </div>

            <div class="divider"></div>

            <div id="extra-dates" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 mt-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Tanggal Mulai PKS</span></label>
                    <input type="date" name="start_date" id="start_date" class="input input-bordered w-full" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Tanggal Berakhir PKS</span></label>
                    <input type="date" name="end_date" id="end_date" class="input input-bordered w-full" />
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">File Dokumen (PDF/DOC)</span></label>
                    <input type="file" name="file_surat" class="file-input file-input-bordered w-full" required />
                    <label class="label"><span class="label-text-alt text-gray-500">*Maksimal 2MB</span></label>
                </div>
            </div>

            @if (session('success'))
                <div id="success-notification" class="alert alert-success mt-6 shadow-lg text-white transition-opacity duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <div>
                        <h3 class="font-bold">Berhasil!</h3>
                        <div class="text-sm">{{ session('success') }}</div>
                    </div>
                </div>
            @endif

            <div class="card-actions justify-end mt-8">
                <button type="submit" class="btn bg-[#102C57] text-white hover:bg-blue-900 px-8">Simpan Surat</button>
            </div>
        </form>
    </div>
</div>

<script>
    function loadRegencies(provinceId) {
        const regencySelect = document.getElementById('regency');
        const opdSelect = document.getElementById('opd');

        regencySelect.innerHTML = '<option value="">-- Loading... --</option>';
        regencySelect.disabled = true;

        if (!provinceId) {
            regencySelect.innerHTML = '<option value="">-- Pilih Kab/Kota Terlebih Dahulu --</option>';
            return;
        }

        console.log(provinceId)

        fetch(`/api/regencies/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                regencySelect.innerHTML = '<option disabled selected>-- Pilih Kabupaten --</option>';
                data.forEach(regency => {
                    regencySelect.innerHTML += `<option value="${regency.id}">${regency.name}</option>`;
                });
                regencySelect.disabled = false;
            });
    }

    function loadOpds(regencyId) {
        const opdSelect = document.getElementById('opd');
        opdSelect.innerHTML = '<option disabled selected>Loading...</option>';

        fetch(`/api/opds/${regencyId}`)
            .then(response => response.json())
            .then(data => {
                opdSelect.innerHTML = '<option disabled selected>-- Pilih OPD --</option>';
                data.forEach(opd => {
                    opdSelect.innerHTML += `<option value="${opd.id}">${opd.name}</option>`;
                });
                opdSelect.disabled = false;
            });
    }


</script>
@endsection