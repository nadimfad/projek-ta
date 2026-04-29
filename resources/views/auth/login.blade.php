<x-guest-layout>
    <div class="h-[100vh] w-full flex items-center justify-center bg-gray-50 dark:bg-gray-900 overflow-hidden">

        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">

            <!-- Header -->
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                    Masuk ke Sistem
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Silakan login untuk melanjutkan
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">
                        Email
                    </label>
                    <input 
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required autofocus
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-gray-800 dark:focus:ring-white focus:outline-none transition"
                        placeholder="nama@email.com"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">
                        Password
                    </label>
                    <input 
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-gray-800 dark:focus:ring-white focus:outline-none transition"
                        placeholder="Masukkan password"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between text-sm mb-6">
                    <label class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                        <input type="checkbox" name="remember" class="rounded border-gray-300">
                        Ingat saya
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-gray-700 dark:text-gray-300 hover:underline">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full py-2.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition font-medium">
                    Masuk
                </button>

                <!-- Register -->
                <p class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-gray-900 dark:text-white font-medium hover:underline">
                        Daftar
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>