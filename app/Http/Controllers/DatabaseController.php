<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DatabaseController extends Controller
{
    public function index()
    {
        return view('pages.managements.db-management'); 
    }

    public function export()
    {
        // File dan folder tujuan
        $filename = "backup_db_" . date('Y-m-d_H-i-s') . ".sql";
        $storagePath = storage_path('app/backup');

        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        $filePath = $storagePath . '/' . $filename;

        $dbHost = env('DB_HOST');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbName = env('DB_DATABASE');

        // mysqldump
        $passwordArg = $dbPass ? "--password=\"{$dbPass}\"" : "";

        $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump.exe';

        $command = "\"{$mysqldumpPath}\" --user=\"{$dbUser}\" {$passwordArg} --host=\"{$dbHost}\" {$dbName} > \"{$filePath}\"";

        $returnVar = NULL;
        $output  = NULL;
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {

            $driveDPath = 'D:\Backup_SIREKAP';

            if (!File::exists($driveDPath)) {
                File::makeDirectory($driveDPath, 0755, true);
            }

            $driveDFilePath = $driveDPath . '\\' . $filename;

            File::copy($filePath, $driveDFilePath);

            return response()->download($filePath)->deleteFileAfterSend(true);
        } else {
            return back()->with('error', 'Gagal melakukan export database. Pastikan mysqldump tersedia di server.');
        }
    }

    public function import(Request $request)
    {
        // validasi harus format .sql
        $request->validate([
            'sql_file' => 'required|file|mimes:sql,txt' // Terkadang SQL terbaca sebagai TXT
        ]);

        $file = $request->file('sql_file');
        $filePath = $file->getRealPath();

        $dbHost = env('DB_HOST');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbName = env('DB_DATABASE');

        $passwordArg = $dbPass ? "--password=\"{$dbPass}\"" : "";

        $mysqlPath = 'C:\xampp\mysql\bin\mysql.exe';

        $command = "\"{$mysqlPath}\" --user=\"{$dbUser}\" {$passwordArg} --host=\"{$dbHost}\" {$dbName} < \"{$filePath}\"";

        $returnVar = NULL;
        $output  = NULL;
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            return back()->with('success', 'Database berhasil dipulihkan (Restore).');
        } else {
            return back()->with('error', 'Gagal memulihkan database. Periksa file SQL Anda.');
        }
    }
}
