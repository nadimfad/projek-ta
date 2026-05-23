<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'jenis_kegiatan',
        'deskripsi',
    ];

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'id_kegiatan', 'id_kegiatan');
    }
}
