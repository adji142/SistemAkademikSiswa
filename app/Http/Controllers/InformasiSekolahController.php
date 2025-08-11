<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\InformasiSekolah;
use App\Models\TemplateMessage;

class InformasiSekolahController extends Controller
{
    public function index()
    {
        $InformasiSekolah = InformasiSekolah::all();
        $template = TemplateMessage::all();

        $title = 'Delete Informasi Sekolah!';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);

        return view("master.GeneralSetting.InformasiSekolah", [
            'informasisekolah' => $InformasiSekolah,
            'template' => $template,
        ]);
    }

    // Update Record
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NPSN' => 'required|string',
            'NamaSekolah' => 'required|string',
            'AlamatSekolah' => 'required|string',
            'SKPendirianSekolah' => 'required|string',
            'TanggalSKPendirian' => 'required',
            'SKIzinOperasional' => 'required|string',
            'TanggalSKOperasional' => 'required',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $informasisekolah = InformasiSekolah::where('NPSN', $request->input('NPSN'))->first();

            if ($informasisekolah) {
                $update = DB::table('datasekolah')
                            ->where('NPSN','=', $request->input('NPSN'))
                            ->update(
                                [
                                    'NamaSekolah'=>$request->input('NamaSekolah'),
                					'AlamatSekolah'=>$request->input('AlamatSekolah'),
                					'SKPendirianSekolah'=>$request->input('SKPendirianSekolah'),
                					'TanggalSKPendirian' => $request->input('TanggalSKPendirian'),
                                    'SKIzinOperasional' => $request->input('SKIzinOperasional'),
                                    'TanggalSKOperasional' => $request->input('TanggalSKOperasional'),
                                    'TemplateAbsenMasuk' => $request->input('TemplateAbsenMasuk'),
                                    'TemplateAbsenKeluar' => $request->input('TemplateAbsenKeluar'),
                                    'NoHPPeneriaNotif' => $request->input('NoHPPeneriaNotif'),
                                    'TemplateAbsenMasukGuru' => $request->input('TemplateAbsenMasukGuru'),
                                    'TemplateAbsenKeluarGuru' => $request->input('TemplateAbsenKeluarGuru')
                                ]
                            );

                alert()->success('Success', 'Data Informasi Sekolah berhasil disimpan.');
                return redirect('informasisekolah');
            } else {
                alert()->error('Error', 'Template Message tidak ditemukan.');
                return redirect()->back()->withErrors('Template Message tidak ditemukan.')->withInput();
            }

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }
}
