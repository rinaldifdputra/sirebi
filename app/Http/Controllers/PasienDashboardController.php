<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasienDashboardController extends Controller
{
    public function index()
    {
        return view('pasien_dashboard.dashboard');
    }
}
