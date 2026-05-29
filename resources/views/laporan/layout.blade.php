<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laporan')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">
<div class="flex min-h-screen flex-col md:flex-row">
    <aside class="w-full md:w-[260px] bg-white border-b md:border-b-0 md:border-r border-gray-100 flex md:flex-col justify-between md:h-screen md:sticky top-0 z-30">
        <div class="min-w-0">
            <div class="flex justify-center px-4 sm:px-6 py-4 md:py-6">
                <img
                    src="/images/logo1.png"
                    alt="Logo"
                    class="h-14 md:h-16 w-auto max-w-[132px] object-contain"
                />
                {{-- <div class="w-11 h-11 md:w-14 md:h-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 md:w-7 md:h-7 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 3l7 4v5c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V7l7-4z"/>
                    </svg>
                </div> --}}
{{-- 
                <h1 class="text-lg md:text-xl font-bold text-slate-800 tracking-tight">
                    SIGAP
                </h1> --}}
            </div>

            <div class="px-4 pb-4 md:pb-0 md:mt-5 flex md:block gap-2 md:space-y-3 overflow-x-auto">
                <a href="{{ route('laporan.index') }}"
                   class="flex shrink-0 items-center gap-3 md:gap-4 px-4 md:px-5 py-3 md:py-4 rounded-2xl transition {{ request()->routeIs('laporan.index') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-gray-100 font-medium' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>

                    Dashboard
                </a>

                <a href="{{ route('laporan.history') }}"
                   class="flex shrink-0 items-center gap-3 md:gap-4 px-4 md:px-5 py-3 md:py-4 rounded-2xl transition {{ request()->routeIs('laporan.history') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-gray-100 font-medium' }}">
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

                    <span class="hidden sm:inline">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-4 sm:p-6 lg:p-10 min-w-0">
        @yield('content')
    </main>
</div>

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
