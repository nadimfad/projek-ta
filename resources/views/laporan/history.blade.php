<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>History Laporan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-[260px] bg-white border-r border-gray-100 flex flex-col justify-between h-screen sticky top-0">

        <div>

            <!-- LOGO -->
            <div class="flex items-center gap-3 px-6 py-8">

                <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg">

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

                <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                    SIGAP
                </h1>

            </div>

            <!-- MENU -->
            <div class="px-4 mt-5 space-y-3">

                <a href="{{ route('laporan.index') }}"
                   class="flex items-center gap-4 text-slate-600 hover:bg-gray-100 px-5 py-4 rounded-2xl font-medium transition">
 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>


                    Dashboard
                </a>

                <a href="{{ route('laporan.history') }}"
                   class="flex items-center gap-4 bg-blue-50 text-blue-600 px-5 py-4 rounded-2xl font-bold">

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


                    Riwayat Laporan
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

    <!-- CONTENT -->
    <main class="flex-1 p-10">

        <!-- HEADER -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    Riwayat Seluruh Laporan
                </h1>

                <p class="text-slate-500 mt-1">
                    Semua riwayat laporan yang pernah dikirim
                </p>
            </div>

            <!-- SEARCH -->
            <form method="GET" action="{{ route('laporan.history') }}">

                <input type="text"
                    name="search"
                    placeholder="Cari laporan..."
                    value="{{ request('search') }}"
                    class="w-full md:w-[300px] bg-white border border-slate-200 rounded-2xl px-5 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

            </form>

        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-[28px] shadow-sm border border-slate-100 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] tracking-wider">

                        <tr>

                            <th class="px-6 py-5 text-left font-semibold">
                                Kegiatan
                            </th>

                            <th class="px-6 py-5 text-left font-semibold">
                                Status
                            </th>

                            <th class="px-6 py-5 text-left font-semibold">
                                Tanggal
                            </th>

                            <th class="px-6 py-5 text-center font-semibold">
                                Bukti
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($laporans as $laporan)

                        <tr class="hover:bg-slate-50 transition duration-200">

                            <td class="px-6 py-5 font-semibold text-slate-800">
                                {{ $laporan->kegiatan }}
                            </td>

                            <td class="px-6 py-5">

                                @if($laporan->status == 'diterima')

                                    <span class="bg-green-100 text-green-700 px-4 py-1.5 rounded-xl text-[11px] font-bold uppercase">
                                        Diterima
                                    </span>

                                @elseif($laporan->status == 'ditolak')

                                    <span class="bg-red-100 text-red-700 px-4 py-1.5 rounded-xl text-[11px] font-bold uppercase">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="bg-yellow-100 text-yellow-700 px-4 py-1.5 rounded-xl text-[11px] font-bold uppercase">
                                        Menunggu
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5 text-slate-500">
                                {{ $laporan->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-5 text-center">

                                @if ($laporan->bukti)

                                    <img src="{{ asset('storage/' . $laporan->bukti) }}"
                                        onclick="openModal(this.src)"
                                        class="w-16 h-16 object-cover rounded-2xl shadow-sm cursor-pointer hover:scale-110 transition duration-300 mx-auto">

                                @else

                                    <span class="text-slate-400">
                                        Tidak Ada
                                    </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4"
                                class="text-center py-14 text-slate-400 text-lg">

                                Belum ada history laporan

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

<!-- MODAL -->
<div id="imageModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50 backdrop-blur-sm">

    <img id="modalImage"
         class="max-w-4xl w-full rounded-3xl shadow-2xl">

</div>

<script>

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

    document.getElementById('imageModal')
        .addEventListener('click', function(e){

        if(e.target === this){
            closeModal();
        }

    });

    document.addEventListener('keydown', function(e){

        if(e.key === "Escape"){
            closeModal();
        }

    });

</script>

</body>
</html>