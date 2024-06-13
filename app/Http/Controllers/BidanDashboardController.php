<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BidanDashboardController extends Controller
{
    public function index()
    {
        return view('bidan_dashboard.dashboard');
    }
}
