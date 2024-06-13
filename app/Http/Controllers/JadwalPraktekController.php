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

class JadwalPraktekController extends Controller
{
    public function index(Request $request)
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

        if ($user->role == 'Admin') {
            $bidan = User::where('role', 'Bidan')->get();
        } else if ($user->role == 'Bidan') {
            $bidan = User::where('role', 'Bidan')->where('id', $user->id)->get();
        }

        if ($request->ajax()) {
            if ($user->role == 'Admin') {
                $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                    ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                    ->get();
            } else if ($user->role == 'Bidan') {
                $data = T_JadwalPraktek::with(['jam_praktek', 'bidan'])
                    ->where('bidan_id', $user->id)
                    ->orderBy('tanggal', 'desc')  // Mengurutkan berdasarkan kolom 'tanggal' secara descending
                    ->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('jam_praktek', function ($row) {
                    // Menggunakan accessor pada model T_JamPraktek
                    return $row->jam_praktek->jam_mulai . '-' . $row->jam_praktek->jam_selesai;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('jadwal_praktek.show', $row->id) . '" class="btn btn-info btn-sm"><i class="fa fa-search-plus"></i></a>  ';
                    $btn .= '<a href="' . route('jadwal_praktek.edit', $row->id) . '" class="edit btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>  ';
                    $btn .= '<button type="button" id="btnHapus" data-remote="' . route('jadwal_praktek.destroy', $row->id) . '" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('jadwal_praktek.index', compact('jam_praktek', 'bidan'));
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

            return redirect()->route('jadwal_praktek.index')->with('success', 'Jadwal praktek berhasil dibuat.');
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

            return redirect()->route('jadwal_praktek.index')->with('success', 'Jadwal praktek berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui jadwal praktek: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $jadwal = T_JadwalPraktek::findOrFail($id);
        $pasien = T_ReservasiBidan::where('jadwal_praktek_id', $id)->with('pasien')->get();

        return view('jadwal_praktek.show', compact('jadwal', 'pasien'));
    }

    public function getPasienByJadwal($id)
    {
        $pasien = T_ReservasiBidan::with(['jadwal_praktek', 'pasien'])
            ->where('jadwal_praktek_id', $id)
            ->get();

        return Datatables::of($pasien)
            ->addIndexColumn()
            ->addColumn('no_antrian', function ($row) {
                return $row->no_antrian;
            })
            ->addColumn('nama_pasien', function ($row) {
                return $row->pasien->nama_lengkap;
            })
            ->addColumn('tanggal_lahir', function ($row) {
                return $row->pasien->tanggal_lahir;
            })
            ->addColumn('jenis_kelamin', function ($row) {
                return $row->pasien->jenis_kelamin;
            })
            ->addColumn('no_hp', function ($row) {
                return $row->pasien->no_hp;
            })
            ->addColumn('action', function ($row) {
                // Add any actions you need for each row here
                return '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function destroy($id)
    {
        try {
            T_JadwalPraktek::destroy($id);
            return redirect()->route('jadwal_praktek.index')->with('success', 'Jadwal praktek berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus jadwal praktek: ' . $e->getMessage()]);
        }
    }
}
