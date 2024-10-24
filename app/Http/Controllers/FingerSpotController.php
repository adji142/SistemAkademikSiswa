<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\MesinAbsensi;
use App\Models\Siswa;
use App\Models\AppSetting;
class FingerSpotController extends Controller
{
    function CreateUser(Request $request){
        $data = array('success' => false, 'message'=>'', 'data'=>array());
        $nisns = $request->input('nisns');

        try {
            $oMesin = MesinAbsensi::all();
            $oSetting = new AppSetting();

            foreach ($oMesin as $key) {
                $oDataDetail = array();
                
                $oSiswa = Siswa::whereIn('NISN', $nisns)->get();
                foreach ($oSiswa as $siswa) {
                    $textCount = strlen($siswa->NamaSiswa);

                    $oParam = [
                        'trans_id' => strval($siswa->PINAbsensi),
                        'cloud_id' => $key->CloudKey,
                        'data' => [
                            'pin' => strval($siswa->PINAbsensi),
                            'name' => substr($siswa->NamaSiswa, 0, ($textCount > 10) ? 10 : $textCount), 
                            'privilege' => '1',
                            'password' => strval($siswa->PINAbsensi),
                            'template' => ''
                        ]
                    ];

                    // Saving
                    $url = $oSetting->BaseURL()."set_userinfo";
                    $response = Http::withToken($key->APIToken)->post($url, $oParam);
                    // var_dump($response->json());
                    if ($response->successful()) {
                        $oResponseData = $response->json();

                        if ($oResponseData["success"] == false) {
                            $data['success'] = false;
                            $data['data'] = "Siswa ".substr($siswa->NamaSiswa, 0, ($textCount > 10) ? 10 : $textCount). "Gagal diupload, karena ". $oResponseData["message"] ;

                            goto jump;
                        }
                        $data['success'] = true;
                        $data['data'] = $oResponseData;

                        Siswa::where('NISN', $siswa->NISN)->update([
                            'isUploaded' => 1
                        ]);
                    }
                    else{
                        $data["success"] = false;
                        $data["message"] = "Gagal Membuat User Mesin Absensi";
                    }

                }
            }
jump:
        } catch (RedirectException $e) {
            $data["success"] = false;
            $data["message"] = $th->getMessage();
        }

        return response()->json($data);
    }
}
