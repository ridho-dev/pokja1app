<?php

namespace App\Http\Controllers;
use App\Models\Letter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() 
    {
        $totalSurat = Letter::count();

        $totalIzinBaru = DB::table('letter_opd')
            ->where('p1_type_id', 1)
            ->count();

        $totalPerpanjangan = DB::table('letter_opd')
            ->where('p1_type_id', 2)
            ->count();

        $letters = Letter::with(['opds', 'letterType', 'uploader'])
            ->latest()
            ->paginate(10);

        $recentActivities = Letter::with(['user', 'opds.regency'])
                              ->latest()
                              ->take(5)
                              ->get();

        $namaJenisSurat = [
            11  => 'Surat Masuk P1',
            12  => 'Surat Balasan P1',
            21  => 'Surat Masuk P2',
            22  => 'Surat Balasan P2',
            23  => 'Perjanjian Kerja Sama'
        ];

        return view('dashboard', compact('totalSurat', 'totalIzinBaru', 'totalPerpanjangan', 'letters', 'recentActivities', 'namaJenisSurat'));
    }
}
