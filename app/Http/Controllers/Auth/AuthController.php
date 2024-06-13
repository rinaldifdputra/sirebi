<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'Admin') {
                return redirect()->route('admin_dashboard.dashboard')->with('success', 'Selamat datang di Sirebi.');
            } elseif (Auth::user() == 'Bidan') {
                return redirect()->route('bidan_dashboard.dashboard')->with('success', 'Selamat datang di Sirebi.');
            } elseif (Auth::user() == 'Pasien') {
                return redirect()->route('pasien_dashboard.dashboard')->with('success', 'Selamat datang di Sirebi.');
            }
        } else {
            return view('auth.login');
        }
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        $user = User::where('username', $credentials['username'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);

            // Redirect based on role
            if ($user->role == 'Admin') {
                return redirect()->route('admin_dashboard.dashboard')->with('success', 'Anda berhasil login.');
            } elseif ($user->role == 'Bidan') {
                return redirect()->route('bidan_dashboard.dashboard')->with('success', 'Anda berhasil login.');
            } elseif ($user->role == 'Pasien') {
                return redirect()->route('pasien_dashboard.dashboard')->with('success', 'Anda berhasil login.');
            }
        }
        return back()->withErrors([
            'username' => 'Kombinasi username dan password tidak terdaftar dalam sistem.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
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

            $pasienUuid = Str::uuid();

            $user = new User();
            $user->id = $pasienUuid;
            $user->nama_lengkap = $request->nama_lengkap;
            $user->tanggal_lahir = Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir);
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->no_hp = $request->no_hp;
            $user->role = 'Pasien';
            $user->pekerjaan = $request->pekerjaan;
            $user->created_by = $pasienUuid;
            $user->updated_by = $pasienUuid;
            $user->save();

            return redirect()->route('login')->with('success', 'Registrasi pasien berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat pasien: ' . $e->getMessage()]);
        }
    }
}
