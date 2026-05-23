@extends('laporan.layout')

@section('title', 'Laporan Saya')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Laporan Saya</h2>
            <p class="text-sm text-gray-400 mt-1">Pantau laporan yang pernah Anda kirim.</p>
        </div>

        <div class="flex flex-wrap gap-3">
            <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan..." class="w-full md:w-[260px] rounded-lg border-gray-200 text-sm shadow-sm">

                <select name="id_kegiatan" class="border-gray-200 rounded-lg shadow-sm text-sm">
                    <option value="">Semua Kegiatan</option>
                    @foreach($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->id_kegiatan }}" {{ request('id_kegiatan') == $kegiatan->id_kegiatan ? 'selected' : '' }}>
                            {{ $kegiatan->jenis_kegiatan }}
                        </option>
                    @endforeach
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Filter</button>
            </form>

            <a href="{{ route('laporan.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition">
                Tambah Laporan
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-400 uppercase text-[11px] tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Mahasiswa</th>
                        <th class="px-6 py-4 text-left font-semibold">NIM</th>
                        <th class="px-6 py-4 text-left font-semibold">Kegiatan</th>
                        <th class="px-6 py-4 text-left font-semibold">Bentuk Gratifikasi</th>
                        <th class="px-6 py-4 text-left font-semibold">Keterangan</th>
                        <th class="px-6 py-4 text-left font-semibold">Foto</th>
                        <th class="px-6 py-4 text-right font-semibold">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse($laporans as $laporan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-5 font-semibold text-gray-700">{{ $laporan->nama_mahasiswa }}</td>
                        <td class="px-6 py-5 text-gray-500">{{ $laporan->nim_mahasiswa }}</td>
                        <td class="px-6 py-5 text-gray-500">{{ $laporan->kegiatan?->jenis_kegiatan ?? '-' }}</td>
                        <td class="px-6 py-5 text-gray-500">{{ $laporan->bentuk_gratifikasi }}</td>
                        <td class="px-6 py-5 text-gray-500">{{ $laporan->keterangan ?? '-' }}</td>
                        <td class="px-6 py-5 text-gray-500">
                            <div class="flex flex-wrap gap-2">
                                @forelse($laporan->buktiLaporans->whereNotNull('file_path') as $bukti)
                                    <a href="{{ asset('storage/'.$bukti->file_path) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline">
                                        Foto {{ $loop->iteration }}
                                    </a>
                                @empty
                                    <span class="text-gray-300">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right text-gray-400">{{ $laporan->tanggal_kegiatan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-gray-400">Belum ada laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
