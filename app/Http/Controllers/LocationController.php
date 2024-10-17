<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class LocationController extends Controller
{
    public function getKota($provID)
    {
        try {
            $kota = Kota::where('prov_id', $provID)->get();
            return response()->json($kota);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getKecamatan($kotaID)
    {
        try {
            $kecamatan = Kecamatan::where('kota_id', $kotaID)->get();
            return response()->json($kecamatan);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getKelurahan($kecID)
    {
        try {
            $kelurahan = Kelurahan::where('kec_id', $kecID)->get();
            return response()->json($kelurahan);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
