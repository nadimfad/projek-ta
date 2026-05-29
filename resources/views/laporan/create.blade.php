<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Laporan - SIKAWAN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f5f7fb] min-h-screen">
<header class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            {{-- <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V7l8-4z"/>
                </svg>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">SIKAWAN</h1> --}}
            <img 
        src="/images/logo1.png" 
        alt="Logo" 
        class="h-20 w-18 object-contain"
    />
        </div>

        <p class="uppercase tracking-[2px] sm:tracking-[4px] text-xs sm:text-sm font-semibold text-slate-400 text-center sm:text-right">
            Formulir Pelaporan Gratifikasi
        </p>
    </div>
</header>

<section class="py-8 sm:py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Batal & Kembali
        </a>

        <div class="bg-white rounded-3xl sm:rounded-[32px] shadow-sm border border-slate-100 p-5 sm:p-8 md:p-12">
            <div class="mb-8 sm:mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Data Laporan</h2>
                <p class="text-slate-400 uppercase tracking-widest text-sm mt-1">Lengkapi data gratifikasi</p>
            </div>

            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">Nama Dosen</label>
                        <input type="text" value="{{ auth()->user()->dosen?->nama }}" readonly class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-5 py-4 text-slate-500 outline-none cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">Email Dosen</label>
                        <input type="email" value="{{ auth()->user()->dosen?->email }}" readonly class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-5 py-4 text-slate-500 outline-none cursor-not-allowed">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">Nama Mahasiswa</label>
                        <input type="text" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500" required>
                        @error('nama_mahasiswa') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">NIM Mahasiswa</label>
                        <input type="text" name="nim_mahasiswa" value="{{ old('nim_mahasiswa') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500" required>
                        @error('nim_mahasiswa') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">Jenis Kegiatan</label>
                    <select name="id_kegiatan" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500" required>
                        <option value="">Pilih jenis kegiatan</option>
                        @foreach($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id_kegiatan }}" {{ old('id_kegiatan') == $kegiatan->id_kegiatan ? 'selected' : '' }}>
                                {{ $kegiatan->jenis_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kegiatan') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">Bentuk Gratifikasi</label>
                        <input type="text" name="bentuk_gratifikasi" value="{{ old('bentuk_gratifikasi') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500" required>
                        @error('bentuk_gratifikasi') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">Tanggal Kegiatan</label>
                        <input type="date" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', now()->toDateString()) }}" readonly class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-5 py-4 text-slate-500 outline-none cursor-not-allowed">
                        @error('tanggal_kegiatan') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">Upload Foto</label>
                    <input type="file" name="fotos[]" accept="image/*" capture="environment" multiple required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-slate-400 mt-2">Bisa memilih beberapa foto atau membuka kamera langsung pada perangkat yang mendukung.</p>
                    @error('fotos') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
                    @error('fotos.*') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">Keterangan</label>
                    <textarea name="keterangan" rows="5" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none resize-none focus:ring-2 focus:ring-indigo-500">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="text-sm text-red-500 mt-2">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl text-lg font-semibold shadow-lg transition-all duration-300 hover:scale-[1.01]">
                    Submit
                </button>
            </form>
        </div>
    </div>
</section>
</body>
</html>
