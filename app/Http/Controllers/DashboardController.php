<?php

namespace App\Http\Controllers;
use App\Models\Letter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() 
    {
        $totalSurat = Letter::count('*');

        $totalIzinBaru = DB::table('letter_opd')
            ->where('p1_type_id', 1)
            ->count();

        $totalPerpanjangan = DB::table('letter_opd')
            ->where('p1_type_id', 2)
            ->count();

        $letters = Letter::with(['opds', 'letterType', 'uploader'])
            ->latest()
            ->paginate(10);

        $recentActivities = Letter::with(['uploader', 'opds.regency'])
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

        // PROSES DATA GRAFIK

        $p1Types = DB::table('p1_types')->get();

        $selectQuery = "letters.kloter, COUNT(letter_opd.letter_id) as total";
        foreach ($p1Types as $type) {
            // Buat alias yang aman (huruf kecil, spasi diganti underscore)
            $alias = str_replace(' ', '_', strtolower($type->type_name));
            $selectQuery .= ", SUM(CASE WHEN letter_opd.p1_type_id = {$type->id} THEN 1 ELSE 0 END) as {$alias}";
        }

        $dataDatabase = DB::table('letters')
            ->join('letter_opd', 'letters.id', '=', 'letter_opd.letter_id')
            ->selectRaw($selectQuery)
            ->whereNotNull('letters.kloter')
            ->where('letters.letter_type_id', 12)
            ->groupBy('letters.kloter')
            ->get()
            ->keyBy('kloter');

        $labels = [];
        $dataTotal = [];
        $typeDetails = [];

        foreach ($p1Types as $type) {
            $alias = str_replace(' ', '_', strtolower($type->type_name));
            $typeDetails[$alias] = [
                'label' => $type->type_name,
                'data' => []
            ];
        }

        for ($i = 1; $i <= 10; $i++) {
            $labels[] = "Kloter $i";
            $item = $dataDatabase->get($i);
            
            $dataTotal[] = $item ? (int)$item->total : 0;
            
            // Isi data rincian secara dinamis
            foreach ($typeDetails as $alias => $config) {
                $typeDetails[$alias]['data'][] = $item ? (int)$item->$alias : 0;
            }
        }

        return view('dashboard', compact(
            'labels',
            'dataTotal',
            'typeDetails',
            'totalSurat', 
            'totalIzinBaru', 
            'totalPerpanjangan', 
            'letters', 
            'recentActivities', 
            'namaJenisSurat',
            'labels', 
        ));
    }
}
