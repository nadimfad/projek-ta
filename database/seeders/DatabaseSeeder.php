<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = Hash::make('admin12345');

        Admin::updateOrCreate(
            ['username_admin' => 'admin'],
            [
                'email' => 'admin@sigap.test',
                'password' => $password,
            ]
        );

        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => $password,
                'role' => 'admin',
            ]
        );

        $kegiatans = [
            ['jenis_kegiatan' => 'Seminar Kerja Praktek', 'deskripsi' => 'Kegiatan seminar kerja praktek.'],
            ['jenis_kegiatan' => 'Seminar Proposal', 'deskripsi' => 'Kegiatan seminar proposal.'],
            ['jenis_kegiatan' => 'Seminar Hasil/Sidang Tertutup', 'deskripsi' => 'Kegiatan seminar hasil atau sidang tertutup.'],
            ['jenis_kegiatan' => 'Seminar Akhir/Sidang Terbuka', 'deskripsi' => 'Kegiatan seminar akhir atau sidang terbuka.'],
        ];

        foreach ($kegiatans as $kegiatan) {
            Kegiatan::updateOrCreate(
                ['jenis_kegiatan' => $kegiatan['jenis_kegiatan']],
                ['deskripsi' => $kegiatan['deskripsi']]
            );
        }
    }
}
