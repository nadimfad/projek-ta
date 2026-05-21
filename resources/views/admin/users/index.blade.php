@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-[420px_1fr] gap-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-lg font-bold text-gray-800">Buat Akun Dosen</h2>
        <p class="text-sm text-gray-400 mt-1">Akun baru otomatis mendapat role dosen.</p>

        <form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                @error('name')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                @error('email')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Password</label>
                <input type="password" name="password" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                @error('password')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
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
                        <th class="px-6 py-4 text-left font-semibold">Email</th>
                        <th class="px-6 py-4 text-right font-semibold">Dibuat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-5 font-semibold text-gray-700">{{ $user->name }}</td>
                        <td class="px-6 py-5 text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-5 text-right text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-12 text-gray-400">Belum ada akun dosen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
