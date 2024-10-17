<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Illuminate\Support\Facades\Validator;

use App\Models\MesinAbsensi;

class MesinAbsensiController extends Controller
{

    public function index()
    {
        $mesinabsensi = MesinAbsensi::all();

        $title = 'Delete Mesin Absensi!';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.GeneralSetting.MesinAbsensi",[
            'mesinabsensi' => $mesinabsensi, 
        ]);
    }

    // Fetch a single record
    public function Form($id = null)
    {
        $mesinabsensi = MesinAbsensi::where('id',$id)->get();
        return view("master.GeneralSetting.MesinAbsensi-Input",[
            'mesinabsensi' => $mesinabsensi
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'NamaMesin' => 'required|string',
            'SerialNumber' => 'required|string|unique:mesinabsensi',
            'ActivationCode' => 'required|string',
            'APIToken' => 'required|string',
            'CloudKey' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            alert()->error('Error',$validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $mesinAbsensi = new MesinAbsensi();
            $mesinAbsensi->NamaMesin = $request->input('NamaMesin');
            $mesinAbsensi->SerialNumber = $request->input('SerialNumber');
            $mesinAbsensi->ActivationCode = $request->input('ActivationCode');
            $mesinAbsensi->APIToken = $request->input('APIToken');
            $mesinAbsensi->CloudKey = $request->input('CloudKey');
            $mesinAbsensi->save();

            if ($mesinAbsensi) {
                alert()->success('Success','Data Mesin Absensi Berhasil disimpan.');
                return redirect('mesinabsensi');
                
            }else{
                alert()->error('Error',"Gagal Menyimpan Data Mesin Absensi");
                return redirect()->back()->withErrors("Gagal Menyimpan Data Mesin Absensi")->withInput();
            }
        } catch (\Throwable $th) {
            alert()->error('Error',$th->getMessage());
            // return redirect()->back();
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaMesin' => 'required|string',
            'SerialNumber' => 'required|string',
            'ActivationCode' => 'required|string',
            'APIToken' => 'required|string',
            'CloudKey' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            alert()->error('Error',$validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $model = MesinAbsensi::where('id','=',$request->input('id'));

            if ($model) {
                $update = DB::table('mesinabsensi')
                			->where('id','=', $request->input('id'))
                			->update(
                				[
                					'NamaMesin'=>$request->input('NamaMesin'),
                					'SerialNumber'=>$request->input('SerialNumber'),
                					'ActivationCode'=>$request->input('ActivationCode'),
                					'APIToken' => $request->input('APIToken'),
                                    'CloudKey' => $request->input('CloudKey')
                				]
                			);
                if ($update) {
                    alert()->success('Success','Data Mesin Absensi berhasil disimpan.');
                    return redirect('mesinabsensi');
                }else{
                    alert()->error('Error',"Gagal Menyimpan Data Mesin Absensi");
                    return redirect()->back()->withErrors("Gagal Menyimpan Data Mesin Absensi")->withInput();
                }
            }
        } catch (\Throwable $th) {
            alert()->error('Error',$th->getMessage());
            // return redirect()->back();
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $mesinabsensi = MesinAbsensi::findOrFail($id);
            $mesinabsensi->delete();

            if ($mesinabsensi) {
	        	alert()->success('Success','Delete Mesin Absensi berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Mesin Absensi Gagal.');
	        }
	        return redirect('mesinabsensi');
        } catch (\Throwable $th) {
            //throw $th;
            allert()->error('Error', $th->getMessage());
        }
    }
}
