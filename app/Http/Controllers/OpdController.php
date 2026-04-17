<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Regency;
use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function create()
    {
        $provinces = Province::all();
        return view('pages.managements.opd-management', compact('provinces'));
    }

    public function getRegencies($provinceId)
    {   
        return response()->json(Regency::where('province_id', $provinceId)->get());
    }

    public function getOpdByRegency($regency_id)
    {
        // Mengambil semua OPD di kabupaten tersebut, diurutkan secara alfabet
        $opds = Opd::where('regency_id', $regency_id)
                ->orderBy('name', 'asc')
                ->get(['id', 'name']);

        return response()->json($opds);
    }
}
