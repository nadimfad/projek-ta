<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<!-- NAVBAR SIMPLE -->
<header class="bg-white shadow px-6 py-4 flex justify-between">

    <h1 class="font-semibold">User Panel</h1>

    <div class="flex gap-4 items-center">
        <a href="{{ route('laporan.index') }}" class="text-indigo-600">
            Laporan Saya
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-500">Logout</button>
        </form>
    </div>

</header>

<!-- CONTENT -->
 <main class="flex-1 p-6 overflow-y-auto">
        @yield('content')
    </main>

</body>
</html>