<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\KelasParalel;
use App\Models\Kelas;

class KelasParalelController extends Controller
{
    public function index(Request $request)
    {
        // Get kelas_id from the request query parameters
    $kelas_id = $request->query('kelas_id');

    // If kelas_id is provided, filter by it; otherwise, get all records
    $kelasparalel = KelasParalel::selectRaw("kelasparalel.*, kelas.NamaKelas")
                    ->leftJoin('kelas','kelasparalel.kelas_id','=','kelas.id')
                    ->when($kelas_id, function ($query, $kelas_id) {
                        return $query->where('kelas_id', $kelas_id);
                    })
                    ->get();
    $kelas = Kelas::all();

    $title = 'Delete Kelas Paralel!';
    $text = "Are you sure you want to delete ?";
    confirmDelete($title, $text);

    return view("master.GeneralSetting.KelasParalel", [
        'kelasparalel' => $kelasparalel,
        'kelas' => $kelas
    ]);
    }

    // Form for single record (Create or Update)
    public function Form($id = null)
    {
        $kelasparalel = KelasParalel::where('id', $id)->get();
        $kelas = Kelas::all(); // To populate a dropdown or selection for related Kelas

        return view("master.GeneralSetting.KelasParalel-Input", [
            'kelasparalel' => $kelasparalel,
            'kelas' => $kelas
        ]);
    }

    // Store New Record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'NamaKelasParalel' => 'required|string|unique:kelasparalel',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kelasparalel = new KelasParalel();
            $kelasparalel->kelas_id = $request->input('kelas_id');
            $kelasparalel->NamaKelasParalel = $request->input('NamaKelasParalel');
            $kelasparalel->save();

            alert()->success('Success', 'Data Kelas Paralel Berhasil disimpan.');
            return redirect('kelas-paralel');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    // Update Record
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'NamaKelasParalel' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kelasparalel = KelasParalel::find($request->input('id'));

            if ($kelasparalel) {
                $kelasparalel->update($request->only([
                    'kelas_id', 
                    'NamaKelasParalel',
                ]));

                alert()->success('Success', 'Data Kelas Paralel berhasil disimpan.');
                return redirect('kelas-paralel');
            } else {
                alert()->error('Error', 'Kelas Paralel tidak ditemukan.');
                return redirect()->back()->withErrors('Kelas Paralel tidak ditemukan.')->withInput();
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
            $kelasparalel = KelasParalel::findOrFail($id);
            $kelasparalel->delete();

            alert()->success('Success', 'Delete Kelas Paralel berhasil.');
            return redirect('kelas-paralel');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
