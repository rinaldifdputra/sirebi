<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_lengkap', 'tanggal_lahir', 'jenis_kelamin', 'username', 'password', 'no_hp', 'role', 'pekerjaan_id', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pekerjaan()
    {
        return $this->belongsTo(T_Pekerjaan::class, 'pekerjaan_id', 'id');
    }

    public function bidan()
    {
        return $this->hasMany(T_JadwalPraktek::class, 'bidan_id', 'id');
    }

    public function pasien()
    {
        return $this->hasMany(T_ReservasiBidan::class, 'pasien_id', 'id');
    }

    public function testimoni()
    {
        return $this->hasMany(CMS_Testimoni::class, 'pasien_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
