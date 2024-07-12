<?php

namespace App\Http\Controllers;

use App\Models\T_Pekerjaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'Pasien')->get();

        return view('pasien.index', compact('users'));
    }

    public function create()
    {
        $pekerjaan = T_Pekerjaan::orderBy('nama_pekerjaan', 'ASC')->get();
        return view('pasien.create', compact('pekerjaan'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_lengkap' => 'required|string',
                'tanggal_lahir' => 'required|date_format:d-m-Y',
                'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
                'username' => 'required|string|unique:users',
                'password' => 'required|string',
                'no_hp' => 'required|string',
                'pekerjaan_id' => 'required|string',
            ]);

            $user = new User();
            $user->id = Str::uuid();
            $user->nama_lengkap = $request->nama_lengkap;
            $user->tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir);
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->no_hp = $request->no_hp;
            $user->role = 'Pasien';
            $user->pekerjaan_id = $request->pekerjaan_id;
            $user->created_by = Auth::id();
            $user->updated_by = Auth::id();
            $user->save();

            return redirect()->route('pasien.index')->with('success', 'Pasien berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat pasien: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $pekerjaan = T_Pekerjaan::orderBy('nama_pekerjaan', 'ASC')->get();
        return view('pasien.edit', compact('user', 'pekerjaan'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_lengkap' => 'required|string',
                'tanggal_lahir' => 'required|date_format:d-m-Y',
                'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
                'username' => 'required|string|unique:users,username,' . $id,
                'no_hp' => 'required|string',
                'pekerjaan_id' => 'required|string',
            ]);

            $user = User::findOrFail($id);
            $user->nama_lengkap = $request->nama_lengkap;
            $user->tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir);
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->username = $request->username;
            $user->no_hp = $request->no_hp;
            $user->pekerjaan_id = $request->pekerjaan_id;
            $user->updated_by = Auth::id();

            $user->save();

            return redirect()->route('pasien.index')->with('success', 'Pasien berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui pasien: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pasien.show', compact('user'));
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Cek relasi dengan tabel lain
            $hasRelations = $user->bidan()->exists() || $user->pasien()->exists() ||
                DB::table('t_jam_praktek')->where('created_by', $id)->orWhere('updated_by', $id)->exists() ||
                DB::table('t_jadwal_praktek')->where('created_by', $id)->orWhere('updated_by', $id)->orWhere('bidan_id', $id)->exists() ||
                DB::table('t_reservasi_bidan')->where('created_by', $id)->orWhere('updated_by', $id)->orWhere('pasien_id', $id)->exists();

            if ($hasRelations) {
                return back()->withErrors(['error' => 'Gagal menghapus pasien karena sudah digunakan pada data transaksi.']);
            }

            $user->delete();

            return redirect()->route('pasien.index')->with('success', 'pasien berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus pasien: ' . $e->getMessage()]);
        }
    }
}
