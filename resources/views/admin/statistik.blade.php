@extends('layouts.admin')

@section('title', 'Statistik Laporan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Analisis Laporan</h2>
            <p class="mt-1 text-sm text-gray-400">Lihat pola laporan berdasarkan kegiatan, dosen, hari, dan kelengkapan bukti.</p>
        </div>

        <form method="GET" action="{{ route('admin.statistik') }}" class="flex flex-wrap gap-3">
            <select name="id_kegiatan" class="rounded-lg border-gray-200 text-sm shadow-sm">
                <option value="">Semua Kegiatan</option>
                @foreach($kegiatans as $kegiatan)
                    <option value="{{ $kegiatan->id_kegiatan }}" {{ request('id_kegiatan') == $kegiatan->id_kegiatan ? 'selected' : '' }}>
                        {{ $kegiatan->jenis_kegiatan }}
                    </option>
                @endforeach
            </select>

            <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">Filter</button>
            <a href="{{ route('admin.statistik') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-300">Reset</a>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Total Laporan</p>
            <h2 class="mt-3 text-3xl font-bold text-gray-800">{{ number_format($totalLaporan) }}</h2>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Total Dosen</p>
            <h2 class="mt-3 text-3xl font-bold text-blue-600">{{ number_format($totalDosen) }}</h2>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Jenis Kegiatan</p>
            <h2 class="mt-3 text-3xl font-bold text-green-600">{{ number_format($totalKegiatan) }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-700">Distribusi Laporan per Kegiatan</h2>
                <p class="mt-1 text-sm text-gray-400">Perbandingan jumlah laporan di setiap jenis kegiatan.</p>
            </div>
            <div class="h-[350px]">
                <canvas id="chartKegiatan"></canvas>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-700">Dosen Paling Aktif Melapor</h2>
                <p class="mt-1 text-sm text-gray-400">8 dosen dengan jumlah laporan tertinggi.</p>
            </div>
            <div class="h-[350px]">
                <canvas id="chartDosen"></canvas>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-700">Pola Laporan per Hari</h2>
                <p class="mt-1 text-sm text-gray-400">Hari apa laporan paling sering dicatat.</p>
            </div>
            <div class="h-[350px]">
                <canvas id="chartHari"></canvas>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-700">Kelengkapan Bukti Foto</h2>
                <p class="mt-1 text-sm text-gray-400">Perbandingan laporan dengan dan tanpa foto pendukung.</p>
            </div>
            <div class="h-[350px]">
                <canvas id="chartBukti"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartColors = ['#2563eb', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#14b8a6', '#64748b', '#ec4899'];
    const kegiatanLabels = @json($labelKegiatan);
    const kegiatanColorMap = {
        'Seminar Kerja Praktek': '#2563eb',
        'Seminar Proposal': '#22c55e',
        'Seminar Hasil/Sidang Tertutup': '#f59e0b',
        'Seminar Akhir/Sidang Terbuka': '#ef4444',
    };
    const kegiatanColors = kegiatanLabels.map((label, index) => kegiatanColorMap[label] ?? chartColors[index % chartColors.length]);

    new Chart(document.getElementById('chartKegiatan').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: kegiatanLabels,
            datasets: [{
                data: @json($dataKegiatan),
                backgroundColor: kegiatanColors,
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    new Chart(document.getElementById('chartDosen').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($labelDosen),
            datasets: [{
                label: 'Jumlah Laporan',
                data: @json($dataDosen),
                backgroundColor: '#2563eb',
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: '#f1f5f9'
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('chartHari').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($labelHari),
            datasets: [{
                label: 'Jumlah Laporan',
                data: @json($dataHari),
                backgroundColor: '#22c55e',
                borderRadius: 8
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

    new Chart(document.getElementById('chartBukti').getContext('2d'), {
        type: 'pie',
        data: {
            labels: @json($labelBukti),
            datasets: [{
                data: @json($dataBukti),
                backgroundColor: ['#2563eb', '#e5e7eb'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection
