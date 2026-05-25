@extends('laporan.layout')

@section('title', 'History Laporan')

@section('content')
<div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Riwayat Seluruh Laporan</h1>
        <p class="text-slate-500 mt-1">Semua riwayat laporan yang pernah dikirim</p>
    </div>

    <form method="GET" action="{{ route('laporan.history') }}" class="grid w-full grid-cols-1 gap-3 sm:grid-cols-[minmax(0,260px)_minmax(0,220px)_auto] lg:w-auto">
        {{-- <input type="text" name="search" placeholder="Cari laporan..." value="{{ request('search') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"> --}}

        <select name="id_kegiatan" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Kegiatan</option>
            @foreach($kegiatans as $kegiatan)
                <option value="{{ $kegiatan->id_kegiatan }}" {{ request('id_kegiatan') == $kegiatan->id_kegiatan ? 'selected' : '' }}>
                    {{ $kegiatan->jenis_kegiatan }}
                </option>
            @endforeach
        </select>

        <button class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">Filter</button>
    </form>
</div>

<div class="bg-white rounded-[28px] shadow-sm border border-slate-100 overflow-hidden">
    <div>
        <table class="w-full table-fixed text-center text-xs xl:text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="w-[15%] px-2 py-4 text-center font-semibold">Mahasiswa</th>
                    <th class="w-[10%] px-2 py-4 text-center font-semibold">NIM</th>
                    <th class="w-[18%] px-2 py-4 text-center font-semibold">Kegiatan</th>
                    <th class="w-[14%] px-2 py-4 text-center font-semibold">Bentuk</th>
                    <th class="w-[17%] px-2 py-4 text-center font-semibold">Keterangan</th>
                    <th class="w-[9%] px-2 py-4 text-center font-semibold">Foto</th>
                    <th class="w-[9%] px-2 py-4 text-center font-semibold">Tanggal</th>
                    <th class="w-[8%] px-2 py-4 text-center font-semibold">Detail</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($laporans as $laporan)
                <tr class="hover:bg-slate-50 transition duration-200">
                    <td class="px-2 py-4 align-middle font-semibold text-slate-800">
                        <p class="truncate" title="{{ $laporan->nama_mahasiswa }}">{{ $laporan->nama_mahasiswa }}</p>
                    </td>
                    <td class="px-2 py-4 align-middle text-slate-500">
                        <p class="truncate" title="{{ $laporan->nim_mahasiswa }}">{{ $laporan->nim_mahasiswa }}</p>
                    </td>
                    <td class="px-2 py-4 align-middle">
                        @php
                            $jenisKegiatan = $laporan->kegiatan?->jenis_kegiatan;
                            $warnaKegiatan = match ($jenisKegiatan) {
                                'Seminar Kerja Praktek' => 'bg-blue-100 text-blue-700',
                                'Seminar Proposal' => 'bg-green-100 text-green-700',
                                'Seminar Hasil/Sidang Tertutup' => 'bg-yellow-100 text-yellow-700',
                                'Seminar Akhir/Sidang Terbuka' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="inline-flex max-w-full justify-center whitespace-normal break-words rounded-lg px-2 py-1 text-[10px] font-bold uppercase tracking-wide leading-snug {{ $warnaKegiatan }}">
                            {{ $jenisKegiatan ?? '-' }}
                        </span>
                    </td>
                    <td class="px-2 py-4 align-middle text-slate-500">
                        <p class="truncate" title="{{ $laporan->bentuk_gratifikasi }}">{{ $laporan->bentuk_gratifikasi }}</p>
                    </td>
                    <td class="px-2 py-4 align-middle text-slate-500">
                        <p class="truncate" title="{{ $laporan->keterangan }}">{{ $laporan->keterangan ?? '-' }}</p>
                    </td>
                    <td class="px-2 py-4 align-middle text-slate-500">
                        <div class="flex flex-wrap justify-center gap-2">
                            @forelse($laporan->buktiLaporans->whereNotNull('file_path') as $bukti)
                                <button type="button"
                                    onclick="openPhotoModal('{{ asset('storage/'.$bukti->file_path) }}')"
                                    class="h-9 w-9 overflow-hidden rounded-lg border border-slate-200 bg-slate-50 transition hover:ring-2 hover:ring-blue-400"
                                    title="Review foto {{ $loop->iteration }}">
                                    <img src="{{ asset('storage/'.$bukti->file_path) }}" alt="Foto gratifikasi" class="h-full w-full object-cover">
                                </button>
                            @empty
                                <span class="text-slate-300">-</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-2 py-4 align-middle text-slate-500">{{ $laporan->tanggal_kegiatan }}</td>
                    <td class="px-2 py-4 align-middle">
                        @php
                            $detailData = [
                                'mahasiswa' => $laporan->nama_mahasiswa,
                                'nim' => $laporan->nim_mahasiswa,
                                'kegiatan' => $laporan->kegiatan?->jenis_kegiatan ?? '-',
                                'bentuk' => $laporan->bentuk_gratifikasi,
                                'tanggal' => $laporan->tanggal_kegiatan,
                                'keterangan' => $laporan->keterangan ?? '-',
                                'fotos' => $laporan->buktiLaporans
                                    ->whereNotNull('file_path')
                                    ->map(fn ($bukti) => asset('storage/'.$bukti->file_path))
                                    ->values(),
                            ];
                        @endphp
                        <button type="button"
                            data-detail='@json($detailData)'
                            onclick="openDetailModal(JSON.parse(this.dataset.detail))"
                            class="rounded-lg bg-blue-50 px-2 py-2 text-[11px] font-bold text-blue-700 transition hover:bg-blue-100">
                            Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-14 text-slate-400 text-lg">Belum ada history laporan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($laporans->hasPages())
        <div class="flex flex-col gap-4 border-t border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm font-medium text-slate-500">
                Menampilkan {{ $laporans->firstItem() }}-{{ $laporans->lastItem() }} dari {{ $laporans->total() }} data
            </p>

            <div class="flex items-center justify-center gap-2">
                @if ($laporans->onFirstPage())
                    <span class="rounded-2xl border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400">
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $laporans->previousPageUrl() }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                        Sebelumnya
                    </a>
                @endif

                <span class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-bold text-white shadow-sm">
                    {{ $laporans->currentPage() }} / {{ $laporans->lastPage() }}
                </span>

                @if ($laporans->hasMorePages())
                    <a href="{{ $laporans->nextPageUrl() }}" class="rounded-2xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-600 hover:text-white">
                        Selanjutnya
                    </a>
                @else
                    <span class="rounded-2xl border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400">
                        Selanjutnya
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>

<div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl">
        <div class="mb-5 flex items-start justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Detail Laporan</h3>
                <p class="text-sm text-slate-400">Informasi lengkap laporan gratifikasi.</p>
            </div>
            <button type="button" onclick="closeDetailModal()" class="rounded-lg bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-600 hover:bg-slate-200">Tutup</button>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Mahasiswa</p>
                <p id="detailMahasiswa" class="mt-1 font-semibold text-slate-800"></p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">NIM</p>
                <p id="detailNim" class="mt-1 font-semibold text-slate-800"></p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Kegiatan</p>
                <p id="detailKegiatan" class="mt-1 font-semibold text-slate-800"></p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Tanggal</p>
                <p id="detailTanggal" class="mt-1 font-semibold text-slate-800"></p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4 md:col-span-2">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Bentuk Gratifikasi</p>
                <p id="detailBentuk" class="mt-1 font-semibold text-slate-800"></p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4 md:col-span-2">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Keterangan</p>
                <p id="detailKeterangan" class="mt-1 whitespace-pre-line break-words text-slate-700"></p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4 md:col-span-2">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Foto</p>
                <div id="detailFotos" class="mt-3 grid grid-cols-2 gap-3 md:grid-cols-4"></div>
            </div>
        </div>
    </div>
</div>

<div id="photoModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 p-4">
    <div class="relative max-h-[90vh] w-full max-w-4xl">
        <button type="button" onclick="closePhotoModal()" class="absolute -top-10 right-0 rounded-lg bg-white/90 px-3 py-1 text-sm font-semibold text-slate-700 hover:bg-white">
            Tutup
        </button>
        <img id="photoModalImage" src="" alt="Preview foto gratifikasi" class="max-h-[90vh] w-full rounded-2xl object-contain bg-white shadow-2xl">
    </div>
</div>

<script>
    const detailModal = document.getElementById('detailModal');
    const photoModal = document.getElementById('photoModal');
    const photoModalImage = document.getElementById('photoModalImage');

    function openPhotoModal(src) {
        photoModalImage.src = src;
        photoModal.classList.remove('hidden');
        photoModal.classList.add('flex');
    }

    function closePhotoModal() {
        photoModal.classList.add('hidden');
        photoModal.classList.remove('flex');
        photoModalImage.src = '';
    }

    function openDetailModal(data) {
        document.getElementById('detailMahasiswa').innerText = data.mahasiswa;
        document.getElementById('detailNim').innerText = data.nim;
        document.getElementById('detailKegiatan').innerText = data.kegiatan;
        document.getElementById('detailTanggal').innerText = data.tanggal;
        document.getElementById('detailBentuk').innerText = data.bentuk;
        document.getElementById('detailKeterangan').innerText = data.keterangan;

        const fotos = document.getElementById('detailFotos');
        fotos.innerHTML = '';

        if (data.fotos.length === 0) {
            fotos.innerHTML = '<p class="col-span-full text-sm text-slate-400">Tidak ada foto.</p>';
        } else {
            data.fotos.forEach((src) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'block overflow-hidden rounded-xl border border-slate-200 bg-white hover:ring-2 hover:ring-blue-400 transition';
                button.innerHTML = `<img src="${src}" alt="Foto laporan" class="h-32 w-full object-cover">`;
                button.addEventListener('click', () => openPhotoModal(src));
                fotos.appendChild(button);
            });
        }

        detailModal.classList.remove('hidden');
        detailModal.classList.add('flex');
    }

    function closeDetailModal() {
        detailModal.classList.add('hidden');
        detailModal.classList.remove('flex');
    }

    detailModal.addEventListener('click', function (event) {
        if (event.target === detailModal) {
            closeDetailModal();
        }
    });

    photoModal.addEventListener('click', function (event) {
        if (event.target === photoModal) {
            closePhotoModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            if (!photoModal.classList.contains('hidden')) {
                closePhotoModal();
            }

            if (!detailModal.classList.contains('hidden')) {
                closeDetailModal();
            }
        }
    });
</script>
@endsection
