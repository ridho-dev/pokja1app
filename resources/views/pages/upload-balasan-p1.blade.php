@extends('layouts.app')

@section('title', 'Upload Surat')

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
        <h2 class="card-title text-2xl font-bold mb-6 text-[#102C57]">Form Upload Surat Balasan P1</h2>

        {{-- Harus ada enctype="multipart/form-data" untuk upload file --}}
        <form action="{{ route('balasanP1.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                    <select name="regency_id" id="regency" class="select select-bordered w-full" disabled onchange="loadOpds(this.value)">
                        <option disabled selected>-- Pilih Provinsi Dulu --</option>
                    </select>
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Izin Baru</span>
                    </label>                    
                    <select name="opd_baru_id[]" id="opdIzinBaru" class="w-full" multiple disabled required>
                        <option disabled selected value="">-- Pilih Kabupaten Dulu --</option>
                    </select>
                    <div class="mt-2">
                        <label class="cursor-pointer label justify-start gap-2">
                            <input type="checkbox" id="toggle-opd-baru" class="checkbox checkbox-sm" />
                            <span class="label-text">Pilih lebih dari 1 OPD</span>
                        </label>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">OPD Perpanjangan</span></label>                    
                    <select name="opd_perpanjangan_id[]" id="opdPerpanjangan" class="w-full" multiple disabled required>
                        <option disabled selected value="">-- Pilih Kabupaten Dulu --</option>
                    </select>
                    <div class="mt-2">
                        <label class="cursor-pointer label justify-start gap-2">
                            <input type="checkbox" id="toggle-opd-perpanjangan" class="checkbox checkbox-sm" />
                            <span class="label-text">Pilih lebih dari 1 OPD</span>
                        </label>
                    </div>
                </div>                
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-control" id="kloterInput">
                    <label class="label"><span class="label-text font-semibold">Kloter</span></label>
                    <input type="text" name="kloter" id="kloter" placeholder="1" class="input input-bordered w-full" />
                </div>
            </div>
            

            <div id="extra-dates" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 mt-4 hidden">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Tanggal Mulai PKS</span></label>
                    <input type="date" name="start_date" id="start_date" class="input input-bordered w-full" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Tanggal Berakhir PKS</span></label>
                    <input type="date" name="end_date" id="end_date" class="input input-bordered w-full" />
                </div>
            </div>

            <div class="divider"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Nomor Surat</span></label>
                    <input type="text" name="letter_number" placeholder="Contoh: 005/123/2026" class="input input-bordered w-full" required />
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Tanggal Surat</span></label>
                    <input type="date" name="letter_date" class="input input-bordered w-full" required />
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

{{-- SCRIPT JAVASCRIPT UNTUK DROPDOWN DINAMIS --}}
<script>

    let opdBaruTomSelect, opdPerpanjanganTomSelect;

    document.addEventListener("DOMContentLoaded", function() {
        
        // Konfigurasi Global TomSelect
        const tomConfig = {
            plugins: ['remove_button'],
            create: false,
            hideSelected: true, // <-- SOLUSI: Hilangkan opsi dari daftarnya sendiri setelah dipilih
            sortField: { field: "text", direction: "asc" },
            placeholder: "-- Pilih OPD --",
            maxItems: 1, 
            controlInput: '<input type="text" readonly>'
        };

        // FUNGSI INISIALISASI
        function initTomSelect(selectId, toggleId, baseName) {
            const selectEl = document.getElementById(selectId);
            const toggleEl = document.getElementById(toggleId);
            
            if (!selectEl) return null;

            const tsInstance = new TomSelect(selectEl, tomConfig);
            tsInstance.disable();

            // Pasang event listener untuk checkbox jika elemennya ada
            if (toggleEl) {
                toggleEl.addEventListener('change', (e) => toggleMode(e.target.checked, tsInstance, selectEl, baseName));
            }
            
            return tsInstance;
        }

        // menjalankan inisialisasi 
        opdBaruTomSelect = initTomSelect('opdIzinBaru', 'toggle-opd-baru', 'opd_baru_id');
        opdPerpanjanganTomSelect = initTomSelect('opdPerpanjangan', 'toggle-opd-perpanjangan', 'opd_perpanjangan_id');

        // fungsi untuk menghindari duplikasi data pada kedua kolom
        function syncMutualExclusion(source, target) {
            // Jika data dipilih pada kolom A, hapus dari kolom B
            source.on('item_add', (value) => target.removeOption(value));
            
            // sebaliknya
            source.on('item_remove', function(value) {
                target.addOption({ value: value, text: this.options[value].text });
            });
        }

        if (opdBaruTomSelect && opdPerpanjanganTomSelect) {
            syncMutualExclusion(opdBaruTomSelect, opdPerpanjanganTomSelect);
            syncMutualExclusion(opdPerpanjanganTomSelect, opdBaruTomSelect);
        }
    });

    // FUNGSI TOGGLE SINGLE/MULTIPLE
    function toggleMode(isMultiple, tsInstance, selectElement, baseName) {
        // Gunakan ternary operator agar lebih singkat
        selectElement.setAttribute('name', isMultiple ? baseName + '[]' : baseName); 
        tsInstance.settings.maxItems = isMultiple ? null : 1;
        tsInstance.settings.mode = isMultiple ? 'multi' : 'single';

        // Jika kembali ke Single, potong sisa pilihan dan sisakan 1 saja
        if (!isMultiple && tsInstance.items.length > 1) {
            const firstItem = tsInstance.items; // FIX: Tambahkan untuk mengambil data pertama
            tsInstance.clear(true);
            tsInstance.addItem(firstItem);
        }
        
        tsInstance.sync(); 
    }

    function checkLetterType(typeId) {
        const extraDatesDiv = document.getElementById('extra-dates');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        const kloterInput = document.getElementById('kloterInput');
        const multipleOPDCheckbox = document.getElementById('multipleOPDCheckbox');

        // Jika ID adalah 22, TAMPILKAN form tanggal
        if (typeId == 23) {
            extraDatesDiv.classList.remove('hidden'); // Hapus class hidden
            
            // Wajib diisi agar validasi browser jalan
            startDateInput.required = true;
            endDateInput.required = true;

            kloterInput.classList.add('hidden');
            multipleOPDCheckbox.classList.add('hidden');
        } else {
            // Jika ID 11, 12, 21, SEMBUNYIKAN form tanggal
            extraDatesDiv.classList.add('hidden'); // Tambah class hidden
            
            // Hapus wajib isi (biar form bisa disubmit meski kosong)
            startDateInput.required = false;
            endDateInput.required = false;
            
            // Reset nilai jika user ganti pilihan
            startDateInput.value = '';
            endDateInput.value = '';
        }
    }
    // Fungsi load Kabupaten saat Provinsi dipilih
    function loadRegencies(provinceId) {
        const regencySelect = document.getElementById('regency');
        
        // Ubah status dropdown Kabupaten menjadi Loading
        regencySelect.innerHTML = '<option disabled selected value="">Loading...</option>';
        regencySelect.disabled = true;

        // Bersihkan dan matikan kedua kotak Tom Select OPD karena provinsinya berubah
        if (opdBaruTomSelect) {
            opdBaruTomSelect.clear();
            opdBaruTomSelect.clearOptions();
            opdBaruTomSelect.disable();
        }
        if (opdPerpanjanganTomSelect) {
            opdPerpanjanganTomSelect.clear();
            opdPerpanjanganTomSelect.clearOptions();
            opdPerpanjanganTomSelect.disable();
        }

        // Panggil API untuk mengambil data Kabupaten
        if (provinceId) {
            fetch(`/api/regencies/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    regencySelect.innerHTML = '<option disabled selected value="">-- Pilih Kabupaten --</option>';
                    data.forEach(regency => {
                        regencySelect.innerHTML += `<option value="${regency.id}">${regency.name}</option>`;
                    });
                    regencySelect.disabled = false;
                })
                .catch(error => console.error('Gagal mengambil data Kabupaten:', error));
        }
    }

    function loadOpds(regencyId) {
        // Matikan dan kosongkan kedua kotak terlebih dahulu saat loading
        if (opdBaruTomSelect) {
            opdBaruTomSelect.clear();
            opdBaruTomSelect.clearOptions();
            opdBaruTomSelect.disable();
        }
        if (opdPerpanjanganTomSelect) {
            opdPerpanjanganTomSelect.clear();
            opdPerpanjanganTomSelect.clearOptions();
            opdPerpanjanganTomSelect.disable();
        }

        if (regencyId) {
            fetch(`/api/opds/${regencyId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        // Masukkan data ke dalam kedua Tom Select
                        data.forEach(opd => {
                            opdBaruTomSelect.addOption({value: opd.id, text: opd.name});
                            opdPerpanjanganTomSelect.addOption({value: opd.id, text: opd.name});
                        });
                        // Nyalakan kembali kotaknya
                        opdBaruTomSelect.enable();
                        opdPerpanjanganTomSelect.enable();
                    }
                })
                .catch(error => console.error('Gagal mengambil data OPD:', error));
        }
    }

    // Fungsi untuk menghilangkan notifikasi upload sukses
    document.addEventListener("DOMContentLoaded", function() {
        const notification = document.getElementById("success-notification");

        if (notification) {
            // Tambahkan event listener ke seluruh dokumen (halaman)
            document.addEventListener("click", function() {
                // Efek memudar sebelum hilang (opsional, biar halus)
                notification.style.opacity = '0';
                
                // Hapus elemen setelah transisi selesai (500ms)
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, { once: true }); // 'once: true' artinya event ini cuma jalan sekali lalu membuang dirinya sendiri (hemat memori)
        }
    });
</script>
@endsection