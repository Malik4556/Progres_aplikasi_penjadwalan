<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardkdController extends Controller
{
    public function index_kd()
    {

        $user = Auth::user();
        return view('dashboard_kd', ['user' => $user]);
    }

    // public function index_kd(Request $request)
    // {
    //     $request->session()->flush();
    //     // dd('kd');
    // }
}
