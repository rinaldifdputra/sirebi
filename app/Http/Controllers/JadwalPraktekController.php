<?php

namespace App\Http\Controllers;

use App\Models\T_JadwalPraktek;
use App\Models\T_JamPraktek;
use App\Models\T_ReservasiBidan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon; // Pastikan Anda menambahkan ini di bagian atas file Anda

class JadwalPraktekController extends Controller
{
    public function index_history(Request $request)
    {
        // Mengambil semua data termasuk kolom asli
        $jam_praktek = T_JamPraktek::select('jam_mulai', 'jam_selesai')
            ->orderByRaw('concat(jam_mulai, jam_selesai)')
            ->get()
            ->map(function ($item) {
                $item->jam_praktek = $item->jam_mulai . '-' . $item->jam_selesai;
                return $item;
            });

        $user = Auth::user();

        if ($user->role == 'Bidan') {
            $bidan = User::where('role', 'Bidan')->where('id', $user->id)->get();
        } else {
            $bidan = User::where('role', 'Bidan')->get();
        }

        if ($request->ajax()) {
            if ($user->role == 'Bidan') {
                $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                    ->withCount('reservasi_tetap') // Menghitung jumlah reservasi
                    ->where('bidan_id', $user->id)
                    ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                    ->orderBy(T_JamPraktek::select('jam_mulai')
                        ->whereColumn('t_jam_praktek.id', 't_jadwal_praktek.jam_praktek_id')) // Mengurutkan berdasarkan jam praktek secara ascending
                    ->get();
            } else {
                $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                    ->withCount('reservasi_tetap') // Menghitung jumlah reservasi
                    ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                    ->orderBy(T_JamPraktek::select('jam_mulai')
                        ->whereColumn('t_jam_praktek.id', 't_jadwal_praktek.jam_praktek_id')) // Mengurutkan berdasarkan jam praktek secara ascending
                    ->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('jam_praktek', function ($row) {
                    // Menggunakan accessor pada model T_JamPraktek
                    return $row->jam_praktek->jam_mulai . '-' . $row->jam_praktek->jam_selesai;
                })
                ->addColumn('jumlah_reservasi', function ($row) {
                    $sisa_kuota = $row->kuota - $row->reservasi_tetap_count;
                    return $sisa_kuota; // Menampilkan sisa kuota
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('jadwal_praktek.show', $row->id) . '" class="btn btn-info btn-sm"><i class="fa fa-search-plus"></i></a>  ';
                    //$btn .= '<a href="' . route('jadwal_praktek.edit', $row->id) . '" class="edit btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>  ';
                    //$btn .= '<button type="button" id="btnHapus" data-remote="' . route('jadwal_praktek.destroy', $row->id) . '" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('praktek_bidan.index_history', compact('jam_praktek', 'bidan'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // Mengambil semua data termasuk kolom asli
        $jam_praktek = T_JamPraktek::select('jam_mulai', 'jam_selesai')
            ->orderByRaw('concat(jam_mulai, jam_selesai)')
            ->get()
            ->map(function ($item) {
                $item->jam_praktek = $item->jam_mulai . '-' . $item->jam_selesai;
                return $item;
            });

        if ($user->role == 'Bidan') {
            $bidan = User::where('role', 'Bidan')->where('id', $user->id)->get();
        } else {
            $bidan = User::where('role', 'Bidan')->get();
        }

        if ($request->ajax()) {
            $today = Carbon::today(); // Mendapatkan tanggal hari ini

            if ($user->role == 'Bidan') {
                $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                    ->withCount(['reservasi_tetap' => function ($query) {
                        $query->where('status', 'Tetap');
                    }]) // Menghitung jumlah reservasi dengan status "Tetap"
                    ->where('tanggal', '>=', $today) // Menambahkan kondisi tanggal
                    ->where('bidan_id', $user->id)
                    ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                    ->orderBy(T_JamPraktek::select('jam_mulai')
                        ->whereColumn('t_jam_praktek.id', 't_jadwal_praktek.jam_praktek_id')) // Mengurutkan berdasarkan jam praktek secara ascending
                    ->get();
            } else {
                $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                    ->withCount(['reservasi_tetap' => function ($query) {
                        $query->where('status', 'Tetap');
                    }]) // Menghitung jumlah reservasi dengan status "Tetap"
                    ->where('tanggal', '>=', $today) // Menambahkan kondisi tanggal
                    ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                    ->orderBy(T_JamPraktek::select('jam_mulai')
                        ->whereColumn('t_jam_praktek.id', 't_jadwal_praktek.jam_praktek_id')) // Mengurutkan berdasarkan jam praktek secara ascending
                    ->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('jam_praktek', function ($row) {
                    // Menggunakan accessor pada model T_JamPraktek
                    return $row->jam_praktek->jam_mulai . '-' . $row->jam_praktek->jam_selesai;
                })
                ->addColumn('jumlah_reservasi', function ($row) {
                    $sisa_kuota = $row->kuota - $row->reservasi_tetap_count;
                    return $sisa_kuota; // Menampilkan sisa kuota
                })
                ->addColumn('action', function ($row) use ($user) {
                    $reservasi = T_ReservasiBidan::where('jadwal_praktek_id', $row->id)
                        ->where('pasien_id', $user->id)
                        ->first();

                    if ($user->role == 'Pasien') {
                        if ($reservasi && $reservasi->status != 'Batal') {
                            $btn = '<a href="' . route('reservasi.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>  ';
                        } else {
                            $btn = '<a href="' . route('reservasi.create', $row->id) . '" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>  ';
                        }
                    } else {
                        $btn = '<a href="' . route('jadwal_praktek.show', $row->id) . '" class="btn btn-info btn-sm"><i class="fa fa-search-plus"></i></a>  ';
                        $btn .= '<a href="' . route('jadwal_praktek.edit', $row->id) . '" class="edit btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>  ';
                        $btn .= '<button type="button" id="btnHapus" data-remote="' . route('jadwal_praktek.destroy', $row->id) . '" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('praktek_bidan.index', compact('jam_praktek', 'bidan'));
    }

    public function create()
    {
        $jam_praktek = T_JamPraktek::orderByRaw('concat(jam_mulai, jam_selesai)')->get();
        $user = Auth::user();

        if ($user->role == 'Admin') {
            $bidan = User::where('role', 'Bidan')->get();
        } else if ($user->role == 'Bidan') {
            $bidan = User::where('role', 'Bidan')->where('id', $user->id)->get();
        }

        return view('jadwal_praktek.create', compact('jam_praktek', 'bidan'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'tanggal' => 'required|date',
                'jam_praktek_id' => 'required|exists:t_jam_praktek,id',
                'bidan_id' => 'required|exists:users,id',
                'kuota' => 'required|integer|min:1',
            ]);

            $jadwal = new T_JadwalPraktek();
            $jadwal->id = Str::uuid();
            $jadwal->tanggal = $request->tanggal;
            $jadwal->jam_praktek_id = $request->jam_praktek_id;
            $jadwal->bidan_id = $request->bidan_id;
            $jadwal->kuota = $request->kuota;
            $jadwal->created_by = Auth::id();
            $jadwal->updated_by = Auth::id();
            $jadwal->save();

            return redirect()->route('praktek_bidan.index')->with('success', 'Jadwal praktek berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat jadwal praktek: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $jadwal = T_JadwalPraktek::findOrFail($id);
        $jam_praktek = T_JamPraktek::orderByRaw('concat(jam_mulai, jam_selesai)')->get();
        $user = Auth::user();

        if ($user->role == 'Admin') {
            $bidan = User::where('role', 'Bidan')->get();
        } else if ($user->role == 'Bidan') {
            $bidan = User::where('role', 'Bidan')->where('id', $user->id)->get();
        }

        return view('jadwal_praktek.edit', compact('jadwal', 'jam_praktek', 'bidan'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal' => 'required|date',
                'jam_praktek_id' => 'required|exists:t_jam_praktek,id',
                'bidan_id' => 'required|exists:users,id',
                'kuota' => 'required|integer|min:1',
            ]);

            $jadwal = T_JadwalPraktek::findOrFail($id);
            $jadwal->tanggal = $request->tanggal;
            $jadwal->jam_praktek_id = $request->jam_praktek_id;
            $jadwal->bidan_id = $request->bidan_id;
            $jadwal->kuota = $request->kuota;
            $jadwal->updated_by = Auth::id();
            $jadwal->save();

            return redirect()->route('praktek_bidan.index')->with('success', 'Jadwal praktek berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui jadwal praktek: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $jadwal = T_JadwalPraktek::withCount(['reservasi_tetap' => function ($query) {
            $query->where('status', 'Tetap')->orWhere('status', 'Jadwal Ulang');
        }])->findOrFail($id);

        $sisaKuota = $jadwal->kuota - $jadwal->reservasi_tetap_count;

        // Fetch list of patients
        $pasien = User::where('role', 'Pasien')->get(); // Atau sesuai dengan model pasien Anda

        $reservasi = T_ReservasiBidan::with(['pasien', 'jadwal_praktek', 'jadwal_praktek.jam_praktek'])
            ->where('jadwal_praktek_id', $id)
            ->orderBy('no_antrian', 'ASC')
            ->get();

        $availableJadwalPraktek = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
            ->where('tanggal', '>=', now()->toDateString())
            ->get()
            ->map(function ($jadwal) {
                // Menghitung jumlah reservasi dengan status bukan "Tetap"
                $jumlahReservasi = $jadwal->reservasi()->where('status', '!=', 'Batal')->count();
                // Menghitung sisa kuota
                $sisaKuota = $jadwal->kuota - $jumlahReservasi;
                // Menambahkan atribut sisa kuota
                $jadwal->sisa_kuota = $sisaKuota;

                return $jadwal;
            });

        return view('jadwal_praktek.show', compact('jadwal', 'sisaKuota', 'pasien', 'reservasi', 'availableJadwalPraktek'));
    }

    public function destroy($id)
    {
        try {
            T_JadwalPraktek::destroy($id);
            return redirect()->route('praktek_bidan.index')->with('success', 'Jadwal praktek berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus jadwal praktek: ' . $e->getMessage()]);
        }
    }
}
