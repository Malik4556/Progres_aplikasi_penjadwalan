<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboarddapController extends Controller
{
    public function index_dap() {

        $user = Auth::user();
        return view('dashboard_dap', ['user' => $user]);

    // public function index_dap(Request $request)
    // {
    //     $request->session()->flush();
    //     // dd('kd');
    }
}
