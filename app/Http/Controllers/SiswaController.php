<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\KelasParalel;
use App\Models\Provinsi;
use App\Models\TahunAjaran;

class SiswaController extends Controller
{
    public function index()
    {
        //$siswa = Siswa::all();
        // Query custom menggunakan left join antara tabel siswa dan kelas
        $siswa = DB::table('siswa')
        ->leftJoin('kelas', 'siswa.KelasId', '=', 'kelas.id') // Menggabungkan berdasarkan id kelas
        ->leftJoin('kelasparalel', 'siswa.KelasParalelId', '=', 'kelasparalel.id')
        ->select('siswa.*', 'kelas.NamaKelas', 'kelasparalel.NamaKelasParalel') // Memilih kolom yang diinginkan
        ->get(); // Mengambil hasil query

        $kelas = Kelas::all(); // To populate a dropdown for Kelas
        $kelasParalel = KelasParalel::all(); // To populate a dropdown for KelasParalel

        $title = 'Delete Siswa!';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);

        return view("kesiswaan.Siswa", [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'kelasParalel' => $kelasParalel,
        ]);
    }

    public function updateKelas(Request $request)
{
    // Ambil data dari request
    $nisns = $request->input('nisns');
    $jenisKelas = $request->input('jenisKelas');
    $paralelKelas = $request->input('paralelKelas');

    // Validasi input
    $request->validate([
        'jenisKelas' => 'required',
        'paralelKelas' => 'required',
        'nisns' => 'required|array',
    ]);

    try {

    // Update kelas siswa
    Siswa::whereIn('NISN', $nisns)->update([
        'KelasID' => $jenisKelas,
        'KelasParalelID' => $paralelKelas
    ]);

    return response()->json(['message' => 'Kelas siswa berhasil diperbarui!']);
    return redirect('siswa');

} catch (\Throwable $th) {
    //Log::error("Data Siswa Save Error: ".$th->getMessage());
    alert()->error('Error', "EX Error: ".$th->getMessage());
    return redirect()->back()->withErrors($th->getMessage())->withInput();
}
}


    // Form for single record (Create or Update)
    public function Form($id = null)
    {
        $siswa = Siswa::where('NISN', $id)->get();
        $kelas = Kelas::all(); // To populate a dropdown for Kelas
        $kelasParalel = KelasParalel::all(); // To populate a dropdown for KelasParalel
        $provinsi = Provinsi::all();
        $tahunajaran = TahunAjaran::all();

        return view("kesiswaan.Siswa-Input", [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'kelasParalel' => $kelasParalel,
            'provinsi' => $provinsi,
            'tahunajaran' => $tahunajaran
        ]);
    }

    // Store New Record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NISN' => 'required|string|unique:siswa',
            'NIK' => 'required|string|unique:siswa',
            'PINAbsensi' => 'required|integer|unique:siswa',
            'NamaSiswa' => 'required|string',
            'JenisKelamin' => 'required|string',
            'TempatLahir' => 'required|string',
            'TanggalLahir' => 'required|date',
            'AlamatSiswa' => 'required|string',
            'ProvID' => 'required|integer',
            'KotaID' => 'required|integer',
            'KecID' => 'required|integer',
            'KelID' => 'required|integer',
            'KelasID' => 'required|integer|exists:kelas,id',
            'KelasParalelID' => 'integer|exists:kelasparalel,id',
            'Email' => 'required|email|unique:siswa',
            'NoHP' => 'required|numeric',
            'tahunajaran' => 'required|integer',
            'imageUpload' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Status' => 'required|string',
            'AlamatWali' => 'required|string',
            'WaliProvID' => 'required|integer',
            'WaliKotaID' => 'required|integer',
            'WaliKecID' => 'required|integer',
            'WaliKelID' => 'required|integer',
            'NamaWali' => 'required|string',
            'NoTlpWali' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', "Validator: ".$validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $fileName = '';
            //dd($request->hasFile('imageUpload'));
            if ($request->hasFile('imageUpload')) {
                $fileName = time() . '.' . $request->imageUpload->extension();
                $filePath = $request->file('imageUpload')->storeAs('uploads/siswa', $fileName, 'public');
                // $siswa->Foto = $filePath;
            }

            $siswa = new Siswa();
            $siswa->NISN = $request->input('NISN');
            $siswa->NIK = $request->input('NIK');
            $siswa->PINAbsensi = $request->input('PINAbsensi');
            $siswa->NamaSiswa = $request->input('NamaSiswa');
            $siswa->JenisKelamin = $request->input('JenisKelamin');
            $siswa->TempatLahir = $request->input('TempatLahir');
            $siswa->TanggalLahir = $request->input('TanggalLahir');
            $siswa->AlamatSiswa = $request->input('AlamatSiswa');
            $siswa->ProvID = $request->input('ProvID');
            $siswa->KotaID = $request->input('KotaID');
            $siswa->KecID = $request->input('KecID');
            $siswa->KelID = $request->input('KelID');
            $siswa->KelasID = $request->input('KelasID');
            $siswa->KelasParalelID = $request->input('KelasParalelID');
            $siswa->Email = $request->input('Email');
            $siswa->NoHP = $request->input('NoHP');
            $siswa->tempStore = Hash::make($request->input('NISN'));
            $siswa->tahunajaran = $request->input('tahunajaran');
            $siswa->Status = $request->input('Status');
            $siswa->NamaWali = $request->input('NamaWali');
            $siswa->HubunganWali = $request->input('HubunganWali');
            $siswa->AlamatWali = $request->input('AlamatWali');
            $siswa->WaliProvID = $request->input('WaliProvID');
            $siswa->WaliKotaID = $request->input('WaliKotaID');
            $siswa->WaliKecID = $request->input('WaliKecID');
            $siswa->WaliKelID = $request->input('WaliKelID');
            $siswa->NoTlpWali = $request->input('NoTlpWali');
            $siswa->Foto = $fileName;

            $siswa->save();

            alert()->success('Success', 'Data Siswa Berhasil disimpan.');
            return redirect('siswa');

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
            'NIK' => 'required|string',
            'PINAbsensi' => 'required|integer',
            'NamaSiswa' => 'required|string',
            'JenisKelamin' => 'required|string',
            'TempatLahir' => 'required|string',
            'TanggalLahir' => 'required|date',
            'AlamatSiswa' => 'required|string',
            'ProvID' => 'required|integer',
            'KotaID' => 'required|integer',
            'KecID' => 'required|integer',
            'KelID' => 'required|integer',
            'KelasID' => 'required|integer|exists:kelas,id',
            'KelasParalelID' => 'integer|exists:kelasparalel,id',
            'Email' => 'required|email',
            'NoHP' => 'required|numeric',
            'tahunajaran' => 'required|integer',
            'Foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Status' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $siswa = Siswa::where('NISN', $request->input('NISN'))->first();
            
            if ($siswa) {
                $siswa->update($request->except(['tempStore', 'Foto','NISN','_token']));
                //dd($request->Foto);
                if ($request->hasFile('Foto')) {
                    //dd($siswa->Foto);
                    if ($siswa->Foto) {
                        Storage::disk('public')->delete('uploads/siswa/' . $siswa->Foto);
                    }
                    $fileName = time() . '.' . $request->Foto->extension();
                    $filePath = $request->file('Foto')->storeAs('uploads/siswa', $fileName, 'public');
                    $siswa->Foto = $fileName;
                }

                $siswa->save();

                alert()->success('Success', 'Data Siswa berhasil disimpan.');
                return redirect('siswa');
            } else {
                alert()->error('Error', 'Siswa tidak ditemukan.');
                return redirect()->back()->withErrors('Siswa tidak ditemukan.')->withInput();
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
            $siswa = Siswa::findOrFail($id);
            if ($siswa->Foto) {
                Storage::disk('public')->delete($siswa->Foto);
            }
            $siswa->delete();

            alert()->success('Success', 'Delete Siswa berhasil.');
            return redirect('siswa');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
