<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all();

        $title = 'Delete Ruangan!';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);

        return view("master.GeneralSetting.Ruangan", [
            'ruangan' => $ruangan,
        ]);
    }

    // Form for single record (Create or Update)
    public function Form($id = null)
    {
        $ruangan = Ruangan::where('id', $id)->get();
        return view("master.GeneralSetting.Ruangan-Input", [
            'ruangan' => $ruangan
        ]);
    }

    // Store New Record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaRuangan' => 'required|string|unique:ruangan',
            'PenanggungJawab' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $ruangan = new Ruangan();
            $ruangan->NamaRuangan = $request->input('NamaRuangan');
            $ruangan->PenanggungJawab = $request->input('PenanggungJawab');
            $ruangan->save();

            alert()->success('Success', 'Data Ruangan Berhasil disimpan.');
            return redirect('ruangan');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    // Update Record
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaRuangan' => 'required|string',
            'PenanggungJawab' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $ruangan = Ruangan::find($request->input('id'));

            if ($ruangan) {
                $ruangan->update($request->only([
                    'NamaRuangan', 
                    'PenanggungJawab',
                ]));

                alert()->success('Success', 'Data Ruangan berhasil disimpan.');
                return redirect('ruangan');
            } else {
                alert()->error('Error', 'Ruangan tidak ditemukan.');
                return redirect()->back()->withErrors('Ruangan tidak ditemukan.')->withInput();
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
            $ruangan = Ruangan::findOrFail($id);
            $ruangan->delete();

            alert()->success('Success', 'Delete Ruangan berhasil.');
            return redirect('ruangan');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
