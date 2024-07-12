<?php

namespace App\Http\Controllers;

use App\Models\CMS_Testimoni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TestimoniController extends Controller
{
    public function index(Request $request)
    {
        $testimonis = CMS_Testimoni::orderBy('created_at', 'DESC')->get();
        $users = User::where('role', 'Pasien')->orderBy('nama_lengkap', 'ASC')->pluck('nama_lengkap', 'id');

        return view('testimoni.index', compact('testimonis', 'users'));
    }

    public function create()
    {
        $users = User::where('role', 'Pasien')->orderBy('nama_lengkap', 'ASC')->pluck('nama_lengkap', 'id');
        return view('testimoni.create', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'pasien_id' => 'required|exists:users,id',
                'deskripsi' => 'required|string',
            ]);

            $cmsTestimoni = new CMS_Testimoni();
            $cmsTestimoni->id = Str::uuid();
            $cmsTestimoni->pasien_id = $request->pasien_id;
            $cmsTestimoni->deskripsi = $request->deskripsi;
            $cmsTestimoni->created_by = Auth::id();
            $cmsTestimoni->updated_by = Auth::id();
            $cmsTestimoni->save();

            return redirect()->route('testimoni.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $cmsTestimoni = CMS_Testimoni::findOrFail($id);
        $users = User::where('role', 'Pasien')->orderBy('nama_lengkap', 'ASC')->pluck('nama_lengkap', 'id');
        return view('testimoni.edit', compact('cmsTestimoni', 'users'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'pasien_id' => 'required|exists:users,id',
                'deskripsi' => 'required|string',
            ]);

            $cmsTestimoni = CMS_Testimoni::findOrFail($id);
            $cmsTestimoni->pasien_id = $request->pasien_id;
            $cmsTestimoni->deskripsi = $request->deskripsi;
            $cmsTestimoni->updated_by = Auth::id();
            $cmsTestimoni->save();

            return redirect()->route('testimoni.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $cmsTestimoni = CMS_Testimoni::findOrFail($id);
        return view('testimoni.show', compact('cmsTestimoni'));
    }

    public function destroy($id)
    {
        try {
            $cmsTestimoni = CMS_Testimoni::findOrFail($id);
            $cmsTestimoni->delete();

            return redirect()->route('testimoni.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
