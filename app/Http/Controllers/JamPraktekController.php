<?php

namespace App\Http\Controllers;

use App\Models\T_JamPraktek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JamPraktekController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data dari database, diurutkan berdasarkan concat(jam_mulai, jam_selesai)
        $data = T_JamPraktek::orderByRaw('concat(jam_mulai, jam_selesai)')->get();

        // Teruskan data ke view
        return view('jam_praktek.index', compact('data'));
    }

    public function create()
    {
        return view('jam_praktek.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'jam_mulai' => 'required|string',
                'jam_selesai' => 'required|string',
            ]);

            $jam_praktek = new T_JamPraktek();
            $jam_praktek->id = Str::uuid();
            $jam_praktek->jam_mulai = $request->jam_mulai;
            $jam_praktek->jam_selesai = $request->jam_selesai;
            $jam_praktek->created_by = Auth::id();
            $jam_praktek->updated_by = Auth::id();
            $jam_praktek->save();

            return redirect()->route('jam_praktek.index')->with('success', 'Jam praktek berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat jam praktek: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $jam_praktek = T_JamPraktek::findOrFail($id);
        return view('jam_praktek.edit', compact('jam_praktek'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'jam_mulai' => 'required|string',
                'jam_selesai' => 'required|string',
            ]);

            $jam_praktek = T_JamPraktek::findOrFail($id);
            $jam_praktek->jam_mulai = $request->jam_mulai;
            $jam_praktek->jam_selesai = $request->jam_selesai;
            $jam_praktek->updated_by = Auth::id();

            $jam_praktek->save();

            return redirect()->route('jam_praktek.index')->with('success', 'Jam praktek berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui jam praktek: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $jam_praktek = T_JamPraktek::findOrFail($id);
        return view('jam_praktek.show', compact('jam_praktek'));
    }

    public function destroy($id)
    {
        try {
            T_JamPraktek::destroy($id);
            return redirect()->route('jam_praktek.index')->with('success', 'Jam praktek berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus jam praktek: ' . $e->getMessage()]);
        }
    }
}
