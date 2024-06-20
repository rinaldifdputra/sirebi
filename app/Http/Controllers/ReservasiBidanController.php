<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\T_ReservasiBidan;
use App\Models\T_JadwalPraktek;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservasiBidanController extends Controller
{
    public function create($jadwalPraktekId)
    {
        $jadwalPraktek = T_JadwalPraktek::withCount(['reservasi_tetap' => function ($query) {
            $query->where('status', 'Tetap');
        }])->findOrFail($jadwalPraktekId);

        $sisaKuota = $jadwalPraktek->kuota - $jadwalPraktek->reservasi_tetap_count;

        return view('reservasi.create', compact('jadwalPraktek', 'sisaKuota', 'jadwalPraktekId'));
    }

    public function store(Request $request, $jadwalPraktekId)
    {
        // Fetch the schedule
        $jadwal = T_JadwalPraktek::findOrFail($jadwalPraktekId);

        // Calculate remaining quota
        $sisaKuota = $jadwal->kuota - $jadwal->reservasi()->count();

        // Check if the remaining quota is zero
        if ($sisaKuota <= 0) {
            return redirect()->back()->with('error', 'Kuota penuh, tidak bisa menambah reservasi.');
        }

        $role = Auth::user()->role;

        // Menghitung no_antrian berdasarkan jadwal_praktek_id
        $no_antrian = T_ReservasiBidan::where('jadwal_praktek_id', $jadwalPraktekId)->max('no_antrian') + 1;

        if ($role == 'Pasien') {

            T_ReservasiBidan::create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'jadwal_praktek_id' => $jadwalPraktekId,
                'no_antrian' => $no_antrian,
                'pasien_id' => Auth::id(),
                'status' => 'Tetap', // Pastikan sesuai dengan status yang diinginkan
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('praktek_bidan.index')->with('success', 'Reservasi berhasil dibuat.');
        } else {

            T_ReservasiBidan::create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'jadwal_praktek_id' => $jadwalPraktekId,
                'no_antrian' => $no_antrian,
                'pasien_id' => $request->pasien_id,
                'status' => 'Tetap', // Pastikan sesuai dengan status yang diinginkan
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('jadwal_praktek.show', ['jadwal_praktek' => $jadwalPraktekId])->with('success', 'Reservasi berhasil dibuat.');
        }
    }

    public function edit($jadwalPraktekId)
    {
        $userId = Auth::id();
        $reservasi = T_ReservasiBidan::with(['jadwal_praktek.jam_praktek', 'jadwal_praktek.bidan'])
            ->where('jadwal_praktek_id', $jadwalPraktekId)
            ->where('pasien_id', $userId)
            ->firstOrFail();

        $jadwalPraktek = $reservasi->jadwal_praktek;
        $sisaKuota = $jadwalPraktek->kuota - $jadwalPraktek->reservasi_tetap()->where('status', 'Tetap')->count();

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

        return view('reservasi.edit', compact('reservasi', 'jadwalPraktek', 'sisaKuota', 'availableJadwalPraktek'));
    }

    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;

        $request->validate([
            'keterangan' => 'nullable|string',
            'jadwal_praktek_id' => 'required', // Validasi jadwal_praktek_id
            'status' => 'required|string|in:Tetap,Jadwal Ulang,Batal', // Validasi status
        ]);

        $reservasi = T_ReservasiBidan::findOrFail($id);

        if ($request->status == 'Jadwal Ulang' && $reservasi->jadwal_praktek_id != $request->jadwal_praktek_id) {
            // Jika jadwal_praktek_id diubah, set status menjadi "Jadwal Ulang" dan isi jadwal_praktek_id_lama
            $reservasi->jadwal_praktek_id_lama = $reservasi->jadwal_praktek_id;
            $reservasi->jadwal_praktek_id = $request->jadwal_praktek_id;
            $reservasi->status = 'Tetap';

            // Menghitung no_antrian baru berdasarkan jadwal_praktek_id baru
            $reservasi->no_antrian = T_ReservasiBidan::where('jadwal_praktek_id', $request->jadwal_praktek_id)->max('no_antrian') + 1;
        } else {
            $reservasi->status = 'Batal';
        }

        // Perbarui status, keterangan, dan updated_by
        $reservasi->update([
            'keterangan' => $request->keterangan,
            'updated_by' => Auth::id(),
        ]);

        if ($role == 'Pasien') {
            return redirect()->route('praktek_bidan.index')->with('success', 'Reservasi berhasil diperbarui.');
        } else {
            return redirect()->back()->with('success', 'Reservasi berhasil diperbarui.');
        }
    }

    public function destroy($id)
    {
        try {
            T_ReservasiBidan::destroy($id);
            return redirect()->back()->with('success', 'Reservasi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus reservasi: ' . $e->getMessage()]);
        }
    }

    public function show($jadwalPraktekId)
    {
        $userId = Auth::id();
        $reservasi = T_ReservasiBidan::with(['jadwal_praktek.jam_praktek', 'jadwal_praktek.bidan'])
            ->where('jadwal_praktek_id', $jadwalPraktekId)
            ->where('pasien_id', $userId)
            ->firstOrFail();

        $jadwalPraktek = $reservasi->jadwal_praktek;
        $sisaKuota = $jadwalPraktek->kuota - $jadwalPraktek->reservasi_tetap()->where('status', 'Tetap')->count();

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

        return view('reservasi.show', compact('reservasi', 'jadwalPraktek', 'sisaKuota', 'availableJadwalPraktek'));
    }
}
