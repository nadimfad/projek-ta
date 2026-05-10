<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Laporan - Sikawan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body{
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#f5f7fb]">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-[260px] bg-white border-r border-gray-100 flex flex-col justify-between sticky top-0 h-screen">

        <div>

            <!-- LOGO -->
            <div class="flex items-center gap-3 px-6 py-8">

                <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg">

                    <!-- ICON -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 3l7 4v5c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V7l7-4z"/>
                    </svg>

                </div>

                <div>
                    <h1 class="text-x1 font-bold text-slate-800 tracking-tight">
                        SIKAWAN
                    </h1>
                </div>

            </div>

            <!-- MENU -->
            <div class="px-4 mt-5 space-y-3">

                <a href="{{ route('laporan.index') }}"
                   class="flex items-center gap-4 bg-blue-50 text-blue-600 px-5 py-4 rounded-2xl font-semibold">

                    <!-- ICON -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2
                            2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                    </svg>

                    Laporan Saya
                </a>

                <a href="#"
                   class="flex items-center gap-4 text-slate-600 hover:bg-gray-100 px-5 py-4 rounded-2xl font-medium transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0
                            4.847.655 6.879 1.804M15 11a3 3 0 11-6
                            0 3 3 0 016 0z"/>
                    </svg>

                    Profil
                </a>

            </div>

        </div>

        <!-- LOGOUT -->
        <div class="p-6">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="flex items-center gap-3 text-red-500 font-semibold hover:opacity-80 transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4
                            4H7m6 4v1m0-10V4"/>
                    </svg>

                    Keluar
                </button>

            </form>

        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-4xl font-bold text-slate-800">
                    Halo, {{ auth()->user()->name }}!
                </h1>

                <p class="text-sm text-slate-400 mt-1">
                    Pantau status laporan gratifikasi Anda di sini.
                </p>

            </div>

            <!-- BUTTON -->
            <a href="{{ route('laporan.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow-lg shadow-blue-100 transition hover:-translate-y-0.5 flex items-center gap-2">

                + Tambah Laporan
            </a>

        </div>

     <!-- CARD STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <!-- TOTAL -->
    <div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100/50">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-800 leading-none">
                    {{ $laporans->count() }}
                </h3>
                <p class="text-slate-400 mt-1 text-xs uppercase tracking-wider font-bold">
                    Total Laporan
                </p>
            </div>
        </div>
    </div>

    <!-- DIPROSES -->
    <div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100/50">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-800 leading-none">
                    {{ $laporans->where('status','diproses')->count() }}
                </h3>
                <p class="text-slate-400 mt-1 text-xs uppercase tracking-wider font-bold">
                    Sedang Diproses
                </p>
            </div>
        </div>
    </div>

    <!-- SELESAI -->
    <div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100/50">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-800 leading-none">
                    {{ $laporans->where('status','selesai')->count() }}
                </h3>
                <p class="text-slate-400 mt-1 text-xs uppercase tracking-wider font-bold">
                    Selesai
                </p>
            </div>
        </div>
    </div>

</div>

        <!-- TABLE -->
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100/50 overflow-hidden">

            <!-- HEADER -->
            <div class="p-6 flex justify-between items-center">

                <h2 class="text-2xl font-bold text-[#0f172a]">
                    Riwayat Laporan Terbaru
                </h2>

                <form method="GET" action="{{ route('laporan.index') }}">

                    <input type="text"
                        name="search"
                        placeholder="Cari Riwayat..."
                        class="w-[300px] bg-gray-100 border-none rounded-2xl px-6 py-2 focus:ring-2 focus:ring-blue-500">

                </form>

            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50/50 text-slate-400 uppercase text-[11px] tracking-widest">

                        <tr>

                            <th class="px-6 py-4 text-left font-semibold">
                                Nama
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Kegiatan
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Bukti
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-50">

                        @forelse($laporans as $laporan)

                        <tr class="hover:bg-slate-50 transition">

                            <!-- NAMA -->
                            <td class="px-6 py-4 font-semibold text-blue-600">
                                {{ $laporan->nama_pelapor }}
                            </td>

                            <!-- KEGIATAN -->
                            <td class="px-6 py-4 text-slate-600">
                                {{ $laporan->kegiatan }}
                            </td>

                            <!-- STATUS -->
                            <td class="px-6 py-4">

                                @if($laporan->status == 'selesai')

                                    <span class="bbg-green-100 text-green-700 px-3 py-1 rounded-lg text-[10px] font-bold uppercase">
                                        SELESAI
                                    </span>

                                @elseif($laporan->status == 'diproses')

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-[10px] font-bold uppercase">
                                        PROSES
                                    </span>

                                @else

                                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-lg text-[10px] font-bold uppercase">
                                        MENUNGGU
                                    </span>

                                @endif

                            </td>

                            <!-- TANGGAL -->
                            <td class="px-6 py-4 text-slate500">
                                {{ $laporan->created_at->format('d M Y') }}
                            </td>

                            <!-- BUKTI -->
                            <td class="px-6 py-4 text-center">

                                @if($laporan->bukti)

                                    <img src="{{ asset('storage/'.$laporan->bukti) }}"
                                        class="w-16 h-16 object-cover rounded-2xl shadow cursor-pointer hover:scale-110 transition">

                                @else

                                    <span class="text-gray-400">
                                        Tidak Ada
                                    </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5"
                                class="text-center py-12 text-slate-400 text-lg">

                                Belum ada laporan

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Login Berhasil',
        text: '{{ session('success') }}',
        timer: 1800,
        showConfirmButton: false
    });
</script>
@endif
</body>
</html>