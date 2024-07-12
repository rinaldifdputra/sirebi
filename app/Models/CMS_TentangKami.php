<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMS_TentangKami extends Model
{
    use HasFactory;
    protected $table = 'cms_tentang_kami';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $fillable = [
        'id', 'judul', 'deskripsi', 'alamat', 'telp', 'created_by', 'updated_by'
    ];
    public $timestamps = true;
}
