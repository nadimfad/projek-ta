@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Ringkasan Laporan</h2>
            <p class="mt-1 text-sm text-gray-400">Pantau aktivitas laporan, dosen pelapor, dan data pengguna SIGAP.</p>
        </div>

        <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#2563EB] px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
            Lihat Semua Laporan
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-400">Total Laporan</p>
            <p class="mt-3 text-3xl font-bold text-gray-800">{{ number_format($totalLaporan) }}</p>
            <p class="mt-2 text-xs text-gray-400">Seluruh laporan yang tersimpan.</p>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-400">Laporan Minggu Ini</p>
            <p class="mt-3 text-3xl font-bold text-blue-600">{{ number_format($laporanMingguIni) }}</p>
            <p class="mt-2 text-xs text-gray-400">Berdasarkan tanggal kegiatan.</p>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-400">Laporan Bulan Ini</p>
            <p class="mt-3 text-3xl font-bold text-green-600">{{ number_format($laporanBulanIni) }}</p>
            <p class="mt-2 text-xs text-gray-400">Akumulasi bulan berjalan.</p>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-400">Dosen Pelapor</p>
            <p class="mt-3 text-3xl font-bold text-red-600">{{ number_format($totalDosenPelapor) }}</p>
            <p class="mt-2 text-xs text-gray-400">Dosen yang pernah mengirim laporan.</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.7fr_0.9fr]">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Grafik 12 Bulan Terakhir</h3>
                    <p class="mt-1 text-sm text-gray-400">Jumlah laporan berdasarkan tanggal kegiatan.</p>
                </div>
            </div>
            <div class="h-[320px]">
                <canvas id="monthlyReportChart"></canvas>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800">Data User</h3>
            <p class="mt-1 text-sm text-gray-400">Komposisi pengguna sistem.</p>

            <div class="mt-6 space-y-4">
                <div class="flex items-center justify-between rounded-xl bg-gray-50 p-4">
                    <span class="font-semibold text-gray-600">Admin</span>
                    <span class="rounded-lg bg-blue-100 px-3 py-1 text-sm font-bold text-blue-700">{{ number_format($totalAdmin) }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl bg-gray-50 p-4">
                    <span class="font-semibold text-gray-600">Dosen</span>
                    <span class="rounded-lg bg-green-100 px-3 py-1 text-sm font-bold text-green-700">{{ number_format($totalDosen) }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl bg-gray-900 p-4">
                    <span class="font-semibold text-white">Total Pengguna</span>
                    <span class="rounded-lg bg-white px-3 py-1 text-sm font-bold text-gray-900">{{ number_format($totalPengguna) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.55fr_0.95fr]">
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 px-6 py-5">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Laporan Terbaru</h3>
                    <p class="mt-1 text-sm text-gray-400">10 laporan paling baru yang masuk.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[840px] text-center text-sm">
                    <thead class="bg-gray-50 text-[11px] uppercase tracking-widest text-gray-400">
                        <tr>
                            <th class="px-5 py-4 font-semibold">Dosen</th>
                            <th class="px-5 py-4 font-semibold">Mahasiswa</th>
                            <th class="px-5 py-4 font-semibold">Kegiatan</th>
                            <th class="px-5 py-4 font-semibold">Bentuk</th>
                            <th class="px-5 py-4 font-semibold">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                        @forelse ($laporanTerbaru as $laporan)
                        <tr class="transition hover:bg-gray-50">
                            <td class="px-5 py-4 font-semibold text-gray-700">{{ $laporan->dosen?->nama ?? '-' }}</td>
                            <td class="px-5 py-4 text-gray-500">{{ $laporan->nama_mahasiswa }}</td>
                            <td class="px-5 py-4">
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
                                <span class="inline-flex max-w-full justify-center whitespace-normal break-words rounded-lg px-2 py-1 text-[10px] font-bold uppercase leading-snug tracking-wide {{ $warnaKegiatan }}">
                                    {{ $jenisKegiatan ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-gray-500">{{ $laporan->bentuk_gratifikasi }}</td>
                            <td class="whitespace-nowrap px-5 py-4 font-medium text-gray-400">{{ $laporan->tanggal_kegiatan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">Belum ada laporan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800">Dosen Paling Sering Melapor</h3>
            <p class="mt-1 text-sm text-gray-400">Diurutkan berdasarkan jumlah laporan.</p>

            <div id="dosenPelaporPanel" class="mt-6 transition-opacity duration-200">
                @include('admin.partials.dosen-pelapor')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyReportChart = document.getElementById('monthlyReportChart').getContext('2d');

    new Chart(monthlyReportChart, {
        type: 'line',
        data: {
            labels: @json($labelBulanan),
            datasets: [{
                label: 'Jumlah Laporan',
                data: @json($dataBulanan),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.12)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: '#f1f5f9'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    const dosenPelaporPanel = document.getElementById('dosenPelaporPanel');

    dosenPelaporPanel.addEventListener('click', async function (event) {
        const link = event.target.closest('[data-dosen-page]');

        if (!link) {
            return;
        }

        event.preventDefault();
        dosenPelaporPanel.classList.add('opacity-50');

        try {
            const response = await fetch(link.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal memuat data dosen.');
            }

            dosenPelaporPanel.innerHTML = await response.text();
        } finally {
            dosenPelaporPanel.classList.remove('opacity-50');
        }
    });
</script>
@endsection
