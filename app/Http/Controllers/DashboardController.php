<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // 📊 STATISTIK UTAMA
        // =========================
        $totalLaporan = Laporan::count();

        $laporanMenunggu = Laporan::where('status', 'menunggu')->count();
        $laporanDiterima = Laporan::where('status', 'diterima')->count();
        $laporanDitolak = Laporan::where('status', 'ditolak')->count();

        // =========================
        // 🆕 DATA TERBARU
        // =========================
        $laporanTerbaru = Laporan::latest()->take(5)->get();

        // =========================
        // 📈 DATA GRAFIK PER BULAN
        // =========================
        $monthly = Laporan::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw("SUM(CASE WHEN status='menunggu' THEN 1 ELSE 0 END) as menunggu"),
            DB::raw("SUM(CASE WHEN status='diterima' THEN 1 ELSE 0 END) as diterima"),
            DB::raw("SUM(CASE WHEN status='ditolak' THEN 1 ELSE 0 END) as ditolak")
        )
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        // =========================
        // 🧠 FORMAT DATA 12 BULAN
        // =========================
        $dataMenunggu = array_fill(0, 12, 0);
        $dataDiterima = array_fill(0, 12, 0);
        $dataDitolak = array_fill(0, 12, 0);

        foreach ($monthly as $item) {
            $index = $item->bulan - 1;

            $dataMenunggu[$index] = $item->menunggu;
            $dataDiterima[$index] = $item->diterima;
            $dataDitolak[$index] = $item->ditolak;
        }

        // =========================
        // 🎯 RETURN VIEW
        // =========================
        return view('dashboard', compact(
            'totalLaporan',
            'laporanMenunggu',
            'laporanDiterima',
            'laporanDitolak',
            'laporanTerbaru',
            'dataMenunggu',
            'dataDiterima',
            'dataDitolak'
        ));
    }
}