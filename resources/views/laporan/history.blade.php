<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">History Laporan</h2>
    </x-slot>

    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b text-gray-500">
                    <tr>
                        <th class="py-3">Kegiatan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Bukti</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($laporans as $laporan)
                    <tr class="hover:bg-gray-50">

                        <td class="py-3">{{ $laporan->kegiatan }}</td>

                        <td>
                            <span class="px-3 py-1 text-xs rounded-full
                                @if($laporan->status == 'selesai') bg-green-100 text-green-600
                                @elseif($laporan->status == 'diproses') bg-yellow-100 text-yellow-600
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ $laporan->status }}
                            </span>
                        </td>

                        <td>{{ $laporan->created_at->format('d M Y') }}</td>

                        <td>
                            @if ($laporan->bukti)
                                <a href="{{ asset('storage/' . $laporan->bukti) }}"
                                   target="_blank"
                                   class="text-blue-500 underline">
                                   Lihat
                                </a>
                            @else
                                -
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            Belum ada history laporan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

</x-app-layout>