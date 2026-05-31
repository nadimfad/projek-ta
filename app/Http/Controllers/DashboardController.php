<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $totalLaporan = Laporan::count();
        $laporanMingguIni = Laporan::whereBetween('tanggal_kegiatan', [
            now()->startOfWeek()->toDateString(),
            now()->endOfWeek()->toDateString(),
        ])->count();
        $laporanBulanIni = Laporan::whereBetween('tanggal_kegiatan', [
            now()->startOfMonth()->toDateString(),
            now()->endOfMonth()->toDateString(),
        ])->count();
        $totalDosenPelapor = Laporan::whereNotNull('id_dosen')->distinct('id_dosen')->count('id_dosen');

        $startMonth = now()->startOfMonth()->subMonths(11);
        $monthly = Laporan::select(
            DB::raw('YEAR(tanggal_kegiatan) as tahun'),
            DB::raw('MONTH(tanggal_kegiatan) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereDate('tanggal_kegiatan', '>=', $startMonth->toDateString())
            ->groupBy('tahun', 'bulan')
            ->get()
            ->keyBy(fn ($item) => $item->tahun.'-'.str_pad($item->bulan, 2, '0', STR_PAD_LEFT));

        $labelBulanan = [];
        $dataBulanan = [];

        for ($i = 0; $i < 12; $i++) {
            $month = (clone $startMonth)->addMonths($i);
            $key = $month->format('Y-m');

            $labelBulanan[] = $month->translatedFormat('M Y');
            $dataBulanan[] = $monthly[$key]->total ?? 0;
        }

        $laporanTerbaru = Laporan::with(['dosen', 'kegiatan', 'buktiLaporans'])
            ->latest()
            ->take(10)
            ->get();

        $dosenPelapor = Dosen::withCount('laporans')
            ->orderByDesc('laporans_count')
            ->orderBy('nama')
            ->paginate(5, ['*'], 'dosen_page')
            ->withQueryString();

        $totalAdmin = Admin::count();
        $totalDosen = Dosen::count();
        $totalPengguna = User::count();

        return view('admin.dashboard', compact(
            'totalLaporan',
            'laporanMingguIni',
            'laporanBulanIni',
            'totalDosenPelapor',
            'labelBulanan',
            'dataBulanan',
            'laporanTerbaru',
            'dosenPelapor',
            'totalAdmin',
            'totalDosen',
            'totalPengguna'
        ));
    }

    public function statistik(Request $request): View
    {
        $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $query = Laporan::query();

        if ($request->id_kegiatan) {
            $query->where('laporans.id_kegiatan', $request->id_kegiatan);
        }

        $query = $this->applyDashboardDateFilter($query, $request);

        $totalLaporan = (clone $query)->count();
        $totalDosen = Dosen::count();
        $totalKegiatan = Kegiatan::count();

        $kegiatanChart = (clone $query)
            ->join('kegiatans', 'laporans.id_kegiatan', '=', 'kegiatans.id_kegiatan')
            ->select('kegiatans.jenis_kegiatan', DB::raw('COUNT(*) as total'))
            ->groupBy('kegiatans.jenis_kegiatan')
            ->get();

        $labelKegiatan = $kegiatanChart->pluck('jenis_kegiatan');
        $dataKegiatan = $kegiatanChart->pluck('total');

        $dosenChart = (clone $query)
            ->join('dosens', 'laporans.id_dosen', '=', 'dosens.id_dosen')
            ->select('dosens.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('dosens.id_dosen', 'dosens.nama')
            ->orderByDesc('total')
            ->take(8)
            ->get();

        $labelDosen = $dosenChart->pluck('nama');
        $dataDosen = $dosenChart->pluck('total');

        $hariChart = (clone $query)->select(
            DB::raw('DAYOFWEEK(tanggal_kegiatan) as hari'),
            DB::raw('COUNT(*) as total')
        )
            ->whereRaw('DAYOFWEEK(tanggal_kegiatan) BETWEEN 2 AND 6')
            ->groupBy('hari')
            ->get()
            ->keyBy('hari');

        $labelHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $dataHari = [];

        for ($i = 2; $i <= 6; $i++) {
            $dataHari[] = $hariChart[$i]->total ?? 0;
        }

        $laporanIds = (clone $query)->pluck('id_laporan');
        $laporanDenganFoto = $laporanIds->isEmpty()
            ? 0
            : DB::table('bukti_laporans')
                ->whereIn('id_laporan', $laporanIds)
                ->whereNotNull('file_path')
                ->distinct('id_laporan')
                ->count('id_laporan');
        $laporanTanpaFoto = max($totalLaporan - $laporanDenganFoto, 0);
        $labelBukti = ['Dengan Foto', 'Tanpa Foto'];
        $dataBukti = [$laporanDenganFoto, $laporanTanpaFoto];
        $kegiatans = Kegiatan::orderBy('jenis_kegiatan')->get();

        return view('admin.statistik', compact(
            'totalLaporan',
            'totalDosen',
            'totalKegiatan',
            'labelKegiatan',
            'dataKegiatan',
            'labelDosen',
            'dataDosen',
            'labelHari',
            'dataHari',
            'labelBukti',
            'dataBukti',
            'kegiatans'
        ));
    }

    public function dosenPelapor(Request $request): View
    {
        $dosenPelapor = Dosen::withCount('laporans')
            ->orderByDesc('laporans_count')
            ->orderBy('nama')
            ->paginate(5, ['*'], 'dosen_page')
            ->withQueryString();

        return view('admin.partials.dosen-pelapor', compact('dosenPelapor'));
    }

    private function applyDashboardDateFilter($query, Request $request)
    {
        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_kegiatan', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_kegiatan', '<=', $request->date_to);
        }

        return $query;
    }

    public function getData(Request $request)
    {
        $query = Laporan::query();

        if ($request->id_kegiatan) {
            $query->where('laporans.id_kegiatan', $request->id_kegiatan);
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
