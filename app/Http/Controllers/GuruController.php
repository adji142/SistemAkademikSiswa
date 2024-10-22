<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::all();
        $kelas = Kelas::all(); // To populate a dropdown for Kelas
        $mapel = MataPelajaran::all(); // To populate a dropdown for MataPelajaran

        $title = 'Delete Guru!';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);

        return view("kesiswaan.Guru", [
            'guru' => $guru,
            'kelas' => $kelas,
            'mapel' => $mapel,
        ]);
    }

   
    // Form for single record (Create or Update)
    public function Form($id = null)
    {
        $guru = Guru::where('NIK', $id)->get();
        $kelas = Kelas::all(); // To populate a dropdown for Kelas
        $mapel = MataPelajaran::all();

        return view("kesiswaan.Guru-Input", [
            'guru' => $guru,
            'kelas' => $kelas,
            'mapel' => $mapel
        ]);
    }

    // Store New Record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NIK' => 'required|string|unique:guru',
            'NamaGuru' => 'required|string',
            'Email' => 'required|email|unique:guru',
            'NoHP' => 'required|numeric',
            'MapelID' => 'required|integer|exists:matapelajaran,id',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', "Validator: ".$validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
           
            $guru = new Guru();
            $guru->NIK = $request->input('NIK');
            $guru->NamaGuru = $request->input('NamaGuru');
            $guru->Email = $request->input('Email');
            $guru->NoHP = $request->input('NoHP');
            $guru->MapelID = $request->input('MapelID');

            $guru->save();

            alert()->success('Success', 'Data Guru Berhasil disimpan.');
            return redirect('guru');

        } catch (\Throwable $th) {
            //Log::error("Data Siswa Save Error: ".$th->getMessage());
            alert()->error('Error', "EX Error: ".$th->getMessage());
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    // Update Record
    public function edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'NIK' => 'required|string|unique:guru',
            'NamaGuru' => 'required|string',
            'Email' => 'required|email|unique:guru',
            'NoHP' => 'required|numeric',
            'KelasID' => 'required|integer|exists:kelas,id',
            'MapelID' => 'required|integer|exists:matapelajaran,id',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $guru = Guru::where('NIK', $request->input('NIK'))->first();
            
            if ($guru) {
                $guru->update($request->except(['NIK','_token']));
                //dd($request->Foto);
               

                $guru->save();

                alert()->success('Success', 'Data Guru berhasil disimpan.');
                return redirect('guru');
            } else {
                alert()->error('Error', 'Guru tidak ditemukan.');
                return redirect()->back()->withErrors('Guru tidak ditemukan.')->withInput();
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
            $guru = Guru::findOrFail($id);
          
            $guru->delete();

            alert()->success('Success', 'Hapus data Guru berhasil.');
            return redirect('guru');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
