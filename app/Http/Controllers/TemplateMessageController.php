<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\TemplateMessage;

class TemplateMessageController extends Controller
{
    public function index()
    {
        $TemplateMessage = TemplateMessage::all();

        $title = 'Delete Template Message!';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);

        return view("master.GeneralSetting.TemplateMessage", [
            'templatemessage' => $TemplateMessage,
        ]);
    }

    public function getKelas($id)
    {
        try {
            $TemplateMessage = TemplateMessage::where('id', $id)->get();
            return response()->json($TemplateMessage);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // Form for single record (Create or Update)
    public function Form($id = null)
    {
        $TemplateMessage = TemplateMessage::where('id', $id)->get();
        return view("master.GeneralSetting.TemplateMessage-Input", [
            'templatemessage' => $TemplateMessage
        ]);
    }

    // Store New Record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaTemplate' => 'required|string',
            'TemplateContent' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $TemplateMessage = new TemplateMessage();
            $TemplateMessage->NamaTemplate = $request->input('NamaTemplate');
            $TemplateMessage->TemplateContent = $request->input('TemplateContent');
            $TemplateMessage->IntervalHour = $request->input('IntervalHour');
            $TemplateMessage->CronJobScript = $request->input('CronJobScript');
            $TemplateMessage->save();

            alert()->success('Success', 'Data TemplateMessage Berhasil disimpan.');
            return redirect('templatemessage');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    // Update Record
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaTemplate' => 'required|string',
            'TemplateContent' => 'required|string',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $templatemessage = TemplateMessage::find($request->input('id'));

            if ($templatemessage) {
                $templatemessage->update($request->only([
                    'NamaTemplate',
                    'TemplateContent',
                    'IntervalHour',
                    'CronJobScript'
                ]));

                alert()->success('Success', 'Data TemplateMessage berhasil disimpan.');
                return redirect('templatemessage');
            } else {
                alert()->error('Error', 'Template Message tidak ditemukan.');
                return redirect()->back()->withErrors('Template Message tidak ditemukan.')->withInput();
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
            $TemplateMessage = TemplateMessage::findOrFail($id);
            $TemplateMessage->delete();

            alert()->success('Success', 'Delete Template Message berhasil.');
            return redirect('templatemessage');

        } catch (\Throwable $th) {
            alert()->error('Error', $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
