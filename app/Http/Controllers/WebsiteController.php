<?php

namespace App\Http\Controllers;

use App\Models\CMS_LayananKami;
use App\Models\CMS_TentangKami;
use App\Models\CMS_Testimoni;
use App\Models\T_JadwalPraktek;
use App\Models\T_JamPraktek;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Carbon\Carbon; // Pastikan Anda menambahkan ini di bagian atas file Anda

class WebsiteController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d'); // Mendapatkan tanggal hari ini
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

        $bidan = User::where('role', 'Bidan')->get();

        $tentang_kami = CMS_TentangKami::first();

        $testimoni = CMS_Testimoni::orderBy('created_at', 'DESC')->get();

        return view('website.index', compact('data', 'bidan', 'tentang_kami', 'testimoni'));
    }

    public function tentang_kami()
    {
        $bidan = User::where('role', 'Bidan')->get();

        $tentang_kami = CMS_TentangKami::first();

        return view('website.tentang_kami', compact('bidan', 'tentang_kami'));
    }

    public function layanan_kami()
    {
        $layanan_kami = CMS_LayananKami::all();
        return view('website.layanan_kami', compact('layanan_kami'));
    }

    public function hubungi_kami()
    {
        $tentang_kami = CMS_TentangKami::first();
        return view('website.hubungi_kami', compact('tentang_kami'));
    }
}
