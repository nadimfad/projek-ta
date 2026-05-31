@extends('admin.layout')

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

            <input type="hidden" id="statistikDateFrom" name="date_from" value="{{ request('date_from') }}">
            <input type="hidden" id="statistikDateTo" name="date_to" value="{{ request('date_to') }}">

            <button type="button" onclick="openDateRangeModal()" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span id="dateRangeLabel">
                    @if (request('date_from') && request('date_to'))
                        {{ request('date_from') }} - {{ request('date_to') }}
                    @else
                        Pilih Rentang Tanggal
                    @endif
                </span>
            </button>

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

<div id="dateRangeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Pilih Rentang Tanggal</h3>
                <p class="mt-1 text-sm text-gray-400">Tentukan tanggal awal dan akhir laporan.</p>
            </div>
            <button type="button" onclick="closeDateRangeModal()" class="rounded-lg bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-600 hover:bg-gray-200">Tutup</button>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-600">Tanggal Mulai</label>
                <input type="date" id="dateRangeFromInput" value="{{ request('date_from') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-600">Tanggal Akhir</label>
                <input type="date" id="dateRangeToInput" value="{{ request('date_to') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="clearDateRange()" class="rounded-xl bg-gray-100 px-4 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-200">Hapus</button>
            <button type="button" onclick="applyDateRange()" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">Gunakan Rentang</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dateRangeModal = document.getElementById('dateRangeModal');
    const statistikDateFrom = document.getElementById('statistikDateFrom');
    const statistikDateTo = document.getElementById('statistikDateTo');
    const dateRangeFromInput = document.getElementById('dateRangeFromInput');
    const dateRangeToInput = document.getElementById('dateRangeToInput');
    const dateRangeLabel = document.getElementById('dateRangeLabel');

    function openDateRangeModal() {
        dateRangeModal.classList.remove('hidden');
        dateRangeModal.classList.add('flex');
    }

    function closeDateRangeModal() {
        dateRangeModal.classList.add('hidden');
        dateRangeModal.classList.remove('flex');
    }

    function applyDateRange() {
        if (dateRangeFromInput.value && dateRangeToInput.value && dateRangeToInput.value < dateRangeFromInput.value) {
            dateRangeToInput.setCustomValidity('Tanggal akhir tidak boleh sebelum tanggal mulai.');
            dateRangeToInput.reportValidity();
            dateRangeToInput.setCustomValidity('');
            return;
        }

        statistikDateFrom.value = dateRangeFromInput.value;
        statistikDateTo.value = dateRangeToInput.value;
        dateRangeLabel.innerText = dateRangeFromInput.value && dateRangeToInput.value
            ? `${dateRangeFromInput.value} - ${dateRangeToInput.value}`
            : 'Pilih Rentang Tanggal';
        closeDateRangeModal();
    }

    function clearDateRange() {
        dateRangeFromInput.value = '';
        dateRangeToInput.value = '';
        statistikDateFrom.value = '';
        statistikDateTo.value = '';
        dateRangeLabel.innerText = 'Pilih Rentang Tanggal';
        closeDateRangeModal();
    }

    dateRangeModal.addEventListener('click', function (event) {
        if (event.target === dateRangeModal) {
            closeDateRangeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDateRangeModal();
        }
    });

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
