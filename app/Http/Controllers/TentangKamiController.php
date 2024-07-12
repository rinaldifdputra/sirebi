<?php

namespace App\Http\Controllers;

use App\Models\CMS_TentangKami;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TentangKamiController extends Controller
{
    public function index(Request $request)
    {
        $data = CMS_TentangKami::orderBy('judul', 'ASC')->get();

        // Teruskan data ke view
        return view('tentang_kami.index', compact('data'));
    }

    public function create()
    {
        return view('tentang_kami.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'alamat' => 'nullable|string|max:255',
                'telp' => 'nullable|string|max:15',
            ]);

            $cmsTentangKami = new CMS_TentangKami();
            $cmsTentangKami->id = Str::uuid();
            $cmsTentangKami->judul = $request->judul;
            $cmsTentangKami->deskripsi = $request->deskripsi;
            $cmsTentangKami->alamat = $request->alamat;
            $cmsTentangKami->telp = $request->telp;
            $cmsTentangKami->created_by = Auth::id();
            $cmsTentangKami->updated_by = Auth::id();
            $cmsTentangKami->save();

            return redirect()->route('tentang_kami.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $cmsTentangKami = CMS_TentangKami::findOrFail($id);
        return view('tentang_kami.edit', compact('cmsTentangKami'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'alamat' => 'nullable|string|max:255',
                'telp' => 'nullable|string|max:15',
            ]);

            $cmsTentangKami = CMS_TentangKami::findOrFail($id);
            $cmsTentangKami->judul = $request->judul;
            $cmsTentangKami->deskripsi = $request->deskripsi;
            $cmsTentangKami->alamat = $request->alamat;
            $cmsTentangKami->telp = $request->telp;
            $cmsTentangKami->updated_by = Auth::id();

            $cmsTentangKami->save();

            return redirect()->route('tentang_kami.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $cmsTentangKami = CMS_TentangKami::findOrFail($id);
        return view('tentang_kami.show', compact('cmsTentangKami'));
    }

    public function destroy($id)
    {
        try {
            $cmsTentangKami = CMS_TentangKami::findOrFail($id);

            CMS_TentangKami::destroy($id);
            return redirect()->route('tentang_kami.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
