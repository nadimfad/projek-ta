@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">

    <!-- HEADER + BUTTON -->
    <div class="mb-4 flex flex-wrap justify-between items-center gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Terbaru</h1>

        <a href="{{ route('laporan.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + Tambah Laporan
        </a>
    </div>

    <!-- FILTER -->
    <form method="GET"
          action="{{ route('laporan.index') }}"
          class="mb-6 flex flex-wrap gap-3">

        <select name="kegiatan"
                class="border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

            <option value="">Semua Kegiatan</option>

            <option value="Seminar Kerja Praktek"
                {{ request('kegiatan') == 'Seminar Kerja Praktek' ? 'selected' : '' }}>
                Seminar Kerja Praktek
            </option>

            <option value="Seminar Proposal"
                {{ request('kegiatan') == 'Seminar Proposal' ? 'selected' : '' }}>
                Seminar Proposal
            </option>

            <option value="Seminar Hasil/Sidang Tertutup"
                {{ request('kegiatan') == 'Seminar Hasil/Sidang Tertutup' ? 'selected' : '' }}>
                Seminar Hasil / Sidang Tertutup
            </option>

            <option value="Seminar Akhir/Sidang Terbuka"
                {{ request('kegiatan') == 'Seminar Akhir/Sidang Terbuka' ? 'selected' : '' }}>
                Seminar Akhir / Sidang Terbuka
            </option>

        </select>

        <button type="submit"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            Filter
        </button>

        <a href="{{ route('laporan.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            Reset
        </a>

    </form>

    <!-- CARD -->
    <div class="bg-white shadow-md rounded-xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-center">Nama</th>
                        <th class="px-6 py-4 text-center">Kegiatan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Tanggal</th>
                        <th class="px-6 py-4 text-center">Bukti</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse ($laporans as $laporan)

                    <tr class="hover:bg-gray-50 transition">

                        <!-- Nama -->
                        <td class="px-6 py-4 text-center">
                            {{ $laporan->nama_pelapor }}
                        </td>

                        <!-- Kegiatan -->
                        <td class="px-6 py-4 text-center">
                            {{ $laporan->kegiatan }}
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-center">

                            @if(auth()->user()->role == 'admin')

                                <form action="{{ route('laporan.update', $laporan->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('PUT')

                                    <select name="status"
                                            onchange="this.form.submit()"
                                            class="text-xs rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                                        <option value="menunggu"
                                            {{ $laporan->status == 'menunggu' ? 'selected' : '' }}>
                                            Menunggu
                                        </option>

                                        <option value="diproses"
                                            {{ $laporan->status == 'diproses' ? 'selected' : '' }}>
                                            Diproses
                                        </option>

                                        <option value="selesai"
                                            {{ $laporan->status == 'selesai' ? 'selected' : '' }}>
                                            Selesai
                                        </option>

                                    </select>

                                </form>

                            @else

                                <span class="px-3 py-1 text-xs rounded-full font-semibold

                                    @if($laporan->status == 'selesai')
                                        bg-green-100 text-green-700
                                    @elseif($laporan->status == 'diproses')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif
                                ">

                                    {{ ucfirst($laporan->status) }}

                                </span>

                            @endif

                        </td>

                        <!-- Tanggal -->
                        <td class="px-6 py-4 text-center">
                            {{ $laporan->created_at->format('d M Y') }}
                        </td>

                        <!-- Bukti -->
                        <td class="px-6 py-4 text-center">

                            @if ($laporan->bukti)

                                <img src="{{ asset('storage/' . $laporan->bukti) }}"
                                     onclick="openModal(this.src)"
                                     class="w-16 h-16 object-cover rounded-lg cursor-pointer hover:scale-110 transition mx-auto shadow">

                            @else

                                <span class="text-gray-400">-</span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5"
                            class="text-center py-6 text-gray-500">
                            Belum ada data laporan
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- MODAL -->
<div id="imageModal"
     class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">

    <img id="modalImage"
         class="max-w-3xl w-full rounded-xl shadow-lg">
</div>

<!-- SCRIPT -->
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

    // klik luar modal
    document.getElementById('imageModal')
        .addEventListener('click', function(e){

        if(e.target === this){
            closeModal();
        }

    });

    // tombol ESC
    document.addEventListener('keydown', function(e){

        if(e.key === "Escape"){
            closeModal();
        }

    });

</script>

@endsection