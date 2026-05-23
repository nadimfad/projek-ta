@extends('layouts.admin')

@section('title', 'Statistik Laporan')

@section('content')
<div class="space-y-6">
    <form method="GET" action="{{ route('admin.statistik') }}" class="flex flex-wrap gap-3">
        <select name="id_kegiatan" class="border-gray-200 rounded-lg shadow-sm text-sm">
            <option value="">Semua Kegiatan</option>
            @foreach($kegiatans as $kegiatan)
                <option value="{{ $kegiatan->id_kegiatan }}" {{ request('id_kegiatan') == $kegiatan->id_kegiatan ? 'selected' : '' }}>
                    {{ $kegiatan->jenis_kegiatan }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Filter</button>
        <a href="{{ route('admin.statistik') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">Reset</a>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Laporan</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-3">{{ $totalLaporan }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Dosen</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-3">{{ $totalDosen }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Jenis Kegiatan</p>
            <h2 class="text-3xl font-bold text-green-600 mt-3">{{ $totalKegiatan }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Grafik Laporan Bulanan</h2>
            <div class="h-[350px]">
                <canvas id="chartBulanan"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Grafik per Kegiatan</h2>
            <div class="h-[350px]">
                <canvas id="chartKegiatan"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('chartBulanan').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [
                { label: 'Total Laporan', data: @json($dataBulanan), backgroundColor: '#2563eb', borderRadius: 8 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    new Chart(document.getElementById('chartKegiatan').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: @json($labelKegiatan),
            datasets: [{
                data: @json($dataKegiatan),
                backgroundColor: ['#2563eb', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#14b8a6'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
