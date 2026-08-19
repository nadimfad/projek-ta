<!DOCTYPE html>
<html lang="id">
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
  <aside id="adminSidebar" class="w-64 bg-white h-screen flex flex-col border-r border-gray-100 shadow-sm transition-all duration-300 ease-in-out overflow-hidden">

    <div class="px-6 py-6 flex justify-center">
        {{-- <div class="bg-blue-600 p-2 rounded-lg shadow-md shadow-blue-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div> --}}
        <img
            src="/images/logo1.png"
            alt="Logo"
            class="h-16 w-auto max-w-[140px] object-contain"
        />
    </div>

    <nav class="flex-1 px-4 space-y-1">
        
        @if(in_array(session('active_role', auth()->user()->role), ['admin', 'kajur'], true))
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-4 px-4 py-3 rounded-xl transition font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Dashboard
        </a>
        @endif

        <a href="{{ in_array(session('active_role', auth()->user()->role), ['admin', 'kajur'], true) ? route('admin.laporan.index') : route('laporan.index') }}"
           class="flex items-center gap-4 px-4 py-3 rounded-xl transition font-medium {{ request()->routeIs('laporan.*') || request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Laporan
        </a>

        @if(session('active_role', auth()->user()->role) == 'dosen')
        <a href="{{ route('laporan.history') }}"
           class="flex items-center gap-4 px-4 py-3 rounded-xl transition font-medium {{ request()->routeIs('laporan.history') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
            </svg>
            Riwayat
        </a>
        @endif

        @if(auth()->user()->role == 'admin')
        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-4 px-4 py-3 rounded-xl transition font-medium {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Manajemen User
        </a>
        @endif

        @if(in_array(session('active_role', auth()->user()->role), ['admin', 'kajur'], true))
        <a href="{{ route('admin.statistik') }}"
           class="flex items-center gap-4 px-4 py-3 rounded-xl transition font-medium {{ request()->routeIs('admin.statistik') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
            </svg>
            Statistik
        </a>
        @endif

    </nav>

    <div class="p-6 border-t border-gray-50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex items-center gap-4 w-full px-4 py-2 text-red-500 font-semibold hover:bg-red-50 rounded-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>

</aside>

    <!-- 🔥 CONTENT AREA -->
   <main class="flex-1 bg-gray-50 overflow-y-auto h-screen">

    <header class="bg-white px-8 py-6 flex justify-between items-center border-b border-gray-100">

        <div class="flex items-center gap-4">
            <button type="button"
        id="adminSidebarToggle"
        onclick="toggleAdminSidebar()"
        class="group inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gray-50 text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300"
        title="Toggle sidebar"
        aria-label="Toggle sidebar"
        aria-expanded="true">
        
    <svg xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 16 16" 
         width="20" 
         height="20" 
         fill="currentColor"
         aria-hidden="true" 
         data-rtl-flip 
         id="adminSidebarToggleIcon"
         class="icon max-md:hidden transition-transform duration-300 ease-out"
         style="vertical-align: text-bottom;">
        <path d="M6.823 7.823a.25.25 0 0 1 0 .354l-2.396 2.396A.25.25 0 0 1 4 10.396V5.604a.25.25 0 0 1 .427-.177Z"></path>
        <path d="M1.75 0h12.5C15.216 0 16 .784 16 1.75v12.5A1.75 1.75 0 0 1 14.25 16H1.75A1.75 1.75 0 0 1 0 14.25V1.75C0 .784.784 0 1.75 0ZM1.5 1.75v12.5c0 .138.112.25.25.25H9.5v-13H1.75a.25.25 0 0 0-.25.25ZM11 14.5h3.25a.25.25 0 0 0 .25-.25V1.75a.25.25 0 0 0-.25-.25H11Z"></path>
    </svg>

    <svg xmlns="http://www.w3.org/2000/svg"
         width="20"
         height="20"
         aria-hidden="true"
         data-rtl-flip
         id="adminSidebarToggleIconMobile"
         class="icon md:hidden transition-transform duration-300 ease-out"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5h16M4 12h16M4 19h16" />
    </svg>
</button>

            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">
                    @yield('title', 'Pusat Kendali Laporan')
                </h1>
                <p class="text-sm text-gray-400 mt-1">
                    {{ session('active_role', auth()->user()->role) == 'admin' ? 'Selamat bertugas, Administrator.' : (session('active_role', auth()->user()->role) == 'kajur' ? 'Pantau laporan dan statistik jurusan.' : 'Pantau dan kelola laporan Anda.') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 text-sm font-medium text-gray-500 bg-gray-50 px-4 py-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ now()->format('d M Y') }}
        </div>

    </header>

    <div class="p-8 pb-20">
        @yield('content')
    </div>

</main>
</div>

<script>
    feather.replace()

    const adminSidebar = document.getElementById('adminSidebar');
    const adminSidebarToggle = document.getElementById('adminSidebarToggle');
    const adminSidebarToggleIcon = document.getElementById('adminSidebarToggleIcon');
    const adminSidebarToggleIconMobile = document.getElementById('adminSidebarToggleIconMobile');

    function setToggleIcon(isHidden) {
        adminSidebarToggle.setAttribute('aria-expanded', String(!isHidden));
        adminSidebarToggle.classList.toggle('text-blue-600', !isHidden);
        adminSidebarToggle.classList.toggle('bg-blue-50', !isHidden);
        adminSidebarToggle.classList.toggle('text-gray-500', isHidden);
        adminSidebarToggle.classList.toggle('bg-gray-50', isHidden);
        adminSidebarToggle.classList.toggle('scale-95', isHidden);
        adminSidebarToggle.setAttribute('title', isHidden ? 'Buka sidebar' : 'Tutup sidebar');

        adminSidebarToggleIcon.classList.toggle('rotate-180', isHidden);
        adminSidebarToggleIcon.classList.toggle('scale-90', isHidden);
        adminSidebarToggleIcon.classList.toggle('opacity-80', isHidden);

        adminSidebarToggleIconMobile.classList.toggle('rotate-180', isHidden);
        adminSidebarToggleIconMobile.classList.toggle('scale-90', isHidden);
        adminSidebarToggleIconMobile.classList.toggle('opacity-80', isHidden);
    }

    if (localStorage.getItem('adminSidebarHidden') === '1') {
        adminSidebar.classList.add('w-0', 'border-r-0');
        adminSidebar.classList.remove('w-64');
        setToggleIcon(true);
    } else {
        setToggleIcon(false);
    }

    function toggleAdminSidebar() {
        const isHidden = adminSidebar.classList.contains('w-0');

        adminSidebar.classList.toggle('w-0', !isHidden);
        adminSidebar.classList.toggle('border-r-0', !isHidden);
        adminSidebar.classList.toggle('w-64', isHidden);
        setToggleIcon(!isHidden);

        localStorage.setItem('adminSidebarHidden', isHidden ? '0' : '1');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ===============================
🔥 MODERN SUCCESS POPUP
=============================== --}}
@if(session('success'))

<div id="successPopup"
     class="fixed top-6 right-6 z-[9999] translate-x-[120%] opacity-0 transition-all duration-500">

    <div class="backdrop-blur-xl bg-white/80 border border-white/30 shadow-2xl rounded-2xl px-5 py-4 flex items-start gap-4 min-w-[320px]">

        <!-- ICON -->
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center shadow-inner">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-7 h-7 text-green-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7" />

            </svg>

        </div>

        <!-- TEXT -->
        <div class="flex-1">

            <h3 class="font-semibold text-gray-800 text-sm">
                Berhasil
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                {{ session('success') }}
            </p>

        </div>

        <!-- CLOSE -->
        <button onclick="closePopup()"
                class="text-gray-400 hover:text-gray-600 transition">

            ✕

        </button>

    </div>

</div>

<script>

    const popup = document.getElementById('successPopup');

    // muncul smooth
    setTimeout(() => {

        popup.classList.remove('translate-x-[120%]', 'opacity-0');

    }, 100);

    // auto close
    setTimeout(() => {

        closePopup();

    }, 3500);

    function closePopup() {

        popup.classList.add('translate-x-[120%]', 'opacity-0');

    }

</script>

@endif
</body>
</html>
