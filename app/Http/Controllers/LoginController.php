<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Roles;
use App\Models\PermissionRole;
use App\Models\UserRole;
use App\Models\Permission;
use App\Models\User;

class LoginController extends Controller
{
    public function login() {
        return view("auth.login");
    }
    public function action_login(Request $request)
    {
        try {
            $this->validate($request, [
                'email'=>'required',
                'password'=>'required',
            ]);

            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            // GetRecordOwnerID

            $RecordOwnerID = "";

            $user = User::where('email', '=', $request->input('email'))->first();

            if ($user) {
                if ($user->active == 'N') {
                    throw new \Exception('User tidak aktif !');
                    goto jump;
                }

                if (Auth::Attempt($data)) {
                    return redirect('dashboard');
                } else{
                    throw new \Exception('Email atau Password Salah');
                }
            } else{
                throw new \Exception('Email tidak ditemukan');
            }

            jump:

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->info('Info',$e->getMessage());
            return redirect()->back();
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        Auth::logout();
        return redirect('/');
    }
}
