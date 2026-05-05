<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\Opd;
use App\Models\Province;
use App\Models\Regency;
use App\Models\ActivityLog;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PKSController extends Controller
{
    use FileUploadTrait;

    public function create()
    {
        $provinces = Province::all();
        return view('pages.uploads.upload-pks', compact('provinces'));
    }

    public function store(Request $request)
    {
        $letter_type_id = 23; // hardcoded karena hanya 1 tipe

        $request->validate([
            'start_date'     => 'required|date',
            'end_date'     => 'required|date',
            'file_surat'     => 'required|mimes:pdf,doc,docx,jpg,png|max:20480',
        ]);

        $fileData = $this->handleLetterUpload($request->file('file_surat'), $letter_type_id, $request->opd);

        $letters = Letter::create([
            'file_path'      => $fileData['file_path'],
            'file_name'      => $fileData['file_name'],
            'letter_type_id' => $letter_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'information' => $request->information,
            'uploaded_by' => Auth::id(),
        ]);

        $letters->opds()->attach($request->opd);

        $logRegencyId = null;
        if (!empty($allOpdIds)) {
            $firstOpdId = current($allOpdIds); 
            $firstOpd = \App\Models\Opd::find($firstOpdId);
            if ($firstOpd) {
                $logRegencyId = $firstOpd->regency_id; 
            }
        }

        // ==========================================
        // SAVE USER ACTIVITY LOG
        // ==========================================
        ActivityLog::create([
            'user_id'          => Auth::id(),
            'activity_type_id' => 1, // 1 = "membuat"
            'letter_type_id'   => $letter_type_id,
            'letter_id'        => $letters->id,
            'regency_id'       => $logRegencyId,
        ]);

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
