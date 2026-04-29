<?php

namespace App\Http\Controllers;

use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index()
    {
        // ambil semua data
        $totalLaporan = Laporan::count();

        // contoh kalau ada status
        $laporanDiproses = Laporan::where('status', 'diproses')->count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();

        // ambil 5 data terbaru
        $laporanTerbaru = Laporan::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalLaporan',
            'laporanDiproses',
            'laporanSelesai',
            'laporanTerbaru'
        ));
    }
}