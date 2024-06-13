<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_ReservasiBidan extends Model
{
    use HasFactory;
    protected $table = 't_reservasi_bidan';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $fillable = [
        'id', 'jadwal_praktek_id', 'no_antrian', 'status', 'pasien_id', 'keterangan', 'jadwal_praktek_id_lama', 'created_by', 'updated_by'
    ];
    public $timestamps = true;

    public function jadwal_praktek()
    {
        return $this->belongsTo(T_JadwalPraktek::class, 'jadwal_praktek_id', 'id');
    }

    public function jadwal_praktek_lama()
    {
        return $this->belongsTo(T_JadwalPraktek::class, 'jadwal_praktek_id_lama', 'id');
    }

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id', 'id');
    }
}
