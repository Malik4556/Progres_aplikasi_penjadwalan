<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
    public function users()
    {
        $users = Users::all();
        return view('dashboard_dap', ['usersList' => $users]);
    }
}
