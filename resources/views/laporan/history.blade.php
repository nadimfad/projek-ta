@extends('laporan.layout')

@section('title', 'History Laporan')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Riwayat Seluruh Laporan</h1>
        <p class="text-slate-500 mt-1">Semua riwayat laporan yang pernah dikirim</p>
    </div>

    <form method="GET" action="{{ route('laporan.history') }}">
        <input type="text" name="search" placeholder="Cari laporan..." value="{{ request('search') }}" class="w-full md:w-[300px] bg-white border border-slate-200 rounded-2xl px-5 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
    </form>
</div>

<div class="bg-white rounded-[28px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[920px] text-sm text-center">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="px-6 py-5 text-center font-semibold">Mahasiswa</th>
                    <th class="px-6 py-5 text-center font-semibold">NIM</th>
                    <th class="px-6 py-5 text-center font-semibold">Kegiatan</th>
                    <th class="px-6 py-5 text-center font-semibold">Bentuk Gratifikasi</th>
                    <th class="px-6 py-5 text-center font-semibold">Keterangan</th>
                    <th class="px-6 py-5 text-center font-semibold">Foto</th>
                    <th class="px-6 py-5 text-center font-semibold">Tanggal</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($laporans as $laporan)
                <tr class="hover:bg-slate-50 transition duration-200">
                    <td class="px-6 py-5 font-semibold text-slate-800 align-middle">{{ $laporan->nama_mahasiswa }}</td>
                    <td class="px-6 py-5 text-slate-500 align-middle">{{ $laporan->nim_mahasiswa }}</td>
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
                    <td class="px-6 py-5 text-slate-500 align-middle">{{ $laporan->bentuk_gratifikasi }}</td>
                    <td class="px-6 py-5 text-slate-500">
                        <p class="mx-auto max-w-[220px] truncate" title="{{ $laporan->keterangan }}">{{ $laporan->keterangan ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-5 text-slate-500">
                        <div class="flex flex-wrap justify-center gap-2">
                            @forelse($laporan->buktiLaporans->whereNotNull('file_path') as $bukti)
                                <a href="{{ asset('storage/'.$bukti->file_path) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline">
                                    Foto {{ $loop->iteration }}
                                </a>
                            @empty
                                <span class="text-slate-300">-</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 py-5 text-slate-500 align-middle">{{ $laporan->tanggal_kegiatan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-14 text-slate-400 text-lg">Belum ada history laporan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
