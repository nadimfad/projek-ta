<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="p-6 bg-gray-100 min-h-screen">

        <!-- FILTER -->
        <form method="GET" action="{{ route('dashboard') }}" class="mb-6 flex gap-3 flex-wrap">

            <select name="kegiatan"
                class="border-gray-300 rounded-lg shadow-sm">

                <option value=""> Semua Kegiatan </option>

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
                    Seminar Hasil
                </option>

                <option value="Seminar Akhir/Sidang Terbuka"
                    {{ request('kegiatan') == 'Seminar Akhir/Sidang Terbuka' ? 'selected' : '' }}>
                    Seminar Akhir
                </option>

            </select>

            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                Filter
            </button>

            <a href="{{ route('dashboard') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded-lg">
                Reset
            </a>

        </form>

        <!-- STATISTIK -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6">

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

        <!-- TABEL -->
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

                            <td>
                                <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <select name="status"
                                        onchange="this.form.submit()"
                                        class="text-xs rounded border-gray-300 px-2 py-1 mb-1">

                                        <option value="menunggu" {{ $laporan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="diterima" {{ $laporan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </form>

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

        <!-- CHARTS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

            <!-- BAR CHART -->
            <x-card>
                <h2 class="text-lg font-semibold mb-4 text-center">Grafik Bulanan</h2>
                <canvas id="chartBulanan"></canvas>
            </x-card>

            <!-- DONUT CHART -->
            <x-card>
                <h2 class="text-lg font-semibold mb-4 text-center">Grafik per Kegiatan</h2>
                <div class="flex justify-center">
                    <div class="w-full max-w-xs sm:max-w-sm">
                        <canvas id="chartKegiatan"></canvas>
                    </div>
                </div>
            </x-card>

        </div>

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    // ================= BAR CHART =================
    new Chart(document.getElementById('chartBulanan'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
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
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // ================= DONUT CHART =================
    new Chart(document.getElementById('chartKegiatan'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($labelKegiatan) !!},
            datasets: [{
                data: {!! json_encode($dataKegiatan) !!},
                backgroundColor: [
                    '#6366F1',
                    '#22C55E',
                    '#F59E0B',
                    '#EF4444',
                ],
                hoverOffset: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let val = context.raw;
                            let persen = ((val / total) * 100).toFixed(1);
                            return `${context.label}: ${val} (${persen}%)`;
                        }
                    }
                }
            }
        }
    });
    </script>

</x-app-layout>