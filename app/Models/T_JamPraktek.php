<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_JamPraktek extends Model
{
    use HasFactory;
    protected $table = 't_jam_praktek';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $fillable = [
        'id', 'jam_mulai', 'jam_selesai', 'created_by', 'updated_by'
    ];
    public $timestamps = true;

    public function jadwal()
    {
        return $this->hasMany(T_JadwalPraktek::class, 'jam_praktek_id', 'id');
    }

    public function getJamPraktekAttribute()
    {
        return $this->jam_mulai . '-' . $this->jam_selesai;
    }
}
