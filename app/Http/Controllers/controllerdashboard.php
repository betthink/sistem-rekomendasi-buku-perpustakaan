<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class controllerdashboard extends Controller
{
    //
    public function show()
    {
        return view('admin.dashboard.dashboard');
    }
}
