<?php

namespace App\Http\Controllers;

use App\Models\T_Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PekerjaanController extends Controller
{
    public function index(Request $request)
    {
        $data = T_Pekerjaan::orderBy('nama_pekerjaan', 'ASC')->get();

        // Teruskan data ke view
        return view('pekerjaan.index', compact('data'));
    }

    public function create()
    {
        return view('pekerjaan.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_pekerjaan' => 'required|string',
            ]);

            $pekerjaan = new T_pekerjaan();
            $pekerjaan->id = Str::uuid();
            $pekerjaan->nama_pekerjaan = $request->nama_pekerjaan;
            $pekerjaan->created_by = Auth::id();
            $pekerjaan->updated_by = Auth::id();
            $pekerjaan->save();

            return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat Pekerjaan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $pekerjaan = T_pekerjaan::findOrFail($id);
        return view('pekerjaan.edit', compact('pekerjaan'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_pekerjaan' => 'required|string',
            ]);

            $pekerjaan = T_pekerjaan::findOrFail($id);
            $pekerjaan->nama_pekerjaan = $request->nama_pekerjaan;
            $pekerjaan->updated_by = Auth::id();

            $pekerjaan->save();

            return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui Pekerjaan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pekerjaan = T_pekerjaan::findOrFail($id);
        return view('pekerjaan.show', compact('pekerjaan'));
    }

    public function destroy($id)
    {
        try {
            $pekerjaan = T_pekerjaan::findOrFail($id);

            // Cek apakah ada jadwal praktek yang menggunakan Pekerjaan ini
            if ($pekerjaan->pasien()->exists()) {
                return back()->withErrors(['error' => 'Pekerjaan tidak bisa dihapus karena sudah digunakan dalam data pasien.']);
            }

            T_pekerjaan::destroy($id);
            return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus Pekerjaan: ' . $e->getMessage()]);
        }
    }
}
