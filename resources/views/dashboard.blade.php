@extends('layouts.admin')
@section('content')


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="p-6 bg-white-100 min-h-screen">

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

            <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl shadow hover:bg-indigo-700 transition">
                Filter
            </button>

            <a href="{{ route('dashboard') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded-lg">
                Reset
            </a>

        </form>

        <!-- STATISTIK -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm transition hover:shadow-md">
        <div class="flex flex-col gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h1 id="totalLaporan" class="text-3xl font-bold text-gray-800 tracking-tight">{{ $totalLaporan }}</h1>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Total Laporan</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm transition hover:shadow-md">
        <div class="flex flex-col gap-4">
            <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h1 id="menunggu" class="text-3xl font-bold text-gray-800 tracking-tight">{{ $laporanMenunggu }}</h1>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Dalam Proses</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm transition hover:shadow-md">
        <div class="flex flex-col gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h1 id="diterima" class="text-3xl font-bold text-gray-800 tracking-tight">{{ $laporanDiterima }}</h1>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Selesai</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm transition hover:shadow-md">
        <div class="flex flex-col gap-4">
            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h1 id="ditolak" class="text-3xl font-bold text-gray-800 tracking-tight">{{ $laporanDitolak }}</h1>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Ditolak</p>
            </div>
        </div>
    </div>

</div>

<!-- TABEL -->
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Laporan Terbaru</h2>

    <div class="max-h-[400px] overflow-y-auto">
        <table class="w-full text-sm text-left border-collapse">

            <thead class="sticky top-0 z-10 bg-white">
                <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                    <th class="pb-4 px-4">Nama</th>
                    <th class="pb-4 px-4">Kegiatan</th>
                    <th class="pb-4 px-4">Deskripsi</th>
                    <th class="pb-4 px-4 text-center">Bukti</th>
                    <th class="pb-4 px-4 text-center">Status</th>
                    <th class="pb-4 px-4 text-right">Tanggal</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50">
                @forelse ($laporanTerbaru as $laporan)
                <tr class="hover:bg-gray-50 transition group">

                    <td class="py-5 px-4 font-semibold text-gray-700">
                        {{ $laporan->nama_pelapor }}
                    </td>

                    <td class="py-5 px-4 text-gray-500">
                        {{ $laporan->kegiatan }}
                    </td>

                    <td class="py-5 px-4">
                        <p class="max-w-xs truncate text-gray-500" title="{{ $laporan->deskripsi }}">
                            {{ $laporan->deskripsi }}
                        </p>
                    </td>

                    <td class="py-5 px-4">
                        <div class="flex justify-center">
                            @if ($laporan->bukti)
                                <img src="{{ asset('storage/' . $laporan->bukti) }}"
                                     onclick="openModal(this.src)"
                                     class="w-12 h-12 object-cover rounded-xl shadow-sm hover:scale-110 transition cursor-pointer ring-2 ring-white">
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </div>
                    </td>

                    <td class="py-5 px-4 text-center">
                        <div class="flex flex-col items-center gap-1">
                            <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status"
                                    onchange="this.form.submit()"
                                    class="text-[10px] rounded-lg border-gray-200 px-2 py-0.5 mb-1 bg-gray-50 text-gray-500 outline-none focus:ring-1 focus:ring-blue-400">
                                    <option value="menunggu" {{ $laporan->status == 'menunggu' ? 'selected' : '' }}>Set Menunggu</option>
                                    <option value="diterima" {{ $laporan->status == 'diterima' ? 'selected' : '' }}>Set Diterima</option>
                                    <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Set Ditolak</option>
                                </select>
                            </form>

                            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg
                                @if($laporan->status == 'diterima') bg-green-50 text-green-500
                                @elseif($laporan->status == 'ditolak') bg-red-50 text-red-500
                                @else bg-orange-50 text-orange-500
                                @endif">
                                {{ $laporan->status == 'menunggu' ? 'DALAM PROSES' : $laporan->status }}
                            </span>
                        </div>
                    </td>

                    <td class="py-5 px-4 text-right text-gray-400 font-medium">
                        {{ $laporan->created_at->format('d M Y') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400 italic">
                        Tidak ada data laporan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

        <!-- CHARTS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

              <!-- 🔥 MODAL PREVIEW -->
    <div id="imageModal"
         class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">

        <img id="modalImage"
             class="max-w-3xl w-full rounded-lg shadow-lg">
    </div>

            <!-- BAR CHART -->
          <x-card class="p-6 rounded-2xl shadow-md bg-white">
    <h2 class="text-lg font-semibold mb-4 text-gray-700 text-center">
        Grafik Bulanan
    </h2>

    <div class="h-[350px]">
        <canvas id="chartBulanan"></canvas>
    </div>
</x-card>

            <!-- DONUT CHART -->
            <x-card class="p-6 rounded-2xl shadow-md bg-white">
    <h2 class="text-lg font-semibold mb-4 text-gray-700 text-center">
        Grafik per Kegiatan
    </h2>

    <div class="h-[350px]">
        <canvas id="chartKegiatan"></canvas>
    </div>
</x-card>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// =======================
// 🔥 INIT CHART (GLOBAL)
// =======================

const ctx = document.getElementById('chartBulanan').getContext('2d');

// 🎨 Gradient colors
const gradientGray = ctx.createLinearGradient(0, 0, 0, 400);
gradientGray.addColorStop(0, '#d1d5db');
gradientGray.addColorStop(1, '#6b7280');

const gradientGreen = ctx.createLinearGradient(0, 0, 0, 400);
gradientGreen.addColorStop(0, '#4ade80');
gradientGreen.addColorStop(1, '#16a34a');

const gradientRed = ctx.createLinearGradient(0, 0, 0, 400);
gradientRed.addColorStop(0, '#f87171');
gradientRed.addColorStop(1, '#dc2626');

const chartBulanan = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [
            {
                label: 'Menunggu',
                data: @json($dataMenunggu),
                backgroundColor: gradientGray,
                borderRadius: 12,
                barThickness: 18,
                // hoverBackgroundColor: '#4b5563'
            },
            {
                label: 'Diterima',
                data: @json($dataDiterima),
                backgroundColor: gradientGreen,
                borderRadius: 12,
                barThickness: 18
            },
            {
                label: 'Ditolak',
                data: @json($dataDitolak),
                backgroundColor: gradientRed,
                borderRadius: 12,
                barThickness: 18
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        interaction: {
            mode: 'index',
            intersect: false
        },

        animation: {
            duration: 1200,
            easing: 'easeOutQuart'
        },

        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: '#374151',
                    font: {
                        size: 12,
                        weight: '600'
                    }
                }
            },
            tooltip: {
                backgroundColor: '#111827',
                titleColor: '#fff',
                bodyColor: '#d1d5db',
                borderColor: '#374151',
                borderWidth: 1,
                padding: 10,
                cornerRadius: 8
            }
        },

        scales: {
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#6b7280'
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#6b7280',
                    precision: 0
                },
                grid: {
                    color: '#e5e7eb',
                    drawBorder: false
                }
            }
        }
    }
});

const ctx2 = document.getElementById('chartKegiatan').getContext('2d');

const chartKegiatan = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($labelKegiatan) !!},
        datasets: [{
            data: {!! json_encode($dataKegiatan) !!},
            backgroundColor: [
                '#6366F1',
                '#22C55E',
                '#F59E0B',
                '#EF4444'
            ],
            borderWidth: 0,
            hoverOffset: 12
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%', // 🔥 bikin donut modern

        animation: {
            animateScale: true,
            animateRotate: true,
            duration: 1200
        },

        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#374151',
                    padding: 15,
                    font: {
                        size: 12
                    }
                }
            },
            tooltip: {
                backgroundColor: '#111827',
                titleColor: '#fff',
                bodyColor: '#d1d5db',
                padding: 10,
                cornerRadius: 8
            }
        }
    }
});

// =======================
// 🔁 REALTIME UPDATE
// =======================

function loadRealtimeData() {

    const kegiatan = document.querySelector('select[name="kegiatan"]').value;

    fetch(`/dashboard/data?kegiatan=${kegiatan}`)
        .then(res => res.json())
        .then(data => {

            // ===================
            // 🔢 UPDATE STAT
            // ===================
            document.getElementById('totalLaporan').innerText = data.total;
            document.getElementById('menunggu').innerText = data.menunggu;
            document.getElementById('diterima').innerText = data.diterima;
            document.getElementById('ditolak').innerText = data.ditolak;


            // ===================
            // 📋 UPDATE TABLE
            // ===================
            let tbody = document.getElementById("tableLaporan");
            let html = '';

            data.latest.forEach(item => {
                html += `
                <tr class="hover:bg-gray-50 transition">

                    <td class="py-3">${item.nama_pelapor}</td>
                    <td>${item.kegiatan}</td>

                    <td>
                        ${item.bukti 
                            ? `<a href="/storage/${item.bukti}" target="_blank">
                                <img src="/storage/${item.bukti}" class="w-16 h-16 object-cover rounded shadow">
                               </a>`
                            : '-'
                        }
                    </td>

                    <td>
                        <form action="/laporan/${item.id}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <select name="status"
                                onchange="this.form.submit()"
                                class="text-xs rounded border-gray-300 px-2 py-1 mb-1">

                                <option value="menunggu" ${item.status == 'menunggu' ? 'selected' : ''}>Menunggu</option>
                                <option value="diterima" ${item.status == 'diterima' ? 'selected' : ''}>Diterima</option>
                                <option value="ditolak" ${item.status == 'ditolak' ? 'selected' : ''}>Ditolak</option>

                            </select>
                        </form>

                        <span class="px-3 py-1 text-xs rounded-full font-semibold
                            ${item.status == 'diterima' ? 'bg-green-100 text-green-600' : ''}
                            ${item.status == 'ditolak' ? 'bg-red-100 text-red-600' : ''}
                            ${item.status == 'menunggu' ? 'bg-yellow-100 text-yellow-600' : ''}
                        ">
                            ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                        </span>
                    </td>

                    <td>${new Date(item.created_at).toLocaleDateString()}</td>

                </tr>
                `;
            });

            tbody.innerHTML = html;


            // ===================
            // 📊 UPDATE CHART BULANAN (SMOOTH)
            // ===================
            chartBulanan.data.datasets[0].data = data.dataMenunggu ?? chartBulanan.data.datasets[0].data;
            chartBulanan.data.datasets[1].data = data.dataDiterima ?? chartBulanan.data.datasets[1].data;
            chartBulanan.data.datasets[2].data = data.dataDitolak ?? chartBulanan.data.datasets[2].data;

            chartBulanan.update('active');


            // ===================
            // 🥧 UPDATE CHART KEGIATAN
            // ===================
            if (data.labelKegiatan && data.dataKegiatan) {
                chartKegiatan.data.labels = data.labelKegiatan;
                chartKegiatan.data.datasets[0].data = data.dataKegiatan;

                chartKegiatan.update();
            }

        });
}

// pertama kali load
loadRealtimeData();

// refresh tiap 5 detik
setInterval(loadRealtimeData, 5000);

// ================= MODAL =================
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

// klik luar
document.getElementById('imageModal').addEventListener('click', function(e){
    if(e.target === this) closeModal();
});

// ESC
document.addEventListener('keydown', function(e){
    if(e.key === "Escape") closeModal();
});

</script>

@endsection