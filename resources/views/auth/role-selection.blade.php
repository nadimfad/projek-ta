<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Peran - SIGAP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800">
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50"></div>

    <main class="fixed inset-0 flex items-center justify-center bg-slate-900/40 px-5 py-8 backdrop-blur-sm">
        <section role="dialog" aria-modal="true" aria-labelledby="role-selection-title" class="w-full max-w-md rounded-3xl border border-white/70 bg-white p-6 shadow-2xl sm:p-8">
            <div class="flex justify-center">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo SIGAP" class="h-16 w-auto object-contain">
            </div>

            <div class="mt-5 text-center">
                <h1 id="role-selection-title" class="text-2xl font-bold text-slate-800">Pilih Cara Masuk</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">Akun Anda memiliki akses sebagai dosen dan kajur. Pilih peran untuk sesi ini.</p>
            </div>

            <form method="POST" action="{{ route('login.role-selection.store') }}" class="mt-7 grid gap-3">
                @csrf

                <button type="submit" name="login_as" value="dosen" class="group flex w-full items-center gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-left transition hover:border-blue-300 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A3 3 0 017 12h10a3 3 0 011.879 5.804M15 3v12m0 0l-3-3m3 3l3-3M4 21h16" />
                        </svg>
                    </span>
                    <span>
                        <span class="block font-bold text-slate-800">Masuk sebagai Dosen</span>
                        <span class="mt-1 block text-sm text-slate-500">Buat laporan dan lihat riwayat pelaporan.</span>
                    </span>
                </button>

                <button type="submit" name="login_as" value="kajur" class="group flex w-full items-center gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-left transition hover:border-indigo-300 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2zm3 8h6m-6 4h4" />
                        </svg>
                    </span>
                    <span>
                        <span class="block font-bold text-slate-800">Masuk sebagai Kajur</span>
                        <span class="mt-1 block text-sm text-slate-500">Pantau dashboard, laporan, dan statistik.</span>
                    </span>
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-6 text-center">
                @csrf
                <button type="submit" class="text-sm font-semibold text-slate-500 transition hover:text-red-600">Keluar dari akun</button>
            </form>
        </section>
    </main>
</body>
</html>
