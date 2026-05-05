<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sigap - Sistem Pelaporan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

<!-- ================= NAVBAR ================= -->
<header class="bg-white shadow-sm fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- LOGO -->
        <div class="flex items-center gap-2 font-bold text-lg">
            <div class="w-8 h-8 bg-indigo-600 text-white flex items-center justify-center rounded-lg">
                🔒
            </div>
            SIGAP
        </div>
        
        <!-- MENU -->
        <nav class="hidden md:flex gap-8 text-sm font-medium">
            <a href="#" class="hover:text-indigo-600">Tentang</a>
            <a href="#" class="hover:text-indigo-600">Cara Kerja</a>
            <a href="#" class="hover:text-indigo-600">FAQ</a>
        </nav>

        <!-- ACTION -->
        <div class="flex items-center gap-4">
            <a href="{{ route('laporan.create') }}"
               class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition">
               Laporkan Sekarang
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-gray-500 hover:text-red-500">
                    Logout
                </button>
            </form>
        </div>

    </div>
</header>


<!-- ================= HERO ================= -->
<section class="pt-32 pb-20 text-center px-6">

    <div class="max-w-4xl mx-auto">

        <!-- BADGE -->
        <div class="inline-block px-4 py-2 text-sm bg-indigo-100 text-indigo-600 rounded-full mb-6">
            🔐 KEAMANAN DATA TERJAMIN 100%
        </div>

        <!-- TITLE -->
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
            Wujudkan Integritas <br>
            <span class="text-indigo-600">Tanpa Kompromi</span>
        </h1>

        <!-- SUBTITLE -->
        <p class="text-gray-500 text-lg mb-10">
            Platform digital resmi untuk pelaporan penerimaan gratifikasi.
            Cepat, aman, dan tanpa biaya. Bersama, kita lawan korupsi.
        </p>

        <!-- BUTTON -->
        <div class="flex justify-center gap-4 flex-wrap">

            <a href="{{ route('laporan.create') }}"
               class="bg-indigo-600 text-white px-6 py-3 rounded-full shadow hover:bg-indigo-700 transition">
               Mulai Melapor →
            </a>

            <a href="#"
               class="bg-gray-200 text-gray-700 px-6 py-3 rounded-full hover:bg-gray-300 transition">
               Pelajari Lebih Lanjut
            </a>

        </div>

    </div>

</section>

<!-- ================= CARA MELAPOR ================= -->
<section class="bg-white py-20 px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">

        <!-- LEFT CONTENT -->
        <div>

            <p class="text-indigo-600 font-semibold mb-3 tracking-wide">
                CARA MELAPOR
            </p>

            <h2 class="text-3xl md:text-4xl font-bold mb-10">
                Proses Pelaporan yang <br>
                Mudah & Cepat
            </h2>

            <!-- STEP LIST -->
            <div class="space-y-10 relative">

                <!-- garis vertical -->
                <div class="absolute left-5 top-0 bottom-0 w-[2px] bg-gray-200"></div>

                <!-- STEP 1 -->
                <div class="flex items-start gap-6 relative">
                    <div class="z-10 w-10 h-10 flex items-center justify-center 
                        rounded-full border-2 border-indigo-500 text-indigo-600 font-bold bg-white">
                        01
                    </div>

                    <div>
                        <h3 class="font-semibold text-lg">Siapkan Data</h3>
                        <p class="text-gray-500">
                            Kumpulkan detail kejadian, penerima/pemberi, dan bukti pendukung (foto/dokumen).
                        </p>
                    </div>
                </div>

                <!-- STEP 2 -->
                <div class="flex items-start gap-6 relative">
                    <div class="z-10 w-10 h-10 flex items-center justify-center 
                        rounded-full border-2 border-indigo-500 text-indigo-600 font-bold bg-white">
                        02
                    </div>

                    <div>
                        <h3 class="font-semibold text-lg">Isi Formulir</h3>
                        <p class="text-gray-500">
                            Lengkapi data melalui platform. Anda dapat memilih untuk tetap anonim.
                        </p>
                    </div>
                </div>

                <!-- STEP 3 -->
                <div class="flex items-start gap-6 relative">
                    <div class="z-10 w-10 h-10 flex items-center justify-center 
                        rounded-full border-2 border-indigo-500 text-indigo-600 font-bold bg-white">
                        03
                    </div>

                    <div>
                        <h3 class="font-semibold text-lg">Verifikasi & Tindak Lanjut</h3>
                        <p class="text-gray-500">
                            Tim akan meninjau laporan Anda dan memberikan tindak lanjut sesuai prosedur.
                        </p>
                    </div>
                </div>
                
            </div>

        </div>

        <!-- RIGHT CONTENT (MOCKUP UI) -->
        <div class="bg-gray-100 rounded-3xl p-6 shadow-inner">

            <!-- header fake window -->
            <div class="flex items-center gap-2 mb-4">
                <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                <div class="w-3 h-3 bg-green-400 rounded-full"></div>

                <span class="ml-auto text-xs text-gray-400">
                    SIGAP SECURE PORTAL
                </span>
            </div>

            <!-- fake form -->
            <div class="space-y-4">

                <div class="h-10 bg-gray-200 rounded-lg"></div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="h-28 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-sm">
                        Upload Bukti
                    </div>
                    <div class="h-28 bg-gray-200 rounded-lg"></div>
                </div>

                <div class="h-10 bg-gray-200 rounded-lg"></div>

                <div class="h-12 bg-indigo-600 rounded-lg"></div>

            </div>

        </div>

    </div>
</section>
<!-- ================= CONTENT DINAMIS ================= -->
<main class="max-w-7xl mx-auto px-6 pb-10">
    @yield('content')
</main>

</body>
</html>