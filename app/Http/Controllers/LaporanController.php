<?php

namespace App\Http\Controllers;

use App\Models\BuktiLaporan;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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

        if (in_array(session('active_role', auth()->user()->role), ['admin', 'kajur'], true)) {
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
            ->limit(4)
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
            'keterangan' => ['required', 'string'],
            'fotos' => ['required', 'array', 'min:1'],
            'fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
        ], [
            'fotos.*.max' => 'Ukuran awal setiap foto maksimal 50 MB.',
        ]);

        $data['id_dosen'] = $dosen->id_dosen;
        $data['tanggal_kegiatan'] = $data['tanggal_kegiatan'] ?? now()->toDateString();

        $files = $request->file('fotos', []);
        $storedPaths = [];

        try {
            foreach ($files as $file) {
                $storedPaths[] = $this->storeCompressedPhoto($file);
            }

            DB::transaction(function () use ($data, $dosen, $storedPaths) {
                $laporan = Laporan::create($data);

                foreach ($storedPaths as $path) {
                    BuktiLaporan::create([
                        'id_laporan' => $laporan->id_laporan,
                        'nama' => $dosen->nama,
                        'email' => $dosen->email,
                        'file_path' => $path,
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($storedPaths);

            throw $exception;
        }

        return redirect('/laporan')->with('success', 'Laporan berhasil disimpan.');
    }

    private function storeCompressedPhoto(UploadedFile $file): string
    {
        $maxBytes = 2 * 1024 * 1024;

        if ($file->getSize() <= $maxBytes) {
            return $file->store('bukti-laporan', 'public');
        }

        $contents = file_get_contents($file->getRealPath());
        $source = $contents === false ? false : @imagecreatefromstring($contents);

        if ($source === false) {
            throw ValidationException::withMessages([
                'fotos' => 'Salah satu foto tidak dapat diproses. Gunakan file JPG, PNG, atau WEBP.',
            ]);
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'sigap-photo-');

        if ($tempPath === false) {
            imagedestroy($source);

            throw ValidationException::withMessages([
                'fotos' => 'Foto gagal dikompresi. Silakan coba kembali.',
            ]);
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $quality = 84;
        $scale = min(1, 2400 / max($sourceWidth, $sourceHeight));
        $size = $file->getSize();

        try {
            for ($attempt = 0; $attempt < 18 && $size > $maxBytes; $attempt++) {
                $width = max(1, (int) floor($sourceWidth * $scale));
                $height = max(1, (int) floor($sourceHeight * $scale));
                $canvas = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($canvas, 255, 255, 255);

                imagefill($canvas, 0, 0, $white);
                imagecopyresampled(
                    $canvas,
                    $source,
                    0,
                    0,
                    0,
                    0,
                    $width,
                    $height,
                    $sourceWidth,
                    $sourceHeight
                );
                imagejpeg($canvas, $tempPath, $quality);
                imagedestroy($canvas);

                clearstatcache(true, $tempPath);
                $size = filesize($tempPath);

                if ($quality > 60) {
                    $quality -= 8;
                } else {
                    $scale *= 0.82;
                    $quality = 78;
                }
            }

            if ($size === false || $size > $maxBytes) {
                throw ValidationException::withMessages([
                    'fotos' => 'Salah satu foto tidak dapat dikompresi hingga maksimal 2 MB.',
                ]);
            }

            $path = 'bukti-laporan/'.Str::uuid().'.jpg';
            $compressedContents = file_get_contents($tempPath);

            if ($compressedContents === false || ! Storage::disk('public')->put($path, $compressedContents)) {
                throw ValidationException::withMessages([
                    'fotos' => 'Foto gagal disimpan. Silakan coba kembali.',
                ]);
            }

            return $path;
        } finally {
            imagedestroy($source);

            if (is_file($tempPath)) {
                unlink($tempPath);
            }
        }
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
            ->paginate(4)
            ->withQueryString();
        $kegiatans = Kegiatan::orderBy('jenis_kegiatan')->get();

        return view('laporan.history', compact('laporans', 'kegiatans'));
    }
}
