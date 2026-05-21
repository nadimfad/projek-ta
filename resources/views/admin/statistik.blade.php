@extends('layouts.admin')

@section('title', 'Statistik Laporan')

@section('content')
<div class="space-y-6">
    <form method="GET" action="{{ route('admin.statistik') }}" class="flex flex-wrap gap-3">
        <select name="kegiatan" class="border-gray-200 rounded-lg shadow-sm text-sm">
            <option value="">Semua Kegiatan</option>
            <option value="Seminar Kerja Praktek" {{ request('kegiatan') == 'Seminar Kerja Praktek' ? 'selected' : '' }}>Seminar Kerja Praktek</option>
            <option value="Seminar Proposal" {{ request('kegiatan') == 'Seminar Proposal' ? 'selected' : '' }}>Seminar Proposal</option>
            <option value="Seminar Hasil/Sidang Tertutup" {{ request('kegiatan') == 'Seminar Hasil/Sidang Tertutup' ? 'selected' : '' }}>Seminar Hasil</option>
            <option value="Seminar Akhir/Sidang Terbuka" {{ request('kegiatan') == 'Seminar Akhir/Sidang Terbuka' ? 'selected' : '' }}>Seminar Akhir</option>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Filter</button>
        <a href="{{ route('admin.statistik') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">Reset</a>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Laporan</p>
            <h2 id="totalLaporan" class="text-3xl font-bold text-gray-800 mt-3">{{ $totalLaporan }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Dalam Proses</p>
            <h2 id="menunggu" class="text-3xl font-bold text-orange-500 mt-3">{{ $laporanMenunggu }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Diterima</p>
            <h2 id="diterima" class="text-3xl font-bold text-green-600 mt-3">{{ $laporanDiterima }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Ditolak</p>
            <h2 id="ditolak" class="text-3xl font-bold text-red-600 mt-3">{{ $laporanDitolak }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Grafik Bulanan</h2>
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
    const ctx = document.getElementById('chartBulanan').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [
                { label: 'Menunggu', data: @json($dataMenunggu), backgroundColor: '#f59e0b', borderRadius: 8 },
                { label: 'Diterima', data: @json($dataDiterima), backgroundColor: '#22c55e', borderRadius: 8 },
                { label: 'Ditolak', data: @json($dataDitolak), backgroundColor: '#ef4444', borderRadius: 8 }
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
                backgroundColor: ['#2563eb', '#22c55e', '#f59e0b', '#ef4444'],
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
