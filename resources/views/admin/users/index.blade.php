@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-[420px_1fr] gap-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-lg font-bold text-gray-800">Buat Akun Dosen</h2>
        <p class="text-sm text-gray-400 mt-1">Username login dosen otomatis memakai NIP.</p>

        <form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Dosen</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                @error('nama') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                @error('nip') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                @error('email') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Password</label>
                <input type="password" name="password" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                @error('password') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <button class="w-full bg-blue-600 text-white rounded-xl px-4 py-3 font-semibold hover:bg-blue-700 transition">
                Simpan Akun
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Daftar Dosen</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-400 uppercase text-[11px] tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold">NIP</th>
                        <th class="px-6 py-4 text-left font-semibold">Email</th>
                        <th class="px-6 py-4 text-center font-semibold">Dibuat</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-5 font-semibold text-gray-700">{{ $user->dosen?->nama ?? '-' }}</td>
                        <td class="px-6 py-5 text-gray-500">{{ $user->dosen?->nip ?? $user->username }}</td>
                        <td class="px-6 py-5 text-gray-500">{{ $user->dosen?->email ?? '-' }}</td>
                        <td class="px-6 py-5 text-center text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    onclick="openEditModal('{{ $user->id_user }}', '{{ $user->dosen?->nama }}', '{{ $user->dosen?->nip ?? $user->username }}', '{{ $user->dosen?->email }}')"
                                    class="px-3 py-2 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 transition text-xs font-semibold">
                                    Edit
                                </button>

                                <form action="{{ route('admin.users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun dosen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition text-xs font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-400">Belum ada akun dosen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">Edit Dosen</h2>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-red-500 text-xl">x</button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Dosen</label>
                    <input type="text" name="nama" id="editNama" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">NIP</label>
                    <input type="text" name="nip" id="editNip" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Email</label>
                    <input type="email" name="email" id="editEmail" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white rounded-xl px-4 py-3 font-semibold hover:bg-blue-700 transition">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nama, nip, email) {
        document.getElementById('editNama').value = nama ?? '';
        document.getElementById('editNip').value = nip ?? '';
        document.getElementById('editEmail').value = email ?? '';
        document.getElementById('editForm').action = `/admin/users/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>
@endsection
