<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterType;
use App\Models\Opd;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use App\Traits\FileUploadTrait;

class SuratController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        $letters = Letter::with(['opds', 'letterType', 'uploader'])
                        ->latest()
                        ->paginate(10);

        return view('pages.daftar-surat-p1', compact('letters'));
    }

    public function create() 
    {
        $provinces = Province::all();
        $types = LetterType::whereIn('id', [11, 12])->get(); 

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
                $query->whereIn('opds.id', $allOpdIds);
            })
            ->exists(); // mengembalikan nilai true jika data ditemukan

        if ($isDuplicate) {
            return back()
                ->withInput() // Mengembalikan isian form agar user tidak perlu mengetik ulang
                ->withErrors(['letter_number' => 'Gagal! Surat dengan Nomor dan tujuan OPD tersebut sudah pernah diunggah.']);
        }

        // Proses upload file
        if ($request->letter_type_id == 22) {
            $rules['start_date'] = 'required|date';
            $rules['end_date']   = 'required|date|after_or_equal:start_date';
        }
        $type     = LetterType::findOrFail($request->letter_type_id);
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

        // OPD Izin Baru (ID Tipe = 1)
        if ($request->has('opd_baru_id') && is_array($request->opd_baru_id)) {
            foreach ($request->opd_baru_id as $opdId) {
                $pivotData[$opdId] = ['p1_type_id' => 1]; 
            }
        }

        // OPD Perpanjangan (ID Tipe = 2)
        if ($request->has('opd_perpanjangan_id') && is_array($request->opd_perpanjangan_id)) {
            foreach ($request->opd_perpanjangan_id as $opdId) {
                $pivotData[$opdId] = ['p1_type_id' => 2]; 
            }
        }

        // Simpan ke database
        if (!empty($pivotData)) {
            $letters->opds()->attach($pivotData);
        }

        return back()->with('success', 'Surat berhasil diupload!');
    }

    public function show($id)
    {
        $letter = Letter::with(['letterType', 'opds.regency.province'])->findOrFail($id);
        
        return view('pages.details.detail-surat', compact('letter'));
    }

    public function viewFile($id)
    {
        $letter = Letter::findOrFail($id);

        // Cek keberadaan file
        if (!Storage::disk('main_storage')->exists($letter->file_path)) {
            abort(404, 'Maaf, File dokumen fisik tidak ditemukan di server.');
        }

        // Mengambil path absolut file di server (misal: C:/laragon/www/storage/...)
        $fullPath = Storage::disk('main_storage')->path($letter->file_path);

        // Gunakan response()->file()
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $letter->file_name . '"'
        ]);
    }

    public function edit($id)
    {
        $letter = Letter::findOrFail($id);

        return view('pages.managements.letter-update', compact('letter'));
    }

    public function update(Request $request, $id)
    {
        $letter = Letter::findOrFail($id);

        // Form input validation
        $request->validate([
            'letter_number' => 'required|string|max:255',
            'letter_date'   => 'required|date',
            'kloter'        => 'nullable|integer',
            'information'   => 'nullable|string',
            'file'          => 'nullable|file|mimes:pdf|max:5120', // Maksimal 5MB
        ]);

        // Update File
        // File name wont be updated; will stay same when it was created
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Old file path
            $oldFilePath = $letter->file_path;
            $oldFileName = $letter->file_name;
            
            // Old folder path
            $folderPath = dirname($oldFilePath);
            
            $extension = $file->getClientOriginalExtension();
            $nameWithoutExt = pathinfo($oldFileName, PATHINFO_FILENAME);
            $newFileName = $nameWithoutExt . '.' . $extension;

            // Delete old docs
            if ($oldFilePath && Storage::disk('main_storage')->exists($oldFilePath)) {
                Storage::disk('main_storage')->delete($oldFilePath);
            }

            $path = $file->storeAs($folderPath, $newFileName, 'main_storage');
            
            // Update database
            $letter->file_path = $path;
            $letter->file_name = $newFileName;
        }

        // Data update process
        $letter->letter_number = $request->letter_number;
        $letter->letter_date   = $request->letter_date;
        $letter->kloter        = $request->kloter;
        $letter->information   = $request->information;

        // User who updated the letter
        $letter->updated_by = Auth::id(); 
        
        $letter->save();

        return redirect()->route('surat.show', $letter->id)
                         ->with('success', 'Data surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Find surat by Id
        $letter = Letter::findOrFail($id);

        // Delete if Exist
        if ($letter->file_path && Storage::disk('main_storage')->exists($letter->file_path)) {
            Storage::disk('main_storage')->delete($letter->file_path);
        }

        // Delete pivot relation 
        $letter->opds()->detach();

        // Delete data
        $letter->delete();

        return redirect()->route('surat.index')
                         ->with('success', 'Dokumen surat berhasil dihapus secara permanen.');
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
