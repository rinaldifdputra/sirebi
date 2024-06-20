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
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d'); // Mendapatkan tanggal hari ini

        // Mengambil semua data termasuk kolom asli
        $jam_praktek = T_JamPraktek::select('id', 'jam_mulai', 'jam_selesai')
            ->orderBy('jam_mulai', 'asc')
            ->get()
            ->map(function ($item) {
                $item->jam_praktek = $item->jam_mulai . '-' . $item->jam_selesai;
                return $item;
            });

        if ($user->role == 'Bidan') {
            $bidan = User::where('role', 'Bidan')->where('id', $user->id)->get();
            $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                ->withCount('reservasi_tetap') // Menghitung jumlah reservasi
                ->where(
                    'bidan_id',
                    $user->id
                )
                ->where('tanggal', '<', $today) // Menambahkan kondisi tanggal
                ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                ->orderBy('jam_praktek_id') // Mengurutkan berdasarkan jam praktek
                ->get();

            return view('praktek_bidan.index_history', compact('data', 'bidan', 'jam_praktek'));
        } elseif ($user->role == 'Admin') {
            $bidan = User::where('role', 'Bidan')->get();
            $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                ->withCount('reservasi_tetap') // Menghitung jumlah reservasi
                ->where('tanggal', '<', $today) // Menambahkan kondisi tanggal
                ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                ->orderBy('jam_praktek_id') // Mengurutkan berdasarkan jam praktek
                ->get();

            return view('praktek_bidan.index_history', compact('data', 'bidan', 'jam_praktek'));
        } elseif ($user->role == 'Pasien') {
            $pasien = $user->id;
            $bidan = User::where('role', 'Bidan')->get();
            $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                ->withCount(['reservasi_tetap' => function ($query) use ($pasien) {
                    $query->where('pasien_id', $pasien);
                }])
                ->whereHas('reservasi_tetap', function ($query) use ($pasien) {
                    $query->where('pasien_id', $pasien);
                })
                ->where('tanggal', '<', $today)
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam_praktek_id')
                ->get();

            return view('praktek_bidan.index_history', compact('data', 'bidan', 'jam_praktek'));
        }
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

        $today = Carbon::today()->format('Y-m-d'); // Mendapatkan tanggal hari ini

        if ($user->role == 'Bidan') {
            $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                ->withCount(['reservasi_tetap' => function ($query) {
                    $query->where('status', 'Tetap');
                }]) // Menghitung jumlah reservasi dengan status "Tetap"
                ->where('tanggal', '>=', $today) // Menambahkan kondisi tanggal
                ->where('bidan_id', $user->id)
                ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                ->orderBy('jam_praktek_id') // Mengurutkan berdasarkan jam praktek secara ascending
                ->get();
        } else {
            $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                ->withCount(['reservasi_tetap' => function ($query) {
                    $query->where('status', 'Tetap');
                }]) // Menghitung jumlah reservasi dengan status "Tetap"
                ->where('tanggal', '>=', $today) // Menambahkan kondisi tanggal
                ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                ->orderBy('jam_praktek_id') // Mengurutkan berdasarkan jam praktek secara ascending
                ->get();
        }

        // Inisialisasi variabel $reservasi jika user memiliki role 'Pasien'
        $reservasi = null;
        if ($user->role == 'Pasien') {
            // Cek apakah data reservasi tersedia untuk user saat ini
            foreach ($data as $jadwal) {
                if ($jadwal->reservasi_tetap_count > 0) {
                    $reservasi = $jadwal->reservasi_tetap->where('pasien_id', $user->id)->first();
                    break;
                }
            }
        }

        return view('praktek_bidan.index', compact('jam_praktek', 'bidan', 'today', 'data', 'reservasi'));
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
                'tanggal' => 'required|date_format:d-m-Y',
                'jam_praktek_id' => 'required|exists:t_jam_praktek,id',
                'bidan_id' => 'required|exists:users,id',
                'kuota' => 'required|integer|min:1',
            ]);

            $jadwal = new T_JadwalPraktek();
            $jadwal->id = Str::uuid();
            $jadwal->tanggal = Carbon::createFromFormat('d-m-Y', $request->tanggal);
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
                'tanggal' => 'required|date_format:d-m-Y',
                'jam_praktek_id' => 'required|exists:t_jam_praktek,id',
                'bidan_id' => 'required|exists:users,id',
                'kuota' => 'required|integer|min:1',
            ]);

            $jadwal = T_JadwalPraktek::findOrFail($id);
            $jadwal->tanggal = Carbon::createFromFormat('d-m-Y', $request->tanggal);
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
        $today = Carbon::today()->format('Y-m-d');

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
            ->where('tanggal', '>=', Carbon::today()->format('Y-m-d'))
            ->get()
            ->map(function ($jadwal) {
                // Menghitung jumlah reservasi dengan status "Tetap"
                // $jumlahReservasiTetap = $jadwal->reservasi()->where('status', 'Tetap')->count();
                $jumlahReservasiTetap = T_ReservasiBidan::where('jadwal_praktek_id', $jadwal->id)
                    ->where('status', 'Tetap')
                    ->count();

                // Menghitung sisa kuota
                $sisaKuota = $jadwal->kuota - $jumlahReservasiTetap;

                // Menambahkan atribut sisa kuota
                $jadwal->sisa_kuota = $sisaKuota;

                return $jadwal;
            });

        return view('jadwal_praktek.show', compact('jadwal', 'sisaKuota', 'pasien', 'reservasi', 'availableJadwalPraktek', 'today'));
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
