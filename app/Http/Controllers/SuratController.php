<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterType;
use App\Models\Opd;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    public function index()
    {
        // Mengambil data surat beserta relasinya
        $letters = Letter::with(['opds', 'letterType', 'uploader'])
                        ->latest()
                        ->paginate(10);

        // Mengarahkan ke file blade (pastikan lokasinya sesuai)
        return view('pages.daftar-surat-p1', compact('letters'));
    }

    public function create() 
    {
        $provinces = Province::all();
        // Sementara: tidak semua types ditampilkan
        $types = LetterType::whereIn('id', [11, 12, 21, 22])->get(); 

        return view('pages.upload', compact('provinces', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_type_id' => 'required|exists:letter_types,id',
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

        $isDuplicate = Letter::where('letter_type_id', $request->letter_type_id)
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

        // Proses upload file
        if ($request->letter_type_id == 22) {
            $rules['start_date'] = 'required|date';
            $rules['end_date']   = 'required|date|after_or_equal:start_date';
        }

        // Membangun struktur folder
        // $province = Province::findOrFail($request->province_id);
        // $regency  = Regency::findOrFail($request->regency_id);
        // $opd      = Opd::findOrFail($request->opd_id);
        $type     = LetterType::findOrFail($request->letter_type_id);

        // // Membersihkan string
        $forbidden = ['/', '\\', ':', '*', '?', '"', '<', '>', '|'];
    
        // $folderProv = str_replace($forbidden, '-', $province->name);
        // $folderKab  = str_replace($forbidden, '-', $regency->name);
        // $folderOpd  = str_replace($forbidden, '-', $opd->name);
        $folderType = str_replace($forbidden, '-', $type->letter_type);

        $folderPath = "{$folderType}";

        $file = $request->file('file_surat');
        $originalName = $file->getClientOriginalName();
        $storedFileName = $originalName;

        $path = $file->storeAs($folderPath, $storedFileName, 'main_storage');


        $letters = Letter::create([
            'file_path' => $path,
            'file_name' => $originalName,
            'kloter' => $request->kloter,
            'letter_type_id' => $request->letter_type_id,
            'letter_number' => $request->letter_number,
            'letter_date' => $request->letter_date,
            'information' => $request->information,
            'uploaded_by' => Auth::id(),
            'start_date' => $request->start_date ?? null, // Simpan jika ada
            'end_date'   => $request->end_date ?? null,
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

        // Tambahkan masa PKS ke tabel OPD
        // if ($request->letter_type_id == 22) {
        //     $opd = Opd::find($request->opd_id);
        //     if ($opd) {
        //         $opd->update([
        //             'start_date' => $request->start_date,
        //             'end_date'   => $request->end_date,
        //         ]);
        //     }
        // }

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
