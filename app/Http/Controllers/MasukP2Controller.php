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

class MasukP2Controller extends Controller
{
    public function index()
    {
        
    }

    public function create() 
    {
        $provinces = Province::all();
        // Sementara: tidak semua types ditampilkan
        $types = LetterType::whereIn('id', [21, 22])->get(); 

        return view('pages.upload-balasan-p2', compact('provinces', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_number'  => 'required|string|max:255',
            'letter_date'    => 'required|date',
            'information'    => 'nullable|string',
            'file_surat'     => 'required|mimes:pdf,doc,docx,jpg,png|max:20480',

            // Validasi untuk OPD bertipe checkbox (array)
            'opd_id'         => 'required|array', 
            'opd_id.*'       => 'exists:opds,id',
        ]);

        $isDuplicate = Letter::where('letter_type_id', $request->letter_type_id)
            ->where('letter_number', $request->letter_number)
            ->whereHas('opds', function ($query) use ($request) {
                $query->whereIn('opds.id', $request->opd_id);
            })
            ->exists(); // exists() akan mengembalikan nilai true jika data ditemukan

        if ($isDuplicate) {
            return back()
                ->withInput() // Mengembalikan isian form agar user tidak perlu mengetik ulang
                ->withErrors(['letter_number' => 'Gagal! Surat dengan Nomor dan tujuan OPD tersebut sudah pernah diunggah.']);
        }
        $letter_type_id = 21; // Surat masuk P2
        $type     = LetterType::findOrFail($letter_type_id);
        $forbidden = ['/', '\\', ':', '*', '?', '"', '<', '>', '|'];
        $folderType = str_replace($forbidden, '-', $type->letter_type);
        $folderPath = "{$folderType}";

        $file = $request->file('file_surat');
        $originalName = $file->getClientOriginalName();
        $storedFileName = $originalName;

        $path = $file->storeAs($folderPath, $storedFileName, 'main_storage');

        $letters = Letter::create([
            'file_path' => $path,
            'file_name' => $originalName,
            'letter_type_id' => $letter_type_id,
            'letter_number' => $request->letter_number,
            'letter_date' => $request->letter_date,
            'information' => $request->information,
            'uploaded_by' => Auth::id(),
        ]);

        if ($request->has('opd_id')) {
            // Kita siapkan wadah kosong
            $pivotData = [];
            
            // Kita ubah format array-nya agar database mau menerima
            foreach ($request->opd_id as $id) {
                $pivotData[$id] = ['p1_type_id' => null];
            }
            
            // Masukkan data beserta array null-nya ke tabel pivot
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
