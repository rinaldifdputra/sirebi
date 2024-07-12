<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMS_LayananKami extends Model
{
    use HasFactory;
    protected $table = 'cms_layanan';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $fillable = [
        'id', 'nama_layanan', 'deskripsi', 'created_by', 'updated_by'
    ];
    public $timestamps = true;
}
