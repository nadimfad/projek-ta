<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Laporan</h2>
    </x-slot>

    <x-card>
        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="nama_pelapor"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Kegiatan -->
            <div class="mb-4">
    <label class="block mb-1">Kegiatan</label>
    <select name="kegiatan" 
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        <option value="" disabled selected>Pilih jenis kegiatan</option>
        <option value="Seminar Kerja Praktek">Seminar Kerja Praktek</option>
        <option value="Seminar Proposal">Seminar Proposal</option>
        <option value="Seminar Hasil/Sidang Tertutup">Seminar Hasil / Sidang Tertutup</option>
        <option value="Seminar Akhir/Sidang Terbuka">Seminar Akhir / Sidang Terbuka</option>
    </select>
</div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <textarea name="deskripsi"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="menunggu">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <!-- Upload Bukti -->
            <div class="mb-4">
                <label class="block mb-1">Upload Bukti</label>
                <input type="file" name="bukti"
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2 bg-white">
                <p class="text-sm text-gray-500 mt-1">
                    Format: JPG, PNG, PDF (Max 2MB)
                </p>
            </div>

            <!-- Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Simpan
                </button>
            </div>

        </form>
    </x-card>

</x-app-layout>