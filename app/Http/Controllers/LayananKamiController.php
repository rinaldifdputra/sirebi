<?php

namespace App\Http\Controllers;

use App\Models\CMS_LayananKami;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LayananKamiController extends Controller
{
    public function index(Request $request)
    {
        $data = CMS_LayananKami::orderBy('nama_layanan', 'ASC')->get();

        // Teruskan data ke view
        return view('layanan_kami.index', compact('data'));
    }

    public function create()
    {
        return view('layanan_kami.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_layanan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
            ]);

            $cmsLayananKami = new CMS_LayananKami();
            $cmsLayananKami->id = Str::uuid();
            $cmsLayananKami->nama_layanan = $request->nama_layanan;
            $cmsLayananKami->deskripsi = $request->deskripsi;
            $cmsLayananKami->created_by = Auth::id();
            $cmsLayananKami->updated_by = Auth::id();
            $cmsLayananKami->save();

            return redirect()->route('layanan_kami.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $cmsLayananKami = CMS_LayananKami::findOrFail($id);
        return view('layanan_kami.edit', compact('cmsLayananKami'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_layanan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
            ]);

            $cmsLayananKami = CMS_LayananKami::findOrFail($id);
            $cmsLayananKami->nama_layanan = $request->nama_layanan;
            $cmsLayananKami->deskripsi = $request->deskripsi;
            $cmsLayananKami->updated_by = Auth::id();

            $cmsLayananKami->save();

            return redirect()->route('layanan_kami.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $cmsLayananKami = CMS_LayananKami::findOrFail($id);
        return view('layanan_kami.show', compact('cmsLayananKami'));
    }

    public function destroy($id)
    {
        try {
            CMS_LayananKami::destroy($id);
            return redirect()->route('layanan_kami.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
