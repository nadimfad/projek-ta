<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Sigap - Sistem Pelaporan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800">

<!-- ================= NAVBAR ================= -->
<header class="bg-white/80 backdrop-blur-md fixed w-full z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- LOGO -->
        <div class="flex items-center gap-3 ml-4">
            <img src="{{ asset('images/logo1.png') }}" class="h-16">
            <span class="text-xl font-bold"></span>
        </div>

        <!-- MENU -->
        <div class="flex items-center gap-8 text-sm font-medium">
            <a href="#cara-kerja" class="hover:text-indigo-600 transition">Cara Kerja</a>
            <a href="#faq" class="hover:text-indigo-600 transition">FAQ</a>

            @auth
            <a href="{{ route('laporan.create') }}"
               class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition">
               Laporkan
            </a>
            @else
            <a href="{{ route('login') }}"
               class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition">
               Login
            </a>
            @endauth
        </div>

    </div>
</header>

<!-- ================= HERO ================= -->
<section class="pt-32 pb-20 text-center px-6 mb-8">
    <div class="max-w-4xl mx-auto">

        <div data-aos="zoom-in"
             class="inline-block px-4 py-2 text-sm font-bold bg-indigo-100 text-indigo-600 rounded-full mb-6">
            KEAMANAN DATA TERJAMIN 100%
        </div>

        <h1 data-aos="fade-up"
            class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
            Wujudkan Integritas <br>
            <span class="text-indigo-600">Tanpa Kompromi</span>
        </h1>

        <p data-aos="fade-up" data-aos-delay="100"
           class="text-gray-500 text-lg mb-10">
            Platform digital resmi untuk pelaporan gratifikasi.
            Cepat, aman, dan tanpa biaya.
        </p>

        <div data-aos="fade-up" data-aos-delay="200"
             class="flex justify-center gap-4 flex-wrap">

            <a href="{{ route('laporan.create') }}"
               class="bg-indigo-600 text-white px-6 py-3 rounded-full shadow hover:scale-105 hover:bg-indigo-700 transition">
               Mulai Melapor →
            </a>

        </div>

    </div>
</section>

<!-- ================= CARA MELAPOR ================= -->
<section id="cara-kerja" class="bg-white py-20 px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">

        <!-- LEFT -->
        <div data-aos="fade-right">
            <p class="text-indigo-600 font-semibold mb-3">CARA MELAPOR</p>

            <h2 class="text-3xl md:text-4xl font-bold mb-10">
                Proses Mudah & Cepat
            </h2>

            <div class="space-y-10 relative">

                <div class="absolute left-5 top-0 bottom-0 w-[2px] bg-gray-200"></div>

                <!-- STEP -->
                <div class="flex gap-6">
                    <div class="w-10 h-10 flex items-center justify-center 
                        rounded-full border-2 border-indigo-500 text-indigo-600 font-bold">
                        01
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Siapkan Data</h3>
                        <p class="text-gray-500">Kumpulkan bukti dan detail kejadian</p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="w-10 h-10 flex items-center justify-center 
                        rounded-full border-2 border-indigo-500 text-indigo-600 font-bold">
                        02
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Isi Formulir</h3>
                        <p class="text-gray-500">Isi data dengan lengkap (bisa anonim)</p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="w-10 h-10 flex items-center justify-center 
                        rounded-full border-2 border-indigo-500 text-indigo-600 font-bold">
                        03
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Verifikasi</h3>
                        <p class="text-gray-500">Tim akan memproses laporan Anda</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT MOCKUP -->
        <div data-aos="fade-left"
             class="bg-gray-100 rounded-3xl p-6 shadow-inner hover:scale-105 transition">

            <div class="space-y-4 animate-pulse">
                <div class="h-10 bg-gray-200 rounded"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="h-28 bg-gray-200 rounded"></div>
                    <div class="h-28 bg-gray-200 rounded"></div>
                </div>
                <div class="h-10 bg-gray-200 rounded"></div>
                <div class="h-12 bg-indigo-600 rounded"></div>
            </div>

        </div>

    </div>
</section>

<!-- ================= FAQ ================= -->
<section id="faq" class="bg-gray-50 py-20 px-6 mb-4">

    <div class="max-w-4xl mx-auto text-center mb-12" data-aos="fade-up">
        <h2 class="text-3xl font-bold mb-4">FAQ</h2>
        <p class="text-gray-500">Pertanyaan umum seputar sistem</p>
    </div>

    <div class="max-w-3xl mx-auto space-y-4">

    <!-- ITEM 1 -->
    <div class="group bg-white rounded-xl shadow p-5 cursor-pointer transition hover:shadow-lg">

        <div class="flex justify-between items-center">
            <h3 class="font-semibold">Apakah laporan saya aman?</h3>
            <span class="transition group-hover:rotate-45 text-xl">+</span>
        </div>

        <p class="mt-3 text-gray-500 max-h-0 overflow-hidden opacity-0 
                  group-hover:max-h-40 group-hover:opacity-100 
                  transition-all duration-500">
            Ya, sistem kami menjamin keamanan data dan kerahasiaan pelapor.
        </p>

    </div>

    <!-- ITEM 2 -->
    <div class="group bg-white rounded-xl shadow p-5 cursor-pointer transition hover:shadow-lg">

        <div class="flex justify-between items-center">
            <h3 class="font-semibold">Apakah bisa melapor secara anonim?</h3>
            <span class="transition group-hover:rotate-45 text-xl">+</span>
        </div>

        <p class="mt-3 text-gray-500 max-h-0 overflow-hidden opacity-0 
                  group-hover:max-h-40 group-hover:opacity-100 
                  transition-all duration-500">
            Bisa, Anda dapat memilih untuk tidak menampilkan identitas.
        </p>

    </div>

    <!-- ITEM 3 -->
    <div class="group bg-white rounded-xl shadow p-5 cursor-pointer transition hover:shadow-lg">

        <div class="flex justify-between items-center">
            <h3 class="font-semibold">Berapa lama proses verifikasi?</h3>
            <span class="transition group-hover:rotate-45 text-xl">+</span>
        </div>

        <p class="mt-3 text-gray-500 max-h-0 overflow-hidden opacity-0 
                  group-hover:max-h-40 group-hover:opacity-100 
                  transition-all duration-500">
            Maksimal 3–7 hari kerja tergantung kelengkapan data.
        </p>

    </div>

</div>

</section>

<!-- ================= HERO BANNER ================= -->
<section class="pt-28 px-6 mb-10">

    <div class="max-w-7xl mx-auto">

        <div class="relative overflow-hidden rounded-[40px] bg-gradient-to-r from-indigo-800 to-indigo-600 px-10 py-20 text-center text-white">

            <!-- BACKGROUND DOT PATTERN -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>

            <!-- CONTENT -->
            <div class="relative z-10">

                <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-8">
                    Berani Jujur Adalah Langkah <br>
                    Emas Bagi Bangsa
                </h1>

                <!-- BUTTON + LABEL -->
                <div class="flex justify-center items-center gap-6 flex-wrap">

                    <a href="{{ route('laporan.create') }}"
                       class="bg-white text-indigo-700 px-8 py-4 rounded-full font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-300 flex items-center gap-2">

                        Mulai Laporan Anonim

                        <!-- ICON LOCK -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 11c1.104 0 2 .896 2 2v2a2 2 0 01-4 0v-2c0-1.104.896-2 2-2zm6 2v2a6 6 0 11-12 0v-2a6 6 0 1112 0z"/>
                        </svg>

                    </a>

                    <div class="flex items-center gap-2 text-sm text-white/90">
                        <!-- ICON SHIELD -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 3l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V7l8-4z"/>
                        </svg>

                        Lindungi Masa Depan Anda
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= SCRIPT ================= -->

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({
    duration: 1000,
    once: true
});
</script>

<script>
// FAQ INTERACTION
document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('click', () => {

        const content = item.querySelector('.faq-content');
        const icon = item.querySelector('.faq-icon');

        content.classList.toggle('hidden');

        icon.innerText = content.classList.contains('hidden') ? '+' : '-';
    });
});
</script>

</body>
</html>