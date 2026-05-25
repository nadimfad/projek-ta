<?php

namespace App\Http\Controllers;

use App\Models\BuktiLaporan;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with([
            'kegiatan',
            'buktiLaporans',
            'dosen' => fn ($dosenQuery) => $dosenQuery->withCount('laporans'),
        ]);

        if ($request->id_kegiatan) {
            $query->where('id_kegiatan', $request->id_kegiatan);
        }

        if ($request->search) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('nama_mahasiswa', 'like', '%'.$request->search.'%')
                    ->orWhere('nim_mahasiswa', 'like', '%'.$request->search.'%')
                    ->orWhere('bentuk_gratifikasi', 'like', '%'.$request->search.'%')
                    ->orWhereHas('dosen', function ($dosenQuery) use ($request) {
                        $dosenQuery->where('nama', 'like', '%'.$request->search.'%')
                            ->orWhere('nip', 'like', '%'.$request->search.'%')
                            ->orWhere('email', 'like', '%'.$request->search.'%');
                    })
                    ->orWhereHas('kegiatan', function ($kegiatanQuery) use ($request) {
                        $kegiatanQuery->where('jenis_kegiatan', 'like', '%'.$request->search.'%');
                    });
            });
        }

        if (auth()->user()->role === 'admin') {
            if ($request->sort == 'dosen_terbanyak') {
                $query->orderByRaw('(select count(*) from laporans as dosen_laporans where dosen_laporans.id_dosen = laporans.id_dosen) desc');
            }

            if ($request->sort == 'dosen_terdikit') {
                $query->orderByRaw('(select count(*) from laporans as dosen_laporans where dosen_laporans.id_dosen = laporans.id_dosen) asc');
            }

            $laporans = $query
                ->latest()
                ->paginate(20)
                ->withQueryString();
            $kegiatans = Kegiatan::orderBy('jenis_kegiatan')->get();

            return view('admin.laporan', compact('laporans', 'kegiatans'));
        }

        $dosen = auth()->user()->dosen;

        $laporans = Laporan::with([
            'kegiatan',
            'buktiLaporans',
        ])
            ->where('id_dosen', $dosen?->id_dosen)
            ->latest()
            ->limit(10)
            ->get();
        $kegiatans = Kegiatan::orderBy('jenis_kegiatan')->get();

        return view('laporan.index', compact('laporans', 'kegiatans'));
    }

    public function create()
    {
        $kegiatans = Kegiatan::orderBy('jenis_kegiatan')->get();

        return view('laporan.create', compact('kegiatans'));
    }

    public function store(Request $request)
    {
        $dosen = auth()->user()->dosen;

        abort_if(! $dosen, 403);

        $data = $request->validate([
            'id_kegiatan' => ['required', 'exists:kegiatans,id_kegiatan'],
            'nama_mahasiswa' => ['required', 'string', 'max:255'],
            'nim_mahasiswa' => ['required', 'string', 'max:50'],
            'bentuk_gratifikasi' => ['required', 'string', 'max:255'],
            'tanggal_kegiatan' => ['nullable', 'date'],
            'keterangan' => ['nullable', 'string'],
            'fotos' => ['nullable', 'array'],
            'fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $data['id_dosen'] = $dosen->id_dosen;
        $data['tanggal_kegiatan'] = $data['tanggal_kegiatan'] ?? now()->toDateString();

        $laporan = Laporan::create($data);

        $files = $request->file('fotos', []);

        if (count($files) === 0) {
            BuktiLaporan::create([
                'id_laporan' => $laporan->id_laporan,
                'nama' => $dosen->nama,
                'email' => $dosen->email,
            ]);
        }

        foreach ($files as $file) {
            BuktiLaporan::create([
                'id_laporan' => $laporan->id_laporan,
                'nama' => $dosen->nama,
                'email' => $dosen->email,
                'file_path' => $file->store('bukti-laporan', 'public'),
            ]);
        }

        return redirect('/laporan')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $data = $request->validate([
            'id_kegiatan' => ['required', 'exists:kegiatans,id_kegiatan'],
            'nama_mahasiswa' => ['required', 'string', 'max:255'],
            'nim_mahasiswa' => ['required', 'string', 'max:50'],
            'bentuk_gratifikasi' => ['required', 'string', 'max:255'],
            'tanggal_kegiatan' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $laporan->update($data);

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $laporan = Laporan::with('buktiLaporans')->findOrFail($id);

        foreach ($laporan->buktiLaporans as $bukti) {
            if ($bukti->file_path) {
                Storage::disk('public')->delete($bukti->file_path);
            }
        }

        $laporan->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    public function history(Request $request)
    {
        $dosen = auth()->user()->dosen;

        abort_if(! $dosen, 403);

        $query = Laporan::with(['kegiatan', 'buktiLaporans'])
            ->where('id_dosen', $dosen->id_dosen);

        if ($request->id_kegiatan) {
            $query->where('id_kegiatan', $request->id_kegiatan);
        }

        if ($request->search) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('nama_mahasiswa', 'like', '%'.$request->search.'%')
                    ->orWhere('nim_mahasiswa', 'like', '%'.$request->search.'%')
                    ->orWhere('bentuk_gratifikasi', 'like', '%'.$request->search.'%')
                    ->orWhereHas('kegiatan', function ($kegiatanQuery) use ($request) {
                        $kegiatanQuery->where('jenis_kegiatan', 'like', '%'.$request->search.'%');
                    });
            });
        }

        $laporans = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();
        $kegiatans = Kegiatan::orderBy('jenis_kegiatan')->get();

        return view('laporan.history', compact('laporans', 'kegiatans'));
    }
}
