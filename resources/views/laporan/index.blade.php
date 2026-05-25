@extends('laporan.layout')

@section('title', 'Laporan Saya')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Laporan Saya</h2>
            <p class="text-sm text-gray-400 mt-1">Pantau laporan yang pernah Anda kirim.</p>
        </div>

        <div>
            <a href="{{ route('laporan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                Tambah Laporan
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-sm text-center">
                <thead class="bg-gray-50 text-gray-400 uppercase text-[11px] tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-center font-semibold">Mahasiswa</th>
                        <th class="px-6 py-4 text-center font-semibold">NIM</th>
                        <th class="px-6 py-4 text-center font-semibold">Kegiatan</th>
                        <th class="px-6 py-4 text-center font-semibold">Bentuk Gratifikasi</th>
                        <th class="px-6 py-4 text-center font-semibold">Foto</th>
                        <th class="px-6 py-4 text-center font-semibold">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse($laporans as $laporan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-5 font-semibold text-gray-700 align-middle">{{ $laporan->nama_mahasiswa }}</td>
                        <td class="px-6 py-5 text-gray-500 align-middle">{{ $laporan->nim_mahasiswa }}</td>
                        <td class="px-6 py-5">
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
                            <span class="inline-flex justify-center px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wide {{ $warnaKegiatan }}">
                                {{ $jenisKegiatan ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-gray-500 align-middle">{{ $laporan->bentuk_gratifikasi }}</td>
                        <td class="px-6 py-5 text-gray-500">
                            <div class="flex flex-wrap justify-center gap-2">
                                @forelse($laporan->buktiLaporans->whereNotNull('file_path') as $bukti)
                                    <button type="button"
                                        onclick="openPhotoModal('{{ asset('storage/'.$bukti->file_path) }}')"
                                        class="h-10 w-10 overflow-hidden rounded-lg border border-gray-200 bg-gray-50 hover:ring-2 hover:ring-blue-400 transition"
                                        title="Review foto {{ $loop->iteration }}">
                                        <img src="{{ asset('storage/'.$bukti->file_path) }}" alt="Foto gratifikasi" class="h-full w-full object-cover">
                                    </button>
                                @empty
                                    <span class="text-gray-300">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-5 text-gray-400 align-middle">{{ $laporan->tanggal_kegiatan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-gray-400">Belum ada laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="photoModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 p-4">
    <div class="relative max-h-[90vh] w-full max-w-4xl">
        <button type="button" onclick="closePhotoModal()" class="absolute -top-10 right-0 rounded-lg bg-white/90 px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-white">
            Tutup
        </button>
        <img id="photoModalImage" src="" alt="Preview foto gratifikasi" class="max-h-[90vh] w-full rounded-2xl object-contain bg-white shadow-2xl">
    </div>
</div>

<script>
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

    photoModal.addEventListener('click', function (event) {
        if (event.target === photoModal) {
            closePhotoModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !photoModal.classList.contains('hidden')) {
            closePhotoModal();
        }
    });
</script>
@endsection
