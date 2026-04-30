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
        <p class="text-yellow-500 text-sm">Menunggu</p>
        <h1 class="text-3xl font-bold mt-2">{{ $laporanMenunggu }}</h1>
    </x-card>

    <x-card>
        <p class="text-green-500 text-sm">Diterima</p>
        <h1 class="text-3xl font-bold mt-2">{{ $laporanDiterima }}</h1>
    </x-card>

    <x-card>
        <p class="text-red-500 text-sm">Ditolak</p>
        <h1 class="text-3xl font-bold mt-2">{{ $laporanDitolak }}</h1>
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
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($laporanTerbaru as $laporan)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="py-3">{{ $laporan->nama_pelapor }}</td>
                            <td>{{ $laporan->kegiatan }}</td>

                            <!-- Bukti -->
                            <td>
                                @if ($laporan->bukti)
                                    <a href="{{ asset('storage/' . $laporan->bukti) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $laporan->bukti) }}"
                                             class="w-16 h-16 object-cover rounded shadow hover:scale-105 transition">
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td>
                                <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <select name="status"
                                        onchange="this.form.submit()"
                                        class="text-xs rounded border-gray-300 px-2 py-1 mb-1">

                                        <option value="menunggu" {{ $laporan->status == 'menunggu' ? 'selected' : '' }}>
                                            Menunggu
                                        </option>

                                        <option value="diterima" {{ $laporan->status == 'diterima' ? 'selected' : '' }}>
                                            Diterima
                                        </option>

                                        <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                    </select>
                                </form>

                                <!-- Badge -->
                                <span class="px-3 py-1 text-xs rounded-full font-semibold
                                    @if($laporan->status == 'diterima') bg-green-100 text-green-600
                                    @elseif($laporan->status == 'ditolak') bg-red-100 text-red-600
                                    @else bg-yellow-100 text-yellow-600
                                    @endif">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </td>

                            <td>{{ $laporan->created_at->format('d M Y') }}</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-400">
                                Tidak ada data
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

        <!-- ✅ GRAFIK -->
        <x-card class="mt-6">
    <h2 class="text-lg font-semibold mb-4">Grafik Laporan per Bulan</h2>
    <canvas id="chartBulanan"></canvas>
</x-card>

    </div>

    <!-- ✅ Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- ✅ Script Chart -->
    <script>
const ctx = document.getElementById('chartBulanan');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'Jan','Feb','Mar','Apr','Mei','Jun',
            'Jul','Agu','Sep','Okt','Nov','Des'
        ],
        datasets: [
            {
                label: 'Menunggu',
                data: @json($dataMenunggu),
                backgroundColor: '#9CA3AF'
            },
            {
                label: 'Diterima',
                data: @json($dataDiterima),
                backgroundColor: '#22C55E'
            },
            {
                label: 'Ditolak',
                data: @json($dataDitolak),
                backgroundColor: '#EF4444'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>
</x-app-layout>