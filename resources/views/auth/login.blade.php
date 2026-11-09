<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Sigap</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-indigo-50 via-white to-indigo-100 min-h-screen flex items-center justify-center overflow-hidden">

<!-- BACKGROUND BLUR -->
<div class="absolute top-0 left-0 w-72 h-72 bg-indigo-300 rounded-full blur-3xl opacity-20"></div>
<div class="absolute bottom-0 right-0 w-72 h-72 bg-blue-300 rounded-full blur-3xl opacity-20"></div>

<!-- CONTAINER -->
<div class="relative z-10 w-full max-w-md px-6">

    <!-- BACK BUTTON -->
    <a href="{{ url('/') }}"
       class="flex items-center gap-2 text-gray-500 mb-6 hover:text-indigo-600 transition font-medium">
        ← Kembali ke Beranda
    </a>

    <!-- CARD -->
    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-7 relative overflow-hidden">

        <!-- ICON -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo1.png') }}"
                 class="h-16 w-auto object-contain">
        </div>

        <!-- TITLE -->
        <h2 class="text-3xl font-bold text-center text-slate-800 mb-2">
            Selamat Datang
        </h2>

        <p class="text-gray-500 text-center mb-8 text-sm">
            Masuk ke portal Sigap untuk mengelola laporan Anda.
        </p>

        <!-- FORM -->
        <form method="POST"
              action="{{ route('login') }}"
              class="space-y-5">

            @csrf

            <!-- USERNAME -->
            <div>

                <label class="text-sm font-medium text-gray-500">
                    NIP / Email
                </label>

                <div class="group mt-2 flex items-center bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 transition focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">

                    <!-- ICON -->
                    <span class="text-gray-400 mr-3 group-focus-within:text-indigo-600 transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="18"
                             height="18"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round">

                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>

                        </svg>

                    </span>

                    <input type="text"
                           name="username"
                           required
                           value="{{ old('username') }}"
                           placeholder="Masukkan NIP, atau email"
                           class="w-full bg-transparent border-none outline-none focus:ring-0 text-sm">

                </div>

            </div>

            <!-- PASSWORD -->
            <div>

                <label class="text-sm font-medium text-gray-500">
                    Password
                </label>

                <div class="group mt-2 flex items-center bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 transition focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">

                    <!-- ICON -->
                    <span class="text-gray-400 mr-3 group-focus-within:text-indigo-600 transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="18"
                             height="18"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round">

                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                            <circle cx="12" cy="12" r="3"></circle>

                        </svg>

                    </span>

                    <input type="password"
                           name="password"
                           required
                           placeholder="********"
                           class="w-full bg-transparent border-none outline-none focus:ring-0 text-sm">

                </div>

            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-3 rounded-2xl font-semibold shadow-lg hover:shadow-indigo-300/50 hover:scale-[1.02] transition duration-300">

                Masuk ke Portal

            </button>

        </form>

        <!-- FOOTER -->
        <p class="text-center text-sm text-gray-400 mt-8">
            © {{ date('Y') }} Sigap System
        </p>

    </div>

</div>

<!-- ================= POPUP LOGIN ERROR ================= -->
@if ($errors->any())

<div id="errorPopup"
     class="fixed top-6 right-6 z-50">

    <div class="bg-white border border-red-100 shadow-2xl rounded-2xl px-5 py-4 min-w-[340px] animate-slideIn">

        <div class="flex items-start gap-4">

            <!-- ICON -->
            <div class="w-11 h-11 rounded-2xl bg-red-100 flex items-center justify-center shrink-0">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-red-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67
                          1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34
                          16c-.77 1.33.19 3 1.73 3z"/>

                </svg>

            </div>

            <!-- TEXT -->
            <div class="flex-1">

                <h3 class="font-bold text-slate-800 text-sm">
                    Login Gagal
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Username atau password yang Anda masukkan salah.
                </p>

            </div>

            <!-- CLOSE -->
            <button onclick="closeErrorPopup()"
                    class="text-gray-400 hover:text-red-500 transition text-xl leading-none">

                ×

            </button>

        </div>

        <!-- PROGRESS -->
        <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden mt-4">

            <div class="h-full bg-red-500 animate-progress"></div>

        </div>

    </div>

</div>

@endif

<!-- STYLE -->
<style>

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes progress {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}

.animate-slideIn {
    animation: slideIn .4s ease;
}

.animate-progress {
    animation: progress 5s linear forwards;
}

</style>

<!-- SCRIPT -->
<script>

    function closeErrorPopup() {

        const popup = document.getElementById('errorPopup');

        if (popup) {
            popup.style.display = 'none';
        }
    }

    // auto close 5 detik
    setTimeout(() => {

        closeErrorPopup();

    }, 5000);

</script>

</body>
</html>
