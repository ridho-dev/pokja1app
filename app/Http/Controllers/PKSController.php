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

class PKSController extends Controller
{
    public function create()
    {
        $provinces = Province::all();
        return view('pages.upload-pks', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date'     => 'required|date',
            'end_date'     => 'required|date',
            'file_surat'     => 'required|mimes:pdf,doc,docx,jpg,png|max:20480',
        ]);

        // path?
        $letter_type_id = 23; // hardcoded karena hanya 1 tipe
        $letter_type = LetterType::findOrFail($letter_type_id);
        $forbidden = ['/', '\\', ':', '*', '?', '"', '<', '>', '|'];
        $cleanFolderName = str_replace($forbidden, '-', $letter_type->letter_type);
        $folderPath = "{$cleanFolderName}";

        $file = $request->file('file_surat');
        $originalName = $file->getClientOriginalName();
        $storedFileName = $originalName;

        $path = $file->storeAs($folderPath, $storedFileName, 'main_storage');

        $letters = Letter::create([
            'file_path' => $path,
            'file_name' => $originalName,
            'letter_type_id' => $letter_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'information' => $request->information,
            'uploaded_by' => Auth::id(),
        ]);

        $letters->opds()->attach($request->opd);


        return redirect()->back()->with('success', 'Data PKS berhasil diunggah!');
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
