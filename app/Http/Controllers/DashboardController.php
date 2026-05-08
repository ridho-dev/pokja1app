<?php

namespace App\Http\Controllers;
use App\Models\Letter;
use App\Models\ActivityLog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        
        $recentActivities = ActivityLog::with(['user', 'activityType', 'letterType', 'regency'])
            ->latest()
            ->take(6) // Ambil (n) aktivitas terbaru
            ->get();


        // ==========================================
        // BAGIAN PELAPORAN
        // ==========================================
        $today = Carbon::today()->toDateString();

        $totalPks = Letter::where('letter_type_id', 23)->count();

        // Menghitung PKS Aktif & Tidak (Hari ini >= start_date DAN Hari ini <= end_date)
        $pksAktif = Letter::where('letter_type_id', 23)
                        ->where('start_date', '<=', $today)
                        ->where('end_date', '>=', $today)
                        ->count();
        $pksTidakAktif = $totalPks - $pksAktif;

        // GRAFIK GARIS
        $chartLabels = [];
        $chartData = [];

        // Waktu 1 tahun terakhir
        $startDate = Carbon::now()->startOfMonth()->subMonths(11);
        
        $pksRecords = Letter::where('letter_type_id', 23)
            ->where('start_date', '>=', $startDate->toDateString())
            ->selectRaw('YEAR(start_date) as year, MONTH(start_date) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(function ($item) {
                // Format key menjadi "YYYY-MM" untuk pencocokan nanti
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            });

        // Loop 12 bulan untuk memastikan bulan yang kosong (0) tetap tampil di grafik
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->startOfMonth()->subMonths($i);
            $key = $date->format('Y-m'); // Format YYYY-MM
            
            // X : "Jun 2025", "Jul 2025"
            $chartLabels[] = $date->translatedFormat('M Y'); 
            
            // Y : Jumlah
            $chartData[] = isset($pksRecords[$key]) ? $pksRecords[$key]->count : 0;
        }

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

        // ==========================================
        // GRAFIK TREEMAP
        // ==========================================
        
        $provinceDistribution = DB::table('letters')
            ->join('letter_opd', 'letters.id', '=', 'letter_opd.letter_id') 
            ->join('opds', 'letter_opd.opd_id', '=', 'opds.id')
            ->join('regencies', 'opds.regency_id', '=', 'regencies.id')
            ->join('provinces', 'regencies.province_id', '=', 'provinces.id')
            ->where('letters.letter_type_id', 23)
            ->select('provinces.name as province_name', DB::raw('COUNT(DISTINCT letters.id) as total'))
            ->groupBy('provinces.id', 'provinces.name')
            ->get();

        // Format data menjadi array {x: 'Nama', y: Jumlah}
        $treemapData = $provinceDistribution->map(function($item) {
            return [
                'x' => ucwords(strtolower($item->province_name)),
                'y' => (int) $item->total
            ];
        });

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
            'totalPks', 
            'pksAktif', 
            'pksTidakAktif',
            'chartLabels',
            'chartData',
            'treemapData'
        ));
    }
}
