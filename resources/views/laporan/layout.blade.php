<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laporan')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">
<div class="flex min-h-screen">
    <div id="dosenSidebarOverlay" onclick="closeDosenSidebar()" class="fixed inset-0 z-40 hidden bg-black/40 md:hidden"></div>

    <aside id="dosenSidebar" class="fixed inset-y-0 left-0 z-50 flex h-screen w-[260px] -translate-x-full flex-col justify-between border-r border-gray-100 bg-white shadow-xl transition-transform duration-300 ease-in-out md:sticky md:top-0 md:z-30 md:translate-x-0 md:shadow-none">
        <div class="min-w-0">
            <div class="relative flex justify-center px-4 py-5 md:px-6 md:py-6">
                <img
                    src="/images/logo1.png"
                    alt="Logo"
                    class="h-14 md:h-16 w-auto max-w-[132px] object-contain"
                />

                <button type="button" onclick="closeDosenSidebar()" class="absolute right-4 top-5 flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-500 transition hover:bg-slate-200 md:hidden" aria-label="Tutup sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="mt-5 space-y-3 px-4">
                <a href="{{ route('laporan.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 transition {{ request()->routeIs('laporan.index') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-gray-100 font-medium' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>

                    Dashboard
                </a>

                <a href="{{ route('laporan.history') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 transition {{ request()->routeIs('laporan.history') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-gray-100 font-medium' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                    </svg>

                    Riwayat Laporan
                </a>
            </div>
        </div>

        <div class="p-4 md:p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="flex items-center gap-2 md:gap-3 text-red-500 font-semibold hover:opacity-80 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V4"/>
                    </svg>

                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="min-w-0 flex-1 p-4 sm:p-6 lg:p-10">
        <div class="mb-4 flex items-center justify-between rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-sm md:hidden">
            <img src="/images/logo1.png" alt="Logo" class="h-10 w-auto object-contain">

            <button type="button" onclick="openDosenSidebar()" class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition hover:bg-blue-100" aria-label="Buka sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        @yield('content')
    </main>
</div>

<script>
    const dosenSidebar = document.getElementById('dosenSidebar');
    const dosenSidebarOverlay = document.getElementById('dosenSidebarOverlay');

    function openDosenSidebar() {
        dosenSidebar.classList.remove('-translate-x-full');
        dosenSidebarOverlay.classList.remove('hidden');
    }

    function closeDosenSidebar() {
        dosenSidebar.classList.add('-translate-x-full');
        dosenSidebarOverlay.classList.add('hidden');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDosenSidebar();
        }
    });
</script>

@if(session('success'))
<div id="successPopup"
     class="fixed top-6 right-6 z-[9999] translate-x-[120%] opacity-0 transition-all duration-500">
    <div class="flex min-w-[320px] items-start gap-4 rounded-2xl border border-white/30 bg-white/90 px-5 py-4 shadow-2xl backdrop-blur-xl">
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <div class="flex-1">
            <h3 class="text-sm font-semibold text-gray-800">Berhasil</h3>
            <p class="mt-1 text-sm text-gray-500">{{ session('success') }}</p>
        </div>

        <button type="button" onclick="closeSuccessPopup()" class="text-gray-400 transition hover:text-gray-600">
            x
        </button>
    </div>
</div>

<script>
    const successPopup = document.getElementById('successPopup');

    setTimeout(() => {
        successPopup.classList.remove('translate-x-[120%]', 'opacity-0');
    }, 100);

    setTimeout(() => {
        closeSuccessPopup();
    }, 3500);

    function closeSuccessPopup() {
        successPopup.classList.add('translate-x-[120%]', 'opacity-0');
    }
</script>
@endif

@yield('scripts')
</body>
</html>
