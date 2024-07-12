<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_Pekerjaan extends Model
{
    use HasFactory;
    protected $table = 't_pekerjaan';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $fillable = [
        'id', 'nama_pekerjaan', 'created_by', 'updated_by'
    ];
    public $timestamps = true;

    public function pasien()
    {
        return $this->hasMany(User::class, 'pekerjaan_id', 'id');
    }

    public function testimoni()
    {
        return $this->hasMany(User::class, 'pekerjaan_id', 'id');
    }
}
