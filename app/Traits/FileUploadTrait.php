<?php

namespace App\Traits;

use App\Models\LetterType;
use App\Models\Opd;

trait FileUploadTrait
{
    public function handleLetterUpload($file, $letterTypeId, $opdData = [])
    {
        // Menentukan lokasi file
        $type = LetterType::findOrFail($letterTypeId);
        $forbidden = ['/', '\\', ':', '*', '?', '"', '<', '>', '|'];
        $folderPath = str_replace($forbidden, '-', $type->letter_type);

        // Menentukan penamaan file
        $extension = $file->getClientOriginalExtension();
        $opdArray = (array) $opdData;

        if (!empty($opdArray)) {
            $opdCount = count($opdArray);

            $firstOpd = Opd::findOrFail($opdArray)->first();

            $kabKotaName = $firstOpd->regency->name;

            if ($opdCount === 1) {
                $teksOpd = $firstOpd->name;
            } else {
                $teksOpd = "untuk {$opdCount} OPD";
            }

            $rawFileName = "{$type->letter_type} {$teksOpd} {$kabKotaName}";

            $cleanFileName = str_replace($forbidden, '-', $rawFileName);

            $timestamp = now()->format('Ymd_His');
            $storedFileName = "{$timestamp} {$cleanFileName}.{$extension}";
        } else {
            // Fallback: Jika controller tidak mengirim data OPD, pakai nama asli
            $storedFileName = $file->getClientOriginalName();
        }

        $path = $file->storeAs($folderPath, $storedFileName, 'main_storage');

        // Kembalikan data path dan nama file baru untuk disimpan ke DB
        return [
            'file_path' => $path,
            'file_name' => $storedFileName 
        ];
    }
}