<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ICON (Heroicons via CDN) -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- 🔥 SIDEBAR MODERN -->
   <aside class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-800 text-white flex flex-col shadow-xl">

    <div class="p-6 text-xl font-bold tracking-wide">
        🚀 SIGAP
    </div>

    <nav class="flex-1 px-3 space-y-2">

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-xl transition hover:bg-indigo-700 {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : '' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('laporan.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-xl transition hover:bg-indigo-700 {{ request()->routeIs('laporan.*') ? 'bg-indigo-700' : '' }}">
            📄 Laporan
        </a>

    </nav>

    <div class="p-4 border-t border-indigo-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full bg-red-500 py-2 rounded-xl hover:bg-red-600 transition">
                Logout
            </button>
        </form>
    </div>

</aside>

    <!-- 🔥 CONTENT AREA -->
    <main class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">

            <h1 class="text-lg font-semibold text-gray-700">
                @yield('title', 'Dashboard')
            </h1>

            <div class="text-sm text-gray-500">
                {{ now()->format('d M Y') }}
            </div>

        </header>

        <!-- PAGE CONTENT -->
        <div class="p-6 overflow-y-auto flex-1">
            @yield('content')
        </div>

    </main>

</div>

<script>
    feather.replace()
</script>

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