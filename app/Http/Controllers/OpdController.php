<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Regency;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpdController extends Controller
{
    public function create()
    {
        $provinces = Province::all();
        return view('pages.managements.opd-management', compact('provinces'));
    }

    public function store(Request $request)
    {
        // Pada kode ini, penamaan id opd tidak auto increment
        // melainkan dengan format 4 digit pertama kode kabupaten, 4 digit terakhir nilai urutan sesuai kabupaten
        // contoh: 11010001 untuk opd provinsi aceh

        // Validasi Input
        $request->validate([
            'province_id' => 'required',
            'regency_id'  => 'required', 
            'opd_names'   => 'required|array|min:1',
            'opd_names.*' => 'required|string|max:255', 
        ], [
            'opd_names.*.required' => 'Ada kolom nama OPD yang masih kosong. Silakan isi atau hapus baris tersebut.',
        ]);

        // 4 digit pertama dari regency_id
        $prefixCode = str_pad($request->regency_id, 4, '0', STR_PAD_LEFT);

        // Cari OPD dengan ID tertinggi khusus di kabupaten terpilih
        $lastOpd = Opd::where('regency_id', $request->regency_id)
                    ->orderBy('id', 'desc')
                    ->first();

        // Tentukan angka awal urutan
        if ($lastOpd) {
            // Mengambil 4 digit terakhir dari ID tertinggi yang ditemukan
            $currentSequence = (int) substr($lastOpd->id, -4);
        } else {
            $currentSequence = 0;
        }

        $berhasilDisimpan = 0;

        // Looping untuk setiap nama OPD yang diinput
        foreach ($request->opd_names as $nama_opd) {
            $currentSequence++;
            // Format nomor urut menjadi 4 digit (misal: 0001, 0002)
            $urutanCode = str_pad($currentSequence, 4, '0', STR_PAD_LEFT);
            $customId = $prefixCode . $urutanCode;

            Opd::create([
                'id'         => $customId,
                'regency_id' => $request->regency_id,
                'name'       => $nama_opd,
                'created_by' => Auth::id(),
            ]);

            $berhasilDisimpan++;
        }

        return redirect()->route('opd.create')->with('success', "Sebanyak {$berhasilDisimpan} Instansi OPD berhasil ditambahkan ke database.");
    }

    public function getRegencies($provinceId)
    {   
        return response()->json(Regency::where('province_id', $provinceId)->get());
    }

    public function getOpdByRegency($regency_id)
    {
        // Mengambil semua OPD di kabupaten tersebut, diurutkan secara alfabet
        $opds = Opd::where('regency_id', $regency_id)
                ->orderBy('name', 'asc')
                ->get(['id', 'name']);

        return response()->json($opds);
    }
}
