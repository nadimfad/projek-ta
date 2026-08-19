@extends('admin.layout')

@section('title', 'Manajemen User')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Dosen</h2>
            <p class="mt-1 text-sm text-gray-400">Kelola data dosen dan akun login yang memakai NIP sebagai username.</p>
        </div>

        <button type="button"
            onclick="openCreateModal()"
            class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700">
            Buat Akun Dosen
        </button>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-5 py-4">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="relative flex-1">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama dosen..."
                        class="w-full rounded-xl border-gray-200 bg-gray-50 py-3 pl-12 pr-4 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        Cari
                    </button>

                    @if (request('search'))
                        <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-center text-sm">
                <thead class="bg-gray-50 text-[11px] uppercase tracking-widest text-gray-400">
                    <tr>
                        <th class="px-6 py-4 text-center font-semibold">Nama</th>
                        <th class="px-6 py-4 text-center font-semibold">NIP</th>
                        <th class="px-6 py-4 text-center font-semibold">Email</th>
                        <th class="px-6 py-4 text-center font-semibold">Role</th>
                        <th class="px-6 py-4 text-center font-semibold">Dibuat</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($users as $user)
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-6 py-5 align-middle font-semibold text-gray-700">{{ $user->dosen?->nama ?? '-' }}</td>
                        <td class="px-6 py-5 align-middle text-gray-500">{{ $user->dosen?->nip ?? $user->username }}</td>
                        <td class="px-6 py-5 align-middle text-gray-500">{{ $user->dosen?->email ?? '-' }}</td>
                        <td class="px-6 py-5 align-middle">
                            <span class="inline-flex rounded-lg px-3 py-1 text-xs font-bold uppercase tracking-wide {{ $user->role === 'kajur' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $user->role === 'kajur' ? 'Dosen + Kajur' : 'Dosen' }}
                            </span>
                        </td>
                        <td class="px-6 py-5 align-middle text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-5 align-middle">
                            @php
                                $editData = [
                                    'id' => $user->id_user,
                                    'nama' => $user->dosen?->nama ?? '',
                                    'nip' => $user->dosen?->nip ?? $user->username,
                                    'email' => $user->dosen?->email ?? '',
                                    'role' => $user->role,
                                ];
                            @endphp
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                    data-edit='@json($editData)'
                                    onclick="openEditModal(JSON.parse(this.dataset.edit))"
                                    class="rounded-lg bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-200">
                                    Edit
                                </button>

                                <form action="{{ route('admin.users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun dosen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-200">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400">
                            {{ request('search') ? 'Nama dosen tidak ditemukan.' : 'Belum ada akun dosen.' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="flex flex-col gap-4 border-t border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm font-medium text-gray-500">
                    Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} data
                </p>

                <div class="flex items-center justify-center gap-2">
                    @if ($users->onFirstPage())
                        <span class="rounded-xl border border-gray-200 bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-400">
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                            Sebelumnya
                        </a>
                    @endif

                    <span class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white shadow-sm">
                        {{ $users->currentPage() }} / {{ $users->lastPage() }}
                    </span>

                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-600 hover:text-white">
                            Selanjutnya
                        </a>
                    @else
                        <span class="rounded-xl border border-gray-200 bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-400">
                            Selanjutnya
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between gap-4 border-b border-gray-100 px-6 py-5">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Buat Akun Dosen</h2>
                <p class="mt-1 text-sm text-gray-400">Dosen dapat login menggunakan NIP atau email yang dibuat admin.</p>
            </div>
            <button type="button" onclick="closeCreateModal()" class="rounded-xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-200">
                Tutup
            </button>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('admin.users.store') }}" class="w-full">
                @csrf

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-600">Nama Dosen</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                        @error('nama') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-600">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                        @error('nip') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-600">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                        @error('email') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-600">Password</label>
                        <input type="password" name="password" class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                        @error('password') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-600">Role Akun</label>
                        <select name="role" class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="dosen" {{ old('role', 'dosen') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="kajur" {{ old('role') === 'kajur' ? 'selected' : '' }}>Dosen + Kajur</option>
                        </select>
                        @error('role') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-gray-600">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full rounded-xl border-gray-200 bg-white px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeCreateModal()" class="rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
        <div class="mb-6 flex items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-gray-800">Edit Dosen</h2>
            <button type="button" onclick="closeEditModal()" class="rounded-lg bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-600 hover:bg-gray-200">
                Tutup
            </button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-600">Nama Dosen</label>
                    <input type="text" name="nama" id="editNama" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-600">NIP</label>
                    <input type="text" name="nip" id="editNip" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-600">Email</label>
                    <input type="email" name="email" id="editEmail" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-600">Role Akun</label>
                    <select name="role" id="editRole" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="dosen">Dosen</option>
                        <option value="kajur">Dosen + Kajur</option>
                    </select>
                </div>

                <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-3 font-semibold text-white transition hover:bg-blue-700">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
<div id="userErrorPopup"
     class="fixed top-6 right-6 z-[9999] translate-x-[120%] opacity-0 transition-all duration-500">
    <div class="flex min-w-[340px] max-w-md items-start gap-4 rounded-2xl border border-red-100 bg-white px-5 py-4 shadow-2xl">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-red-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
            </svg>
        </div>

        <div class="flex-1">
            <h3 class="text-sm font-bold text-slate-800">Data Tidak Bisa Disimpan</h3>
            <ul class="mt-2 space-y-1 text-sm text-slate-500">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <button type="button" onclick="closeUserErrorPopup()" class="text-xl leading-none text-gray-400 transition hover:text-red-500">
            x
        </button>
    </div>
</div>
@endif

<script>
    const createModal = document.getElementById('createModal');
    const editModal = document.getElementById('editModal');

    function openCreateModal() {
        createModal.classList.remove('hidden');
        createModal.classList.add('flex');
    }

    function closeCreateModal() {
        createModal.classList.add('hidden');
        createModal.classList.remove('flex');
    }

    function openEditModal(data) {
        document.getElementById('editNama').value = data.nama ?? '';
        document.getElementById('editNip').value = data.nip ?? '';
        document.getElementById('editEmail').value = data.email ?? '';
        document.getElementById('editRole').value = data.role ?? 'dosen';
        document.getElementById('editForm').action = `/admin/users/${data.id}`;
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
        editModal.classList.remove('flex');
    }

    createModal.addEventListener('click', function (event) {
        if (event.target === createModal) {
            closeCreateModal();
        }
    });

    editModal.addEventListener('click', function (event) {
        if (event.target === editModal) {
            closeEditModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
        }
    });

    @if ($errors->any())
        const userErrorPopup = document.getElementById('userErrorPopup');

        setTimeout(() => {
            userErrorPopup.classList.remove('translate-x-[120%]', 'opacity-0');
        }, 100);

        setTimeout(() => {
            closeUserErrorPopup();
        }, 5000);

        function closeUserErrorPopup() {
            userErrorPopup.classList.add('translate-x-[120%]', 'opacity-0');
        }
    @endif
</script>
@endsection
