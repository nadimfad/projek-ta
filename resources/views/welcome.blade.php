<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sigap - Sistem Pelaporan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800">

<!-- ================= NAVBAR ================= -->
<header class="bg-white/80 backdrop-blur-md fixed w-full z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-2 flex justify-between items-center gap-4">

        <!-- LOGO -->
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo1.png') }}" class="h-12 sm:h-16">
            <span class="text-xl font-bold"></span>
        </div>

        <!-- MENU -->
        <div class="flex items-center justify-end gap-2 sm:gap-6 text-xs sm:text-sm font-medium">
            <a href="#cara-lapor" class="hidden sm:inline hover:text-indigo-600 transition">Cara Lapor</a>
            <a href="#fitur" class="hidden sm:inline hover:text-indigo-600 transition">Fitur</a>
            <a href="#faq" class="hidden sm:inline hover:text-indigo-600 transition">FAQ</a>

            @auth

    @if(auth()->user()->role == 'admin')

        <a href="{{ route('dashboard') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition">
            Laporkan sekarang
        </a>

    @else

        <a href="{{ route('laporan.index') }}"
           class="bg-indigo-600 text-white px-3 sm:px-5 py-2 rounded-full hover:bg-indigo-700 transition whitespace-nowrap">
            Laporkan Sekarang
        </a>

    @endif

@else

    <a href="{{ route('login') }}"
       class="bg-indigo-600 text-white px-3 sm:px-5 py-2 rounded-full hover:bg-indigo-700 transition whitespace-nowrap">
        Laporkan Sekarang
    </a>

@endauth
        </div>

    </div>
</header>

<!-- ================= HERO ================= -->
<section class="pt-28 sm:pt-32 pb-14 sm:pb-20 text-center px-4 sm:px-6 mb-8">
    <div class="max-w-4xl mx-auto">

        {{-- <div data-aos="zoom-in"
             class="inline-block px-4 py-2 text-sm font-bold bg-indigo-100 text-indigo-600 rounded-full mb-6">
            KEAMANAN DATA TERJAMIN 100%
        </div> --}}

        <h1 data-aos="fade-up"
            class="text-3xl sm:text-4xl md:text-6xl font-extrabold leading-tight mb-6">
            Wujudkan Integritas <br>
            <span class="text-indigo-600">Tanpa Kompromi</span>
        </h1>

        <p data-aos="fade-up" data-aos-delay="100"
           class="text-gray-500 text-base sm:text-lg mb-10">
            Platform digital resmi untuk pelaporan gratifikasi.
            Cepat, aman, dan tanpa biaya.
        </p>

        <div data-aos="fade-up" data-aos-delay="200"
             class="flex justify-center gap-4 flex-wrap">

            @auth

    @if(auth()->user()->role == 'admin')

        <a href="{{ route('dashboard') }}"
           class="bg-indigo-600 text-white px-6 py-3 rounded-full shadow hover:scale-105 hover:bg-indigo-700 transition">
            Mulai Melapor →
        </a>

    @else

        <a href="{{ route('laporan.index') }}"
           class="bg-indigo-600 text-white px-6 py-3 rounded-full shadow hover:scale-105 hover:bg-indigo-700 transition">
            Mulai Melapor →
        </a>

    @endif

@else

    <a href="{{ route('login') }}"
       class="bg-indigo-600 text-white px-6 py-3 rounded-full shadow hover:scale-105 hover:bg-indigo-700 transition">
        Mulai Melapor →
    </a>

@endauth

        </div>

    </div>
</section>

<!-- ================= CARA MELAPOR ================= -->
<section id="cara-lapor" class="bg-white py-14 sm:py-20 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-10 lg:gap-12 items-center" data-aos="fade-up">

        <!-- LEFT CONTENT -->
        <div>

            <p class="text-indigo-600 font-bold mb-3 tracking-wide">
                CARA MELAPOR
            </p>

            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-10">
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

<!-- ================= FITUR UTAMA ================= -->
<section id="fitur" class="bg-gray-50 py-14 sm:py-20 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">

        <div class="max-w-4xl mx-auto text-center mb-12" data-aos="fade-up">
            <p class="text-indigo-600 font-bold mb-3 tracking-wide">
                FITUR SIGAP
            </p>

            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4">
                Informasi Laporan Lebih Rapi
            </h2>

            <p class="text-gray-500">
                SIGAP membantu proses pelaporan gratifikasi menjadi lebih terstruktur, mudah ditinjau, dan terdokumentasi.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white rounded-xl shadow p-6 transition hover:shadow-lg" data-aos="fade-up">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Laporan Terbaru</h3>
                <p class="text-gray-500 text-sm leading-6">
                    Dashboard menampilkan laporan terbaru agar aktivitas terakhir mudah dipantau.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 transition hover:shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Riwayat Lengkap</h3>
                <p class="text-gray-500 text-sm leading-6">
                    Laporan lama tetap tersimpan dan bisa dicari kembali melalui halaman riwayat.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 transition hover:shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h3l2-3h8l2 3h3v13H3V7zm9 10a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Bukti Foto</h3>
                <p class="text-gray-500 text-sm leading-6">
                    Bukti pendukung dapat diunggah dan direview langsung tanpa berpindah halaman.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 transition hover:shadow-lg" data-aos="fade-up" data-aos-delay="300">
                <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3h2v18h-2V3zM4 13h2v8H4v-8zm14-6h2v14h-2V7z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Statistik Admin</h3>
                <p class="text-gray-500 text-sm leading-6">
                    Admin dapat melihat ringkasan data untuk membantu pemantauan laporan.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- ================= INFORMASI LAPORAN ================= -->
<section class="bg-white py-14 sm:py-20 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-10 lg:gap-12 items-center">

        <div data-aos="fade-up">
            <p class="text-indigo-600 font-bold mb-3 tracking-wide">
                DATA YANG DICATAT
            </p>

            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6">
                Setiap Laporan Memuat Informasi Penting
            </h2>

            <p class="text-gray-500 leading-7 mb-8">
                Form laporan dirancang ringkas, namun tetap memuat data utama yang dibutuhkan untuk proses peninjauan.
            </p>

            <div class="grid gap-3 sm:grid-cols-2">
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-semibold text-gray-800">Data Mahasiswa</h3>
                    <p class="text-sm text-gray-500 mt-1">Nama dan NIM mahasiswa terkait.</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-semibold text-gray-800">Jenis Kegiatan</h3>
                    <p class="text-sm text-gray-500 mt-1">Kategori seminar atau kegiatan akademik.</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-semibold text-gray-800">Bentuk Gratifikasi</h3>
                    <p class="text-sm text-gray-500 mt-1">Jenis atau bentuk pemberian yang dilaporkan.</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-semibold text-gray-800">Keterangan & Bukti</h3>
                    <p class="text-sm text-gray-500 mt-1">Catatan tambahan dan foto pendukung.</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-3xl p-6" data-aos="fade-up" data-aos-delay="100">
            <div class="grid gap-4">
                <div class="flex items-center justify-between bg-white rounded-xl shadow-sm p-4">
                    <span class="font-semibold text-gray-700">Seminar Kerja Praktek</span>
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">Biru</span>
                </div>

                <div class="flex items-center justify-between bg-white rounded-xl shadow-sm p-4">
                    <span class="font-semibold text-gray-700">Seminar Proposal</span>
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold">Hijau</span>
                </div>

                <div class="flex items-center justify-between bg-white rounded-xl shadow-sm p-4">
                    <span class="font-semibold text-gray-700">Seminar Hasil</span>
                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">Kuning</span>
                </div>

                <div class="flex items-center justify-between bg-white rounded-xl shadow-sm p-4">
                    <span class="font-semibold text-gray-700">Seminar Akhir</span>
                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold">Merah</span>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ================= FAQ ================= -->
<section id="faq" class="bg-gray-50 py-14 sm:py-20 px-4 sm:px-6 mb-4">

    <div class="max-w-4xl mx-auto text-center mb-12" data-aos="fade-up">
        <h2 class="text-2xl sm:text-3xl font-bold mb-4">FAQ</h2>
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
<section class="pt-16 sm:pt-28 px-4 sm:px-6 mb-10">

    <div class="max-w-7xl mx-auto">

        <div class="relative overflow-hidden rounded-3xl sm:rounded-[40px] bg-gradient-to-r from-indigo-800 to-indigo-600 px-5 sm:px-10 py-14 sm:py-20 text-center text-white">

            <!-- BACKGROUND DOT PATTERN -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>

            <!-- CONTENT -->
            <div class="relative z-10">

                <h1 class="text-2xl sm:text-3xl md:text-5xl font-extrabold leading-tight mb-8">
                    Berani Jujur Adalah Langkah <br>
                    Emas Bagi Bangsa
                </h1>

                <!-- BUTTON + LABEL -->
                <div class="flex justify-center items-center gap-6 flex-wrap">

                    <a href="{{ route('login') }}"
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
