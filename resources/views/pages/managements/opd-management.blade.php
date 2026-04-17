@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-0 mb-10">
    <div class="w-full max-w-screen-xl px-4 md:px-0 flex flex-col gap-4">
        {{-- AREA HEADER & TOMBOL TAMBAH --}}
        <div class="flex items-center justify-between mt-4 mb-2">
            <div>
                <h2 class="text-2xl font-bold text-[#102C57]">Manajemen OPD</h2>
                <p class="text-sm text-gray-500">Kelola OPD terdaftar pada Database</p>
            </div>

            {{-- Tombol untuk membuka Modal Tambah User --}}
            <button onclick="modal_tambah_opd.showModal()" class="btn btn-sm bg-[#102C57] text-white hover:bg-blue-900 border-none shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah OPD
            </button>
        </div>

        
    </div>
</div>

<dialog id="modal_tambah_opd" class="modal">
    {{-- Memperlebar modal menjadi max-w-5xl agar muat 2 kolom dengan lega --}}
    <div class="modal-box bg-white max-w-5xl">
        <h3 class="font-bold text-lg text-[#102C57] border-b pb-3 mb-4">Tambah OPD Baru</h3>
    
        <form action="{{ route('opd.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-100">
                        {{-- Select Provinsi --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium text-gray-700">Provinsi <span class="text-error">*</span></span></label>
                            <select id="province_id" name="province_id" required class="select select-bordered w-full focus:outline-none focus:border-[#102C57]" onchange="loadRegencies(this.value)">
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Select Kabupaten --}}
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-gray-700">Kabupaten/Kota <span class="text-error">*</span></span></label>
                            {{-- Fungsi loadOpds akan dipanggil saat kabupaten dipilih --}}
                            <select name="regency_id" id="regency" class="select select-bordered w-full" disabled onchange="loadOpds(this.value)">
                                <option disabled selected>-- Pilih Provinsi Dulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="label px-0"><span class="label-text font-medium text-gray-700">Daftar Nama OPD <span class="text-error">*</span></span></label>
                        
                        <div id="opd_inputs_wrapper" class="space-y-3">
                            <div class="flex items-center gap-3">
                                <input type="text" disabled name="opd_names[]" id="first_opd_input" required placeholder="Contoh: Dinas Pendidikan" class="input input-bordered w-full focus:outline-none focus:border-[#102C57]" />
                                <button type="button" disabled class="btn btn-sm btn-square btn-ghost opacity-30 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btn_tambah_baris" disabled onclick="tambahBarisOpd()" class="btn btn-sm btn-ghost text-[#102C57] hover:bg-blue-50 mt-1 pl-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah OPD Lainnya
                    </button>

                    <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-2">
                        <button type="button" class="btn text-gray-500 hover:bg-gray-100 border-none" onclick="modal_tambah_opd.close()">
                            Batal
                        </button>
                        <button type="submit" class="btn bg-[#102C57] hover:bg-blue-900 text-white border-none px-8">
                            Simpan Data OPD
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-gray-50 rounded-lg p-4 border border-gray-100 h-full max-h-[500px] flex flex-col">
                    <h4 class="font-bold text-sm text-[#102C57] mb-3 flex items-center gap-2 border-b pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        OPD Terdaftar
                    </h4>
                    
                    {{-- Area ini akan diisi oleh Javascript --}}
                    <div id="existing_opd_list" class="overflow-y-auto flex-1 pr-2 space-y-2 text-sm text-gray-600">
                        <div class="text-center text-gray-400 italic mt-10">
                            Pilih Kabupaten/Kota terlebih dahulu untuk melihat daftar instansi.
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</dialog>


<script>
    let debounceTimer; // Mencegah server kebanjiran request setiap kali tombol ditekan
 
    function tambahBarisOpd() {
        const wrapper = document.getElementById('opd_inputs_wrapper');
        const barisBaru = document.createElement('div');
        barisBaru.className = 'flex items-center gap-3 transition-all duration-300 mt-3';
        barisBaru.innerHTML = `
            <input type="text" name="opd_names[]" required placeholder="Nama OPD lainnya..." class="input input-bordered w-full focus:outline-none focus:border-[#102C57]" />
            <button type="button" onclick="hapusBarisOpd(this)" class="btn btn-sm btn-square btn-outline btn-error shadow-sm" title="Hapus Baris">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        wrapper.appendChild(barisBaru);
    }

    function hapusBarisOpd(element) {
        element.parentElement.remove();
    }

    function loadOpds(regencyId) {
        let listContainer = document.getElementById('existing_opd_list');
        // Ambil elemen input dan tombol
        let firstInput = document.getElementById('first_opd_input');
        let btnTambah = document.getElementById('btn_tambah_baris');

        if(!regencyId) {
            // Kunci kembali jika tidak ada kabupaten
            firstInput.disabled = true;
            btnTambah.disabled = true;
            return;
        }

        // Buka kunci input dan tombol saat kabupaten dipilih
        firstInput.disabled = false;
        btnTambah.disabled = false;

        // Tampilkan status memuat
        listContainer.innerHTML = '<div class="flex justify-center mt-10"><span class="loading loading-spinner text-primary"></span></div>';

        // Hit ke API untuk mengambil data OPD berdasarkan regency_id
        fetch(`/api/opd/by-regency/${regencyId}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    listContainer.innerHTML = '<div class="text-center text-gray-400 italic mt-10">Belum ada instansi terdaftar di wilayah ini.</div>';
                    return;
                }

                // Render data ke dalam bentuk list
                let html = '<ul class="list-none space-y-2">';
                data.forEach(opd => {
                    html += `
                        <li class="p-2 bg-white border border-gray-100 rounded shadow-sm transition-colors">
                            ${opd.name}
                        </li>
                    `;
                });
                html += '</ul>';
                
                listContainer.innerHTML = html;
            })
            .catch(err => {
                listContainer.innerHTML = '<div class="text-red-500 text-center mt-10">Gagal memuat data.</div>';
            });
    }

    function loadRegencies(provinceId) {
        const regencySelect = document.getElementById('regency');

        // Kunci kembali input OPD saat provinsi diubah
        document.getElementById('first_opd_input').disabled = true;
        document.getElementById('btn_tambah_baris').disabled = true;
        document.getElementById('existing_opd_list').innerHTML = '<div class="text-center text-gray-400 italic mt-10">Pilih Kabupaten/Kota terlebih dahulu untuk melihat daftar instansi.</div>';
            
        // Ubah status dropdown Kabupaten menjadi Loading
        regencySelect.innerHTML = '<option disabled selected value="">Loading...</option>';
        regencySelect.disabled = true;
        console.log(provinceId)
        if (provinceId) {
            fetch(`/api/regencies/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    regencySelect.innerHTML = '<option disabled selected value="">-- Pilih Kabupaten --</option>';
                    data.forEach(regency => {
                        regencySelect.innerHTML += `<option value="${regency.id}">${regency.name}</option>`;
                    });
                    regencySelect.disabled = false;
                })
                .catch(error => console.error('Gagal mengambil data Kabupaten:', error));
        }
    }
</script>

@endsection