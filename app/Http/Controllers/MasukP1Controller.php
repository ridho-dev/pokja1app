<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterType;
use App\Models\Opd;
use App\Models\Province;
use App\Models\Regency;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasukP1Controller extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        
    }

    public function create() 
    {
        $provinces = Province::all();
        // Sementara: tidak semua types ditampilkan
        $types = LetterType::whereIn('id', [11, 12])->get(); 

        return view('pages.upload-masuk-p1', compact('provinces', 'types'));
    }

    public function store(Request $request)
    {
        $letter_type_id = 11;

        $request->validate([
            'letter_number'  => 'required|string|max:255',
            'letter_date'    => 'required|date',
            'kloter'         => 'nullable|string|max:255',
            'information'    => 'nullable|string',
            'file_surat'     => 'required|mimes:pdf,doc,docx,jpg,png|max:20480',
            
            // Validasi untuk OPD bertipe checkbox (array)
            'opd_baru_id'         => 'nullable|array', 
            'opd_baru_id.*'       => 'exists:opds,id',
            'opd_perpanjangan_id' => 'nullable|array', 
            'opd_perpanjangan_id.*'=> 'exists:opds,id',
        ]);

        // Cek duplikasi data
        $allOpdIds = array_merge(
            (array) $request->opd_baru_id, 
            (array) $request->opd_perpanjangan_id
        );

        $isDuplicate = Letter::where('letter_type_id', $letter_type_id)
            ->where('letter_number', $request->letter_number)
            ->whereHas('opds', function ($query) use ($allOpdIds) {
                // Mengecek duplikasi ke gabungan ID OPD
                $query->whereIn('opds.id', $allOpdIds);
            })
            ->exists(); // mengembalikan nilai true jika data ditemukan

        if ($isDuplicate) {
            // Jika duplikat, kembalikan user ke form dengan pesan error
            return back()
                ->withInput() // Mengembalikan isian form agar user tidak perlu mengetik ulang
                ->withErrors(['letter_number' => 'Gagal! Surat dengan Nomor dan tujuan OPD tersebut sudah pernah diunggah.']);
        }

        $fileData = $this->handleLetterUpload($request->file('file_surat'), $letter_type_id, $allOpdIds);


        $letters = Letter::create([
            'file_path' => $fileData['file_path'],
            'file_name' => $fileData['file_name'],
            'kloter' => $request->kloter,
            'letter_type_id' => $letter_type_id,
            'letter_number' => $request->letter_number,
            'letter_date' => $request->letter_date,
            'information' => $request->information,
            'uploaded_by' => Auth::id(),
        ]);

        $pivotData = [];

        // 1. Masukkan OPD Izin Baru (ID Tipe = 1)
        if ($request->has('opd_baru_id') && is_array($request->opd_baru_id)) {
            foreach ($request->opd_baru_id as $opdId) {
                $pivotData[$opdId] = ['p1_type_id' => 1]; 
            }
        }

        // 2. Masukkan OPD Perpanjangan (ID Tipe = 2)
        if ($request->has('opd_perpanjangan_id') && is_array($request->opd_perpanjangan_id)) {
            foreach ($request->opd_perpanjangan_id as $opdId) {
                $pivotData[$opdId] = ['p1_type_id' => 2]; 
            }
        }

        //Simpan ke database
        if (!empty($pivotData)) {
            $letters->opds()->attach($pivotData);
        }

        return back()->with('success', 'Surat berhasil diupload!');
    }

    public function getRegencies($provinceId)
    {   
        return response()->json(Regency::where('province_id', $provinceId)->get());
    }

    public function getOpds($regencyId)
    {
        return response()->json(Opd::where('regency_id', $regencyId)->get());
    }
}
