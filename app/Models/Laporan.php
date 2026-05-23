<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dosen',
        'id_kegiatan',
        'nama_mahasiswa',
        'nim_mahasiswa',
        'bentuk_gratifikasi',
        'tanggal_kegiatan',
        'keterangan',
    ];

    protected $primaryKey = 'id_laporan';

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen', 'id_dosen');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function buktiLaporan()
    {
        return $this->hasOne(BuktiLaporan::class, 'id_laporan', 'id_laporan');
    }

    public function buktiLaporans()
    {
        return $this->hasMany(BuktiLaporan::class, 'id_laporan', 'id_laporan');
    }
}
