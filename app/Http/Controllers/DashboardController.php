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

        return view('dashboard', compact('totalSurat', 'totalIzinBaru', 'totalPerpanjangan', 'letters'));
    }
}
