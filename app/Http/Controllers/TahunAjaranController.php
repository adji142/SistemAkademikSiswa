<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\TahunAjaran;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunajaran = TahunAjaran::all();

        $title = 'Delete Tahun Ajaran!';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        
        return view("master.GeneralSetting.TahunAjaran",[
            'tahunajaran' => $tahunajaran,
        ]);
    }

    // Form for single record (Create or Update)
    public function Form($id = null)
    {
        $tahunajaran = TahunAjaran::where('id', $id)->get();
        return view("master.GeneralSetting.TahunAjaran-Input", [
            'tahunajaran' => $tahunajaran
        ]);
    }

    // Store New Record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaTahunAjaran' => 'required|string',
            'TglAwal' => 'required|date',
            'TglSelesai' => 'required|date|after_or_equal:TglAwal',
        ]);
        
        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $tahunajaran = new TahunAjaran();
            $tahunajaran->NamaTahunAjaran = $request->input('NamaTahunAjaran');
            $tahunajaran->TglAwal = $request->input('TglAwal');
            $tahunajaran->TglSelesai = $request->input('TglSelesai');
            $tahunajaran->save();

            alert()->success('Success', 'Data Tahun Ajaran Berhasil disimpan.');
            return redirect('tahunajaran');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    // Update Record
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaTahunAjaran' => 'required|string',
            'TglAwal' => 'required|date',
            'TglSelesai' => 'required|date|after_or_equal:TglAwal',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $tahunajaran = TahunAjaran::find($request->input('id'));

            if ($tahunajaran) {
                $tahunajaran->update($request->only([
                    'NamaTahunAjaran', 
                    'TglAwal', 
                    'TglSelesai'
                ]));
                
                alert()->success('Success', 'Data Tahun Ajaran berhasil disimpan.');
                return redirect('tahunajaran');
            } else {
                alert()->error('Error', 'Tahun Ajaran tidak ditemukan.');
                return redirect()->back()->withErrors('Tahun Ajaran tidak ditemukan.')->withInput();
            }

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    // Delete Record
    public function destroy($id)
    {
        try {
            $tahunajaran = TahunAjaran::findOrFail($id);
            $tahunajaran->delete();

            alert()->success('Success', 'Delete Tahun Ajaran berhasil.');
            return redirect('tahunajaran');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
