<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiLaporan extends Model
{
    use HasFactory;

    protected $table = 'bukti_laporans';

    protected $primaryKey = 'id_bukti';

    protected $fillable = [
        'id_laporan',
        'nama',
        'email',
        'file_path',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
}
