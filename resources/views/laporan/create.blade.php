<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Laporan - SIKAWAN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f5f7fb] min-h-screen">

    <!-- HEADER -->
    <header class="bg-white border-b border-slate-100">

        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

            <!-- LOGO -->
            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center shadow-md">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 3l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V7l8-4z"/>

                    </svg>

                </div>

                <h1 class="text-2xl font-bold text-slate-800">
                    SIKAWAN
                </h1>

            </div>

            <!-- TITLE -->
            <p class="uppercase tracking-[4px] text-sm font-semibold text-slate-400">
                Formulir Pelaporan Gratifikasi
            </p>

        </div>

    </header>

    <!-- CONTENT -->
    <section class="py-12 px-4">

        <div class="max-w-3xl mx-auto">

            <!-- BACK -->
            <a href="{{ route('laporan.index') }}"
               class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition mb-8">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 19l-7-7 7-7"/>

                </svg>

                Batal & Kembali
            </a>

            <!-- PROGRESS -->
            <div class="grid grid-cols-3 gap-4 mb-10">

                <div class="h-2 rounded-full bg-indigo-600"></div>
                <div class="h-2 rounded-full bg-slate-200"></div>
                <div class="h-2 rounded-full bg-slate-200"></div>

            </div>

            <!-- CARD -->
            <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 p-8 md:p-12">

                <!-- TITLE -->
                <div class="flex items-start gap-5 mb-10">

                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-8 h-8 text-indigo-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5.121 17.804A9 9 0 1118 21H6a1 1 0 01-.879-1.496z"/>

                        </svg>

                    </div>

                    <div>

                        <h2 class="text-3xl font-bold text-slate-900">
                            Data Pelapor
                        </h2>

                        <p class="text-slate-400 uppercase tracking-widest text-sm mt-1">
                            Langkah 1 Dari 3
                        </p>

                    </div>

                </div>

                <!-- FORM -->
                <form action="{{ route('laporan.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-8">

                    @csrf

                    <!-- GRID -->
                    <div class="grid md:grid-cols-2 gap-6">

                        <!-- NAMA -->
                        <div>

                            <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">
                                Nama Lengkap
                            </label>

                            <input type="text"
                                   name="nama_pelapor"
                                   value="{{ old('nama_pelapor', auth()->user()->name) }}"
                                   placeholder="Masukkan nama"
                                   readonly
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">

                        </div>

                        <!-- EMAIL -->
                        <div>

                            <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   placeholder="nama@email.com"
                                   readonly
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-5 py-4 text-slate-500 outline-none cursor-not-allowed focus:ring-2 focus:ring-indigo-500">

                        </div>

                    </div>

                    <!-- KEGIATAN -->
                    <div>

                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">
                            Jenis Kegiatan
                        </label>

                        <select name="kegiatan"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">

                            <option disabled selected>
                                Pilih jenis kegiatan
                            </option>

                            <option value="Seminar Kerja Praktek">
                                Seminar Kerja Praktek
                            </option>

                            <option value="Seminar Proposal">
                                Seminar Proposal
                            </option>

                            <option value="Seminar Hasil/Sidang Tertutup">
                                Seminar Hasil / Sidang Tertutup
                            </option>

                            <option value="Seminar Akhir/Sidang Terbuka">
                                Seminar Akhir / Sidang Terbuka
                            </option>

                        </select>

                    </div>

                    <!-- DESKRIPSI -->
                    <div>

                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">
                            Deskripsi
                        </label>

                        <textarea name="deskripsi"
                                  rows="5"
                                  placeholder="Tuliskan detail laporan..."
                                  class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none resize-none focus:ring-2 focus:ring-indigo-500"></textarea>

                    </div>

                    <!-- STATUS -->
                    <div>

                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">
                            Status
                        </label>

                        <select name="status"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">

                            <option value="menunggu">Menunggu</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>

                        </select>

                    </div>

                    <!-- FILE -->
                    <div>

                        <label class="block text-sm font-bold tracking-wider uppercase text-slate-400 mb-3">
                            Upload Bukti
                        </label>

                        <div class="border-2 border-dashed border-slate-300 rounded-3xl p-10 text-center bg-slate-50">

                            <input type="file"
                                   name="bukti"
                                   id="uploadFile"
                                   class="hidden">

                            <label for="uploadFile" class="cursor-pointer">

                                <p class="font-semibold text-slate-700">
                                    Klik untuk upload file
                                </p>

                                <p class="text-sm text-slate-400 mt-1">
                                    JPG, PNG, PDF • Max 2MB
                                </p>

                            </label>

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl text-lg font-semibold shadow-lg transition-all duration-300 hover:scale-[1.01]">

                        Submit

                    </button>

                </form>

            </div>

        </div>

    </section>

</body>
</html>
