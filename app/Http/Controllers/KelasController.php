<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();

        $title = 'Delete Kelas!';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);

        return view("master.GeneralSetting.Kelas", [
            'kelas' => $kelas,
        ]);
    }

    // Form for single record (Create or Update)
    public function Form($id = null)
    {
        $kelas = Kelas::where('id', $id)->get();
        return view("master.GeneralSetting.Kelas-Input", [
            'kelas' => $kelas
        ]);
    }

    // Store New Record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaKelas' => 'required|string|unique:kelas',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kelas = new Kelas();
            $kelas->NamaKelas = $request->input('NamaKelas');
            $kelas->save();

            alert()->success('Success', 'Data Kelas Berhasil disimpan.');
            return redirect('kelas');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    // Update Record
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaKelas' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kelas = Kelas::find($request->input('id'));

            if ($kelas) {
                $kelas->update($request->only([
                    'NamaKelas',
                ]));

                alert()->success('Success', 'Data Kelas berhasil disimpan.');
                return redirect('kelas');
            } else {
                alert()->error('Error', 'Kelas tidak ditemukan.');
                return redirect()->back()->withErrors('Kelas tidak ditemukan.')->withInput();
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
            $kelas = Kelas::findOrFail($id);
            $kelas->delete();

            alert()->success('Success', 'Delete Kelas berhasil.');
            return redirect('kelas');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
