<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_dosen';

    protected $fillable = [
        'nip',
        'nama',
        'email',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'nip');
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'id_dosen', 'id_dosen');
    }
}
