@extends('layouts.admin')

@section('title', 'Seluruh Laporan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Seluruh Laporan Dosen</h2>
            <p class="text-sm text-gray-400 mt-1">Semua laporan yang dikirim oleh dosen tersimpan di halaman ini.</p>
        </div>

        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap gap-3">
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
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1180px] text-sm text-center">
                <thead class="bg-gray-50 text-gray-400 uppercase text-[11px] tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-center font-semibold">Dosen</th>
                        <th class="px-6 py-4 text-center font-semibold">NIP</th>
                        <th class="px-6 py-4 text-center font-semibold">Email</th>
                        <th class="px-6 py-4 text-center font-semibold">Mahasiswa</th>
                        <th class="px-6 py-4 text-center font-semibold">NIM</th>
                        <th class="px-6 py-4 text-center font-semibold">Kegiatan</th>
                        <th class="px-6 py-4 text-center font-semibold">Bentuk</th>
                        <th class="px-6 py-4 text-center font-semibold">Foto</th>
                        <th class="px-6 py-4 text-center font-semibold">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse($laporans as $laporan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-5 font-semibold text-gray-700 align-middle">{{ $laporan->dosen?->nama ?? '-' }}</td>
                        <td class="px-6 py-5 text-gray-500 align-middle">{{ $laporan->dosen?->nip ?? '-' }}</td>
                        <td class="px-6 py-5 text-gray-500 align-middle">{{ $laporan->dosen?->email ?? '-' }}</td>
                        <td class="px-6 py-5 text-gray-500 align-middle">{{ $laporan->nama_mahasiswa }}</td>
                        <td class="px-6 py-5 text-gray-500 align-middle">{{ $laporan->nim_mahasiswa }}</td>
                        <td class="px-6 py-5">
                            @php
                                $jenisKegiatan = $laporan->kegiatan?->jenis_kegiatan;
                                $warnaKegiatan = match ($jenisKegiatan) {
                                    'Seminar Kerja Praktek' => 'bg-blue-100 text-blue-700',
                                    'Seminar Proposal' => 'bg-green-100 text-green-700',
                                    'Seminar Hasil/Sidang Tertutup' => 'bg-yellow-100 text-yellow-700',
                                    'Seminar Akhir/Sidang Terbuka' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="inline-flex justify-center px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wide {{ $warnaKegiatan }}">
                                {{ $jenisKegiatan ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-gray-500 align-middle">{{ $laporan->bentuk_gratifikasi }}</td>
                        <td class="px-6 py-5 text-gray-500">
                            <div class="flex flex-wrap justify-center gap-2">
                                @forelse($laporan->buktiLaporans->whereNotNull('file_path') as $bukti)
                                    <a href="{{ asset('storage/'.$bukti->file_path) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline">
                                        Foto {{ $loop->iteration }}
                                    </a>
                                @empty
                                    <span class="text-gray-300">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-5 text-gray-400 align-middle">{{ $laporan->tanggal_kegiatan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-12 text-gray-400">Belum ada laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
