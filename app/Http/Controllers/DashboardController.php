<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // 🔥 BASE QUERY + FILTER
        // =========================
        $query = Laporan::query();

        // filter kegiatan
        if ($request->kegiatan) {
            $query->where('kegiatan', $request->kegiatan);
        }

        // =========================
        // 📊 STATISTIK UTAMA
        // =========================
        $totalLaporan = (clone $query)->count();

        $laporanMenunggu = (clone $query)->where('status', 'menunggu')->count();
        $laporanDiterima = (clone $query)->where('status', 'diterima')->count();
        $laporanDitolak  = (clone $query)->where('status', 'ditolak')->count();

        // =========================
        // 🆕 DATA TERBARU
        // =========================
        $laporanTerbaru = (clone $query)->latest()->take(5)->get();

        // =========================
        // 📈 DATA GRAFIK PER BULAN
        // =========================
        $monthly = (clone $query)->select(
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
        $dataDitolak  = array_fill(0, 12, 0);

        foreach ($monthly as $item) {
            $index = $item->bulan - 1;

            $dataMenunggu[$index] = $item->menunggu;
            $dataDiterima[$index] = $item->diterima;
            $dataDitolak[$index]  = $item->ditolak;
        }

        // =========================
        // 🥧 DATA PIE CHART KEGIATAN
        // =========================
        $kegiatanChart = (clone $query)
            ->select('kegiatan', DB::raw('COUNT(*) as total'))
            ->groupBy('kegiatan')
            ->get();

        // format ke array
        $labelKegiatan = $kegiatanChart->pluck('kegiatan');
        $dataKegiatan  = $kegiatanChart->pluck('total');

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
            'dataDitolak',
            'labelKegiatan',
            'dataKegiatan'
        ));
    }
}