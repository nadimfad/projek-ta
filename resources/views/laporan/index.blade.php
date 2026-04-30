<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">Data Laporan</h2>
    </x-slot>

    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-lg font-bold">Semua Laporan</h1>

        <a href="{{ route('laporan.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            + Tambah Laporan
        </a>
    </div>

    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b text-gray-500">
                    <tr>
                        <th class="py-3">Nama</th>
                        <th>Kegiatan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($laporans as $laporan)
                    <tr class="hover:bg-gray-50 transition">

                        <!-- Nama -->
                        <td class="py-3">{{ $laporan->nama_pelapor }}</td>

                        <!-- Kegiatan -->
                        <td>{{ $laporan->kegiatan }}</td>

                        <!-- Status -->
                        <td>
    @if(auth()->user()->role == 'admin')
        <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <select name="status"
                onchange="this.form.submit()"
                class="text-xs rounded border-gray-300">

                <option value="menunggu" {{ $laporan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>

        </form>
    @else
<span class="px-3 py-1 text-xs rounded-full font-semibold
    @if($laporan->status == 'diterima') bg-green-100 text-green-600
    @elseif($laporan->status == 'ditolak') bg-red-100 text-red-600
    @else bg-yellow-100 text-yellow-600
    @endif">
    {{ ucfirst($laporan->status) }}
</span>
    @endif
</td>

                        <!-- Tanggal -->
                        <td>{{ $laporan->created_at->format('d M Y') }}</td>

                        <!-- Bukti -->
                        <td>
                            @if ($laporan->bukti)
                                <a href="{{ asset('storage/' . $laporan->bukti) }}"
                                   target="_blank"
                                   class="text-blue-500 hover:underline">
                                   Lihat
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <a href="{{ route('laporan.show', $laporan->id) }}"
                         class="text-green-500 hover:underline">
                            Detail
                        </a>
                        
                        <td class="flex gap-2">
                            <a href="{{ route('laporan.edit', $laporan->id) }}"
                               class="text-blue-500 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus data?')">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-500 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Belum ada data laporan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

</x-app-layout>