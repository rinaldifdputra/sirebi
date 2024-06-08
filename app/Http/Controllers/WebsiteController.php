<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('website.index');
    }

    public function about()
    {
        return view('website.about');
    }

    public function service()
    {
        return view('website.service');
    }

    public function contact()
    {
        return view('website.contact');
    }
}
