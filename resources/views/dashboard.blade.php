<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="p-6 bg-gray-100 min-h-screen">

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

    <x-card>
        <p class="text-gray-500 text-sm">Total Laporan</p>
        <h1 class="text-3xl font-bold mt-2">{{ $totalLaporan }}</h1>
    </x-card>

    <x-card>
        <p class="text-yellow-500 text-sm">Diproses</p>
        <h1 class="text-3xl font-bold mt-2">{{ $laporanDiproses }}</h1>
    </x-card>

    <x-card>
        <p class="text-green-500 text-sm">Selesai</p>
        <h1 class="text-3xl font-bold mt-2">{{ $laporanSelesai }}</h1>
    </x-card>

</div>

        <!-- Tabel -->
        <x-card>
    <h2 class="text-lg font-semibold mb-4">Laporan Terbaru</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-gray-500 border-b">
                <tr>
                    <th class="py-3">Nama</th>
                    <th>Kegiatan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($laporanTerbaru as $laporan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3">{{ $laporan->nama_pelapor }}</td>
                    <td>{{ $laporan->kegiatan }}</td>

                    <td>
                        <span class="px-3 py-1 text-xs rounded-full font-medium
                            @if($laporan->status == 'selesai') bg-green-100 text-green-600
                            @elseif($laporan->status == 'diproses') bg-yellow-100 text-yellow-600
                            @else bg-gray-100 text-gray-600 @endif">
                            {{ $laporan->status }}
                        </span>
                    </td>

                    <td>{{ $laporan->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>

    </div>

</x-app-layout>