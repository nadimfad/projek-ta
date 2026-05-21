@extends('layouts.admin')

@section('title', 'Seluruh Laporan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Seluruh Laporan Dosen</h2>
            <p class="text-sm text-gray-400 mt-1">Semua laporan yang dikirim oleh dosen tersimpan di halaman ini.</p>
        </div>

        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap gap-3">
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari laporan..."
                class="w-full md:w-[260px] rounded-lg border-gray-200 text-sm shadow-sm">

            <select name="kegiatan" class="border-gray-200 rounded-lg shadow-sm text-sm">
                <option value="">Semua Kegiatan</option>
                <option value="Seminar Kerja Praktek" {{ request('kegiatan') == 'Seminar Kerja Praktek' ? 'selected' : '' }}>Seminar Kerja Praktek</option>
                <option value="Seminar Proposal" {{ request('kegiatan') == 'Seminar Proposal' ? 'selected' : '' }}>Seminar Proposal</option>
                <option value="Seminar Hasil/Sidang Tertutup" {{ request('kegiatan') == 'Seminar Hasil/Sidang Tertutup' ? 'selected' : '' }}>Seminar Hasil</option>
                <option value="Seminar Akhir/Sidang Terbuka" {{ request('kegiatan') == 'Seminar Akhir/Sidang Terbuka' ? 'selected' : '' }}>Seminar Akhir</option>
            </select>

            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                Filter
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-400 uppercase text-[11px] tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold">Email</th>
                        <th class="px-6 py-4 text-left font-semibold">Kegiatan</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-center font-semibold">Bukti</th>
                        <th class="px-6 py-4 text-right font-semibold">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse($laporans as $laporan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-5 font-semibold text-gray-700">{{ $laporan->nama_pelapor }}</td>
                        <td class="px-6 py-5 text-gray-500">{{ $laporan->email }}</td>
                        <td class="px-6 py-5 text-gray-500">{{ $laporan->kegiatan }}</td>
                        <td class="px-6 py-5">
                            <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" class="mb-2">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-[11px] rounded-lg border-gray-200 px-2 py-1 bg-gray-50 text-gray-500">
                                    <option value="menunggu" {{ $laporan->status == 'menunggu' ? 'selected' : '' }}>Set Menunggu</option>
                                    <option value="diterima" {{ $laporan->status == 'diterima' ? 'selected' : '' }}>Set Diterima</option>
                                    <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Set Ditolak</option>
                                </select>
                            </form>

                            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg
                                @if($laporan->status == 'diterima') bg-green-50 text-green-600
                                @elseif($laporan->status == 'ditolak') bg-red-50 text-red-600
                                @else bg-orange-50 text-orange-600
                                @endif">
                                {{ $laporan->status == 'menunggu' ? 'Dalam Proses' : $laporan->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($laporan->bukti)
                                <img src="{{ asset('storage/'.$laporan->bukti) }}" onclick="openModal(this.src)" class="w-14 h-14 object-cover rounded-xl shadow-sm cursor-pointer hover:scale-110 transition mx-auto">
                            @else
                                <span class="text-gray-300">Tidak Ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right text-gray-400">{{ $laporan->created_at->format('d M Y') }}</td>
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

<div id="imageModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <img id="modalImage" class="max-w-3xl w-full rounded-lg shadow-lg">
</div>

<script>
    function openModal(src) {
        const modal = document.getElementById('imageModal');
        document.getElementById('modalImage').src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    document.getElementById('imageModal').addEventListener('click', function (event) {
        if (event.target === this) {
            this.classList.add('hidden');
            this.classList.remove('flex');
        }
    });
</script>
@endsection
