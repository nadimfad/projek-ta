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

                        <!-- Kegiatan -->
                        <td class="py-3">{{ $laporan->kegiatan }}</td>

                        <!-- Status -->
                        <td>
                            <span class="px-3 py-1 text-xs rounded-full font-semibold
                                @if($laporan->status == 'diterima') bg-green-100 text-green-600
                                @elseif($laporan->status == 'ditolak') bg-red-100 text-red-600
                                @else bg-yellow-100 text-yellow-600
                                @endif">
                                {{ ucfirst($laporan->status) }}
                            </span>
                        </td>

                        <!-- Tanggal -->
                        <td>{{ $laporan->created_at->format('d M Y') }}</td>

                        <!-- Bukti (Preview Modal) -->
                        <td>
                            @if ($laporan->bukti)
                                <img src="{{ asset('storage/' . $laporan->bukti) }}"
                                     onclick="openModal(this.src)"
                                     class="w-16 h-16 object-cover rounded cursor-pointer hover:scale-110 transition">
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

    <!-- 🔥 MODAL PREVIEW -->
    <div id="imageModal"
         class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">

        <img id="modalImage"
             class="max-w-3xl w-full rounded-lg shadow-lg">

    </div>

    <!-- 🔥 SCRIPT MODAL -->
    <script>
        function openModal(src) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');

            img.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // klik luar gambar = close
        document.getElementById('imageModal').addEventListener('click', function(e){
            if(e.target === this) closeModal();
        });

        // tekan ESC = close
        document.addEventListener('keydown', function(e){
            if(e.key === "Escape") closeModal();
        });
    </script>

</x-app-layout>