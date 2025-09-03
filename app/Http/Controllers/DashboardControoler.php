<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardControoler extends Controller
{
    public function index(){
        return view('dashboard.dashboard');
    }
}
