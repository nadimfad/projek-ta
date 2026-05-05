<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::query();

        if ($request->kegiatan) {
            $query->where('kegiatan', $request->kegiatan);
        }

        // =========================
        // 📊 STATISTIK
        // =========================
        $totalLaporan = (clone $query)->count();

        $laporanMenunggu = (clone $query)->where('status', 'menunggu')->count();
        $laporanDiterima = (clone $query)->where('status', 'diterima')->count();
        $laporanDitolak  = (clone $query)->where('status', 'ditolak')->count();

        // =========================
        // 🆕 DATA TERBARU
        // =========================
        $laporanTerbaru = Laporan::latest()->take(15)->get();

        // =========================
        // 📈 BULANAN
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
        // 🥧 PIE KEGIATAN
        // =========================
        $kegiatanChart = (clone $query)
            ->select('kegiatan', DB::raw('COUNT(*) as total'))
            ->groupBy('kegiatan')
            ->get();

        $labelKegiatan = $kegiatanChart->pluck('kegiatan');
        $dataKegiatan  = $kegiatanChart->pluck('total');

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


    // =========================================
    // 🔥 REALTIME DATA + CHART
    // =========================================
    public function getData(Request $request)
    {
        $query = Laporan::query();

        if ($request->kegiatan) {
            $query->where('kegiatan', $request->kegiatan);
        }

        // =========================
        // 📈 BULANAN (REALTIME)
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
        // 🥧 PIE KEGIATAN (REALTIME)
        // =========================
        $kegiatanChart = (clone $query)
            ->select('kegiatan', DB::raw('COUNT(*) as total'))
            ->groupBy('kegiatan')
            ->get();

        $labelKegiatan = $kegiatanChart->pluck('kegiatan');
        $dataKegiatan  = $kegiatanChart->pluck('total');

        return response()->json([
            // statistik
            'total' => (clone $query)->count(),
            'menunggu' => (clone $query)->where('status', 'menunggu')->count(),
            'diterima' => (clone $query)->where('status', 'diterima')->count(),
            'ditolak' => (clone $query)->where('status', 'ditolak')->count(),

            // tabel
            'latest' => (clone $query)->latest()->take(5)->get(),

            // 🔥 chart bulanan
            'dataMenunggu' => $dataMenunggu,
            'dataDiterima' => $dataDiterima,
            'dataDitolak'  => $dataDitolak,

            // 🔥 chart kegiatan
            'labelKegiatan' => $labelKegiatan,
            'dataKegiatan'  => $dataKegiatan,
        ]);
    }
}