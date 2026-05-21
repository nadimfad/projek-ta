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
    <aside class="w-[260px] bg-white border-r border-gray-100 flex flex-col justify-between h-screen sticky top-0">
        <div>
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

            <div class="px-4 mt-5 space-y-3">
                <a href="{{ route('laporan.index') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-2xl transition {{ request()->routeIs('laporan.index') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-gray-100 font-medium' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>

                    Dashboard
                </a>

                <a href="{{ route('laporan.history') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-2xl transition {{ request()->routeIs('laporan.history') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-gray-100 font-medium' }}">
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
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V4"/>
                    </svg>

                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-10">
        @yield('content')
    </main>
</div>

@yield('scripts')
</body>
</html>
