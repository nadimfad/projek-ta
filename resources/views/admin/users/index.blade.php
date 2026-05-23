@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')

<div class="grid grid-cols-1 xl:grid-cols-[420px_1fr] gap-6">

    <!-- FORM TAMBAH DOSEN -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <h2 class="text-lg font-bold text-gray-800">
            Buat Akun Dosen
        </h2>

        <p class="text-sm text-gray-400 mt-1">
            Akun baru otomatis mendapat role dosen.
        </p>

        <form method="POST"
              action="{{ route('admin.users.store') }}"
              class="mt-6 space-y-5">

            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Nama
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                       required>

                @error('name')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Email
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                       required>

                @error('email')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                       required>

                @error('password')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Konfirmasi Password
                </label>

                <input type="password"
                       name="password_confirmation"
                       class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <button
                class="w-full bg-blue-600 text-white rounded-xl px-4 py-3 font-semibold hover:bg-blue-700 transition">
                Simpan Akun
            </button>

        </form>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">
                Daftar Dosen
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-400 uppercase text-[11px] tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold">Email</th>
                        <th class="px-6 py-4 text-center font-semibold">Dibuat</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">

                    @forelse ($users as $user)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-5 font-semibold text-gray-700">
                            {{ $user->name }}
                        </td>

                        <td class="px-6 py-5 text-gray-500">
                            {{ $user->email }}
                        </td>

                        <td class="px-6 py-5 text-center text-gray-400">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        <td class="px-6 py-5">

                            <div class="flex items-center justify-center gap-2">

                                <!-- DETAIL BUTTON -->
                                <button
                                    onclick="openDetailModal(
                                        '{{ $user->name }}',
                                        '{{ $user->email }}',
                                        '{{ $user->created_at->format('d M Y') }}'
                                    )"
                                    class="px-3 py-2 rounded-lg bg-sky-100 text-sky-700 hover:bg-sky-200 transition text-xs font-semibold">
                                    Detail
                                </button>

                                <!-- EDIT BUTTON -->
                                <button
                                    onclick="openEditModal(
                                        '{{ $user->id }}',
                                        '{{ $user->name }}',
                                        '{{ $user->email }}'
                                    )"
                                    class="px-3 py-2 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 transition text-xs font-semibold">
                                    Edit
                                </button>

                                <!-- DELETE -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus akun dosen ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="px-3 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition text-xs font-semibold">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="text-center py-12 text-gray-400">
                            Belum ada akun dosen.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- DETAIL MODAL -->
<div id="detailModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-xl">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">
                Detail Dosen
            </h2>

            <button onclick="closeDetailModal()"
                class="text-gray-400 hover:text-red-500 text-xl">
                ✕
            </button>
        </div>

        <div class="space-y-4">

            <div>
                <p class="text-sm text-gray-400">Nama</p>
                <p id="detailName" class="font-semibold text-gray-700"></p>
            </div>

            <div>
                <p class="text-sm text-gray-400">Email</p>
                <p id="detailEmail" class="font-semibold text-gray-700"></p>
            </div>

            <div>
                <p class="text-sm text-gray-400">Tanggal Dibuat</p>
                <p id="detailCreated" class="font-semibold text-gray-700"></p>
            </div>

        </div>

    </div>

</div>

<!-- EDIT MODAL -->
<div id="editModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-xl">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">
                Edit Dosen
            </h2>

            <button onclick="closeEditModal()"
                class="text-gray-400 hover:text-red-500 text-xl">
                ✕
            </button>
        </div>

        <form id="editForm" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Nama
                    </label>

                    <input type="text"
                           name="name"
                           id="editName"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           id="editEmail"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white rounded-xl px-4 py-3 font-semibold hover:bg-blue-700 transition">
                    Update Data
                </button>

            </div>

        </form>

    </div>

</div>

<!-- SCRIPT -->
<script>

    // DETAIL MODAL
    function openDetailModal(name, email, created)
    {
        document.getElementById('detailName').innerText = name;
        document.getElementById('detailEmail').innerText = email;
        document.getElementById('detailCreated').innerText = created;

        document.getElementById('detailModal')
            .classList.remove('hidden');

        document.getElementById('detailModal')
            .classList.add('flex');
    }

    function closeDetailModal()
    {
        document.getElementById('detailModal')
            .classList.add('hidden');

        document.getElementById('detailModal')
            .classList.remove('flex');
    }

    // EDIT MODAL
    function openEditModal(id, name, email)
    {
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;

        document.getElementById('editForm').action =
            `/admin/users/${id}`;

        document.getElementById('editModal')
            .classList.remove('hidden');

        document.getElementById('editModal')
            .classList.add('flex');
    }

    function closeEditModal()
    {
        document.getElementById('editModal')
            .classList.add('hidden');

        document.getElementById('editModal')
            .classList.remove('flex');
    }

</script>

@endsection