<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMS_Testimoni extends Model
{
    use HasFactory;
    protected $table = 'cms_testimoni';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $fillable = [
        'id', 'pasien_id', 'deskripsi', 'created_by', 'updated_by'
    ];
    public $timestamps = true;

    public function testimoni()
    {
        return $this->belongsTo(User::class, 'pasien_id', 'id');
    }
}
