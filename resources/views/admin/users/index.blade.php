@extends('layouts.admin')

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
        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-center text-sm">
                <thead class="bg-gray-50 text-[11px] uppercase tracking-widest text-gray-400">
                    <tr>
                        <th class="px-6 py-4 text-center font-semibold">Nama</th>
                        <th class="px-6 py-4 text-center font-semibold">NIP</th>
                        <th class="px-6 py-4 text-center font-semibold">Email</th>
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
                        <td class="px-6 py-5 align-middle text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-5 align-middle">
                            @php
                                $editData = [
                                    'id' => $user->id_user,
                                    'nama' => $user->dosen?->nama ?? '',
                                    'nip' => $user->dosen?->nip ?? $user->username,
                                    'email' => $user->dosen?->email ?? '',
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
                        <td colspan="5" class="py-12 text-center text-gray-400">Belum ada akun dosen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Buat Akun Dosen</h2>
                <p class="mt-1 text-sm text-gray-400">Username login dosen otomatis memakai NIP.</p>
            </div>
            <button type="button" onclick="closeCreateModal()" class="rounded-lg bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-600 hover:bg-gray-200">
                Tutup
            </button>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-600">Nama Dosen</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                @error('nama') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-600">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                @error('nip') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-600">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                @error('email') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-600">Password</label>
                <input type="password" name="password" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
                @error('password') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-600">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-blue-500 focus:ring-blue-500" required>
            </div>

            <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-3 font-semibold text-white transition hover:bg-blue-700">
                Simpan Akun
            </button>
        </form>
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

                <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-3 font-semibold text-white transition hover:bg-blue-700">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>

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
</script>
@endsection
