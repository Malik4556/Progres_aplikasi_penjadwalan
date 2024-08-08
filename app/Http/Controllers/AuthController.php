<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticating(Request $request){

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);



        if(Auth::attempt($credentials)) {
            if(Auth::user()->role_id == 1) {
                return redirect('dashboard_dap');
            }

            if(Auth::user()->role_id == 2) {
                return redirect('dashboard_kd');
            }


        }
        Session::flash('status', 'failed');
        Session::flash('message', 'Username Atau Password Salah');
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
