<?php

namespace App\Http\Controllers;

use App\Models\T_JadwalPraktek;
use App\Models\T_JamPraktek;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Carbon\Carbon; // Pastikan Anda menambahkan ini di bagian atas file Anda

class WebsiteController extends Controller
{
    public function index()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
            ->withCount('reservasi') // Menghitung jumlah reservasi
            ->where('tanggal', '>=', $today)
            ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
            ->orderBy(T_JamPraktek::select('jam_mulai')
                ->whereColumn('t_jam_praktek.id', 't_jadwal_praktek.jam_praktek_id'))
            ->get()
            ->map(function ($item) {
                // Menghitung sisa kuota
                $item->sisa_kuota = $item->kuota - $item->reservasi_count;
                return $item;
            });

        return view('website.index', compact('data'));
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
