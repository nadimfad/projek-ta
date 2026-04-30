<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">Detail Laporan</h2>
    </x-slot>

    <x-card>

        <div class="space-y-4">

            <!-- Nama -->
            <div>
                <p class="text-sm text-gray-500">Nama Pelapor</p>
                <p class="font-semibold">{{ $laporan->nama_pelapor }}</p>
            </div>

            <!-- Email -->
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-semibold">{{ $laporan->email }}</p>
            </div>

            <!-- Kegiatan -->
            <div>
                <p class="text-sm text-gray-500">Kegiatan</p>
                <p class="font-semibold">{{ $laporan->kegiatan }}</p>
            </div>

            <!-- Deskripsi -->
            <div>
                <p class="text-sm text-gray-500">Deskripsi</p>
                <p class="font-semibold">{{ $laporan->deskripsi }}</p>
            </div>

            <!-- Status -->
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="px-3 py-1 text-xs rounded-full
                    @if($laporan->status == 'selesai') bg-green-100 text-green-600
                    @elseif($laporan->status == 'diproses') bg-yellow-100 text-yellow-600
                    @else bg-gray-100 text-gray-600 @endif">
                    {{ $laporan->status }}
                </span>
            </div>

            <!-- Bukti -->
            <div>
                <p class="text-sm text-gray-500 mb-2">Bukti</p>

                @if ($laporan->bukti)

                    <!-- Preview gambar -->
                    <img src="{{ asset('storage/' . $laporan->bukti) }}"
                         class="w-64 rounded-lg shadow mb-2">

                    <!-- Link download -->
                    <a href="{{ asset('storage/' . $laporan->bukti) }}"
                       target="_blank"
                       class="text-blue-500 underline">
                       Lihat / Download File
                    </a>

                @else
                    <p class="text-gray-400">Tidak ada bukti</p>
                @endif
            </div>

        </div>

        <!-- Tombol kembali -->
        <div class="mt-6">
            <a href="{{ url()->previous() }}"
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>

    </x-card>

</x-app-layout>