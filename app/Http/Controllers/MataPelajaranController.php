<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::all();

        $title = 'Delete Mata Pelajaran!';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);

        return view("master.GeneralSetting.MataPelajaran", [
            'mapel' => $mapel,
        ]);
    }

    public function getMapel($mapelID)
    {
        try {
            $mapel = MataPelajaran::where('id', $mapelID)->get();
            return response()->json($mapel);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // Form for single record (Create or Update)
    public function Form($id = null)
    {
        $mapel = MataPelajaran::where('id', $id)->get();
        return view("master.GeneralSetting.MataPelajaran-Input", [
            'mapel' => $mapel
        ]);
    }

    // Store New Record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaMataPelajaran' => 'required|string|unique:MataPelajaran',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $mapel = new MataPelajaran();
            $mapel->NamaMataPelajaran = $request->input('NamaMataPelajaran');
            $mapel->save();

            alert()->success('Success', 'Data Mata Pelajaran Berhasil disimpan.');
            return redirect('mapel');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    // Update Record
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaMataPelajaran' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $mapel = MataPelajaran::find($request->input('id'));

            if ($mapel) {
                $mapel->update($request->only([
                    'NamaMataPelajaran',
                ]));

                alert()->success('Success', 'Data Mata Pelajaran berhasil disimpan.');
                return redirect('mapel');
            } else {
                alert()->error('Error', 'Mata Pelajaran tidak ditemukan.');
                return redirect()->back()->withErrors('Mata Pelajaran tidak ditemukan.')->withInput();
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
            $mapel = MataPelajaran::findOrFail($id);
            $mapel->delete();

            alert()->success('Success', 'Delete Mata Pelajaran berhasil.');
            return redirect('mapel');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}

