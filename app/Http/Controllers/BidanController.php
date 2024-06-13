<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BidanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'Bidan')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('bidan.show', $row->id) . '" class="btn btn-info btn-sm"><i class="fa fa-search-plus"></i></a>  ';
                    $btn .= '<a href="' . route('bidan.edit', $row->id) . '" class="edit btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>  ';
                    $btn .= '<button type="button" id="btnHapus" data-remote="' . route('bidan.destroy', $row->id) . '" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('bidan.index');
    }

    public function create()
    {
        return view('bidan.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_lengkap' => 'required|string',
                'tanggal_lahir' => 'required|date_format:Y-m-d',
                'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
                'username' => 'required|string|unique:users',
                'password' => 'required|string',
                'no_hp' => 'required|string',
                'pekerjaan' => 'required|string',
            ]);

            $user = new User();
            $user->id = Str::uuid();
            $user->nama_lengkap = $request->nama_lengkap;
            $user->tanggal_lahir = Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir);
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->no_hp = $request->no_hp;
            $user->role = 'Bidan';
            $user->pekerjaan = $request->pekerjaan;
            $user->created_by = Auth::id();
            $user->updated_by = Auth::id();
            $user->save();

            return redirect()->route('bidan.index')->with('success', 'Bidan berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat bidan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('bidan.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_lengkap' => 'required|string',
                'tanggal_lahir' => 'required|date_format:Y-m-d',
                'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
                'username' => 'required|string|unique:users,username,' . $id,
                'no_hp' => 'required|string',
                'pekerjaan' => 'required|string',
            ]);

            $user = User::findOrFail($id);
            $user->nama_lengkap = $request->nama_lengkap;
            $user->tanggal_lahir = Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir);
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->username = $request->username;
            $user->no_hp = $request->no_hp;
            $user->pekerjaan = $request->pekerjaan;
            $user->updated_by = Auth::id();

            $user->save();

            return redirect()->route('bidan.index')->with('success', 'Bidan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui bidan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('bidan.show', compact('user'));
    }

    public function destroy($id)
    {
        try {
            User::destroy($id);
            return redirect()->route('bidan.index')->with('success', 'Bidan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus bidan: ' . $e->getMessage()]);
        }
    }
}