<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_JadwalPraktek extends Model
{
    use HasFactory;
    protected $table = 't_jadwal_praktek';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $fillable = [
        'id', 'tanggal', 'jam_praktek_id', 'bidan_id', 'kuota', 'created_by', 'updated_by'
    ];
    public $timestamps = true;

    public function bidan()
    {
        return $this->belongsTo(User::class, 'bidan_id', 'id');
    }

    public function jam_praktek()
    {
        return $this->belongsTo(T_JamPraktek::class, 'jam_praktek_id', 'id');
    }

    public function reservasi()
    {
        return $this->hasMany(T_ReservasiBidan::class, 'jadwal_praktek_id');
    }

    public function reservasi_lama()
    {
        return $this->hasMany(T_ReservasiBidan::class, 'jadwal_praktek_id_lama', 'id');
    }

    public function reservasi_tetap()
    {
        return $this->hasMany(T_ReservasiBidan::class, 'jadwal_praktek_id', 'id')
            ->where('status', 'Tetap')->orWhere('status', 'Jadwal Ulang');
    }
}
