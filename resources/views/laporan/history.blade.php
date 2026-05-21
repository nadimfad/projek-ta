@extends('laporan.layout')

@section('title', 'History Laporan')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Riwayat Seluruh Laporan
        </h1>

        <p class="text-slate-500 mt-1">
            Semua riwayat laporan yang pernah dikirim
        </p>
    </div>

    <form method="GET" action="{{ route('laporan.history') }}">
        <input type="text"
            name="search"
            placeholder="Cari laporan..."
            value="{{ request('search') }}"
            class="w-full md:w-[300px] bg-white border border-slate-200 rounded-2xl px-5 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
    </form>
</div>

<div class="bg-white rounded-[28px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="px-6 py-5 text-left font-semibold">Kegiatan</th>
                    <th class="px-6 py-5 text-left font-semibold">Status</th>
                    <th class="px-6 py-5 text-left font-semibold">Tanggal</th>
                    <th class="px-6 py-5 text-center font-semibold">Bukti</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($laporans as $laporan)
                <tr class="hover:bg-slate-50 transition duration-200">
                    <td class="px-6 py-5 font-semibold text-slate-800">
                        {{ $laporan->kegiatan }}
                    </td>

                    <td class="px-6 py-5">
                        @if($laporan->status == 'diterima')
                            <span class="bg-green-100 text-green-700 px-4 py-1.5 rounded-xl text-[11px] font-bold uppercase">
                                Diterima
                            </span>
                        @elseif($laporan->status == 'ditolak')
                            <span class="bg-red-100 text-red-700 px-4 py-1.5 rounded-xl text-[11px] font-bold uppercase">
                                Ditolak
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-4 py-1.5 rounded-xl text-[11px] font-bold uppercase">
                                Menunggu
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-5 text-slate-500">
                        {{ $laporan->created_at->format('d M Y') }}
                    </td>

                    <td class="px-6 py-5 text-center">
                        @if ($laporan->bukti)
                            <img src="{{ asset('storage/' . $laporan->bukti) }}"
                                onclick="openModal(this.src)"
                                class="w-16 h-16 object-cover rounded-2xl shadow-sm cursor-pointer hover:scale-110 transition duration-300 mx-auto">
                        @else
                            <span class="text-slate-400">Tidak Ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-14 text-slate-400 text-lg">
                        Belum ada history laporan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="imageModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50 backdrop-blur-sm">
    <img id="modalImage"
         class="max-w-4xl w-full rounded-3xl shadow-2xl">
</div>
@endsection

@section('scripts')
<script>
    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');

        img.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('imageModal').addEventListener('click', function (event) {
        if (event.target === this) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endsection
