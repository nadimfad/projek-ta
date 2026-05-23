<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $query = Laporan::with(['dosen', 'kegiatan']);

        if ($request->id_kegiatan) {
            $query->where('id_kegiatan', $request->id_kegiatan);
        }

        $laporanTerbaru = (clone $query)->latest()->take(10)->get();
        $kegiatans = Kegiatan::orderBy('jenis_kegiatan')->get();

        return view('admin.dashboard', compact('laporanTerbaru', 'kegiatans'));
    }

    public function statistik(Request $request): View
    {
        $query = Laporan::query();

        if ($request->id_kegiatan) {
            $query->where('id_kegiatan', $request->id_kegiatan);
        }

        $totalLaporan = (clone $query)->count();
        $totalDosen = Dosen::count();
        $totalKegiatan = Kegiatan::count();

        $monthly = (clone $query)->select(
            DB::raw('MONTH(tanggal_kegiatan) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $dataBulanan = array_fill(0, 12, 0);

        foreach ($monthly as $item) {
            $dataBulanan[$item->bulan - 1] = $item->total;
        }

        $kegiatanChart = (clone $query)
            ->join('kegiatans', 'laporans.id_kegiatan', '=', 'kegiatans.id_kegiatan')
            ->select('kegiatans.jenis_kegiatan', DB::raw('COUNT(*) as total'))
            ->groupBy('kegiatans.jenis_kegiatan')
            ->get();

        $labelKegiatan = $kegiatanChart->pluck('jenis_kegiatan');
        $dataKegiatan = $kegiatanChart->pluck('total');
        $kegiatans = Kegiatan::orderBy('jenis_kegiatan')->get();

        return view('admin.statistik', compact(
            'totalLaporan',
            'totalDosen',
            'totalKegiatan',
            'dataBulanan',
            'labelKegiatan',
            'dataKegiatan',
            'kegiatans'
        ));
    }

    public function getData(Request $request)
    {
        $query = Laporan::query();

        if ($request->id_kegiatan) {
            $query->where('id_kegiatan', $request->id_kegiatan);
        }

        $monthly = (clone $query)->select(
            DB::raw('MONTH(tanggal_kegiatan) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $dataBulanan = array_fill(0, 12, 0);

        foreach ($monthly as $item) {
            $dataBulanan[$item->bulan - 1] = $item->total;
        }

        $kegiatanChart = (clone $query)
            ->join('kegiatans', 'laporans.id_kegiatan', '=', 'kegiatans.id_kegiatan')
            ->select('kegiatans.jenis_kegiatan', DB::raw('COUNT(*) as total'))
            ->groupBy('kegiatans.jenis_kegiatan')
            ->get();

        return response()->json([
            'total' => (clone $query)->count(),
            'latest' => (clone $query)->with(['dosen', 'kegiatan'])->latest()->take(10)->get(),
            'dataBulanan' => $dataBulanan,
            'labelKegiatan' => $kegiatanChart->pluck('jenis_kegiatan'),
            'dataKegiatan' => $kegiatanChart->pluck('total'),
        ]);
    }
}
