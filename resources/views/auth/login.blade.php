<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sikawan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-indigo-50 via-white to-indigo-100 min-h-screen flex items-center justify-center">

<!-- CONTAINER -->
<div class="w-full max-w-md px-6">

    <!-- BACK BUTTON -->
    <a href="{{ url('/') }}" class="flex items-center gap-2 text-gray-500 mb-6 hover:text-indigo-600 transition">
        ← Kembali ke Beranda
    </a>

    <!-- CARD -->
    <div class="bg-white rounded-3xl shadow-xl p-8 relative overflow-hidden">

        <!-- ICON -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-indigo-600 text-white flex items-center justify-center rounded-2xl shadow-lg">
                🔒
            </div>
        </div>

        <!-- TITLE -->
        <h2 class="text-2xl font-bold text-center mb-2">
            Selamat Datang
        </h2>

        <p class="text-gray-500 text-center mb-6">
            Masuk ke portal Sikawan untuk mengelola laporan Anda.
        </p>

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- EMAIL -->
            <div>
                <label class="text-sm text-gray-500">Email</label>

                <div class="group mt-1 flex items-center border rounded-xl px-3 py-2 focus-within:ring-2 focus-within:ring-indigo-500">
                    <span class="text-gray-400 mr-2 group-focus-within:text-indigo-600 transition">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
        viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="lucide lucide-mail">
        <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
        <rect x="2" y="4" width="20" height="16" rx="2"></rect>
    </svg>
</span>
                    <input type="email" name="email" required
                        class="w-full outline-none bg-transparent border-none focus:ring-0"
                        placeholder="nama@instansi.go.id">
                </div>
            </div>

            <!-- PASSWORD -->
            <div>
                {{-- <div class="flex justify-between text-sm">
                    <label class="text-gray-500">Password</label>
                    <a href="#" class="text-indigo-600 hover:underline">
                        Lupa Password?
                    </a>
                </div> --}}

                <div class="group mt-1 flex items-center border rounded-xl px-3 py-2 focus-within:ring-2 focus-within:ring-indigo-500">
                    <span class="text-gray-400 mr-2 group-focus-within:text-indigo-600 transition">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
        viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="lucide lucide-eye">
        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
        <circle cx="12" cy="12" r="3"></circle>
    </svg>
</span>
                    <input type="password" name="password" required
                        class="w-full outline-none bg-transparent border-none focus:ring-0"
                        placeholder="********">
                </div>
            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold 
                       hover:bg-indigo-700 transition transform hover:scale-[1.02] shadow-lg">
                Masuk ke Portal
            </button>

        </form>

        <!-- FOOTER -->
        <p class="text-center text-sm text-gray-400 mt-6">
            © {{ date('Y') }} Sikawan System
        </p>

    </div>

</div>

</body>
</html>