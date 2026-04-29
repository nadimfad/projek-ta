<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Laporan</h2>
    </x-slot>

    <x-card>
        <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="nama_pelapor"
                    value="{{ $laporan->nama_pelapor }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email"
                    value="{{ $laporan->email }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Kegiatan</label>
                <input type="text" name="kegiatan"
                    value="{{ $laporan->kegiatan }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <textarea name="deskripsi"
                    class="w-full border-gray-300 rounded-lg shadow-sm">{{ $laporan->deskripsi }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status"
                    class="w-full border-gray-300 rounded-lg shadow-sm">
                    <option value="menunggu" {{ $laporan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Update
            </button>

        </form>
    </x-card>

</x-app-layout>