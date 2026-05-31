@extends('laporan.layout')

@section('title', 'Laporan Saya')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Laporan Saya</h2>
            <p class="text-slate-500 mt-1">Pantau laporan yang pernah Anda kirim.</p>
        </div>

        <div>
            <button type="button" onclick="openCreateReportModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                Tambah Laporan
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="space-y-3 p-4 md:hidden">
            @forelse($laporans as $laporan)
                @php
                    $jenisKegiatanMobile = $laporan->kegiatan?->jenis_kegiatan;
                    $warnaKegiatanMobile = match ($jenisKegiatanMobile) {
                        'Seminar Kerja Praktek' => 'bg-blue-100 text-blue-700',
                        'Seminar Proposal' => 'bg-green-100 text-green-700',
                        'Seminar Hasil/Sidang Tertutup' => 'bg-yellow-100 text-yellow-700',
                        'Seminar Akhir/Sidang Terbuka' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="truncate font-bold text-slate-800">{{ $laporan->nama_mahasiswa }}</p>
                            <p class="mt-1 text-xs font-medium text-slate-400">{{ $laporan->nim_mahasiswa }}</p>
                        </div>
                        <p class="whitespace-nowrap text-xs font-medium text-slate-400">{{ $laporan->tanggal_kegiatan }}</p>
                    </div>

                    <div class="mt-4">
                        <span class="inline-flex max-w-full whitespace-normal break-words rounded-lg px-2 py-1 text-[10px] font-bold uppercase leading-snug tracking-wide {{ $warnaKegiatanMobile }}">
                            {{ $jenisKegiatanMobile ?? '-' }}
                        </span>
                    </div>

                    <div class="mt-4 flex items-end justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">Bentuk Gratifikasi</p>
                            <p class="mt-1 truncate text-sm text-slate-600">{{ $laporan->bentuk_gratifikasi }}</p>
                        </div>
                        <div class="flex shrink-0 gap-2">
                            @forelse($laporan->buktiLaporans->whereNotNull('file_path')->take(2) as $bukti)
                                <button type="button"
                                    onclick="openPhotoModal('{{ asset('storage/'.$bukti->file_path) }}')"
                                    class="h-10 w-10 overflow-hidden rounded-lg border border-slate-200 bg-white transition hover:ring-2 hover:ring-blue-400">
                                    <img src="{{ asset('storage/'.$bukti->file_path) }}" alt="Foto gratifikasi" class="h-full w-full object-cover">
                                </button>
                            @empty
                                <span class="text-sm text-slate-300">-</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <p class="py-8 text-center text-sm text-slate-400">Belum ada laporan.</p>
            @endforelse
        </div>

        <div class="hidden overflow-x-auto md:block">
            <table class="w-full min-w-[820px] text-sm text-center">
                <thead class="bg-gray-50 text-gray-400 uppercase text-[11px] tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-center font-semibold">Mahasiswa</th>
                        <th class="px-6 py-4 text-center font-semibold">NIM</th>
                        <th class="px-6 py-4 text-center font-semibold">Kegiatan</th>
                        <th class="px-6 py-4 text-center font-semibold">Bentuk Gratifikasi</th>
                        <th class="px-6 py-4 text-center font-semibold">Foto</th>
                        <th class="px-6 py-4 text-center font-semibold">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse($laporans as $laporan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-5 font-semibold text-gray-700 align-middle">{{ $laporan->nama_mahasiswa }}</td>
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
                                    <button type="button"
                                        onclick="openPhotoModal('{{ asset('storage/'.$bukti->file_path) }}')"
                                        class="h-10 w-10 overflow-hidden rounded-lg border border-gray-200 bg-gray-50 hover:ring-2 hover:ring-blue-400 transition"
                                        title="Review foto {{ $loop->iteration }}">
                                        <img src="{{ asset('storage/'.$bukti->file_path) }}" alt="Foto gratifikasi" class="h-full w-full object-cover">
                                    </button>
                                @empty
                                    <span class="text-gray-300">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-5 text-gray-400 align-middle">{{ $laporan->tanggal_kegiatan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-gray-400">Belum ada laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="createReportModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="max-h-[92vh] w-full max-w-4xl overflow-y-auto rounded-3xl bg-white shadow-2xl">
        <div class="sticky top-0 z-10 border-b border-slate-100 bg-white px-6 py-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Tambah Laporan</h3>
                    <p class="mt-1 text-sm text-slate-400">Lengkapi laporan melalui 3 tahapan berikut.</p>
                </div>

                <button type="button" onclick="closeCreateReportModal()" class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-200">
                    Tutup
                </button>
            </div>

            <div class="mt-5 grid grid-cols-3 gap-3 text-center text-xs font-bold text-slate-400">
                <div id="stepIndicator1" class="rounded-full bg-blue-600 px-3 py-2 text-white">1. Identitas</div>
                <div id="stepIndicator2" class="rounded-full bg-slate-100 px-3 py-2">2. Kegiatan</div>
                <div id="stepIndicator3" class="rounded-full bg-slate-100 px-3 py-2">3. Bukti</div>
            </div>
        </div>

        <form id="createReportForm" action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div id="reportStep1" class="report-step space-y-6">
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Nama Dosen</label>
                        <input type="text" value="{{ auth()->user()->dosen?->nama }}" readonly class="w-full cursor-not-allowed rounded-2xl border border-slate-200 bg-slate-100 px-5 py-4 text-slate-500 outline-none">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Email Dosen</label>
                        <input type="email" value="{{ auth()->user()->dosen?->email }}" readonly class="w-full cursor-not-allowed rounded-2xl border border-slate-200 bg-slate-100 px-5 py-4 text-slate-500 outline-none">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Nama Mahasiswa</label>
                        <input type="text" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('nama_mahasiswa') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">NIM Mahasiswa</label>
                        <input type="text" name="nim_mahasiswa" value="{{ old('nim_mahasiswa') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('nim_mahasiswa') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div id="reportStep2" class="report-step hidden space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Jenis Kegiatan</label>
                    <select name="id_kegiatan" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih jenis kegiatan</option>
                        @foreach($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id_kegiatan }}" {{ old('id_kegiatan') == $kegiatan->id_kegiatan ? 'selected' : '' }}>
                                {{ $kegiatan->jenis_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kegiatan') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Bentuk Gratifikasi</label>
                        <input type="text" name="bentuk_gratifikasi" value="{{ old('bentuk_gratifikasi') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('bentuk_gratifikasi') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Tanggal Kegiatan</label>
                        <input type="date" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', now()->toDateString()) }}" readonly class="w-full cursor-not-allowed rounded-2xl border border-slate-200 bg-slate-100 px-5 py-4 text-slate-500 outline-none">
                        @error('tanggal_kegiatan') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div id="reportStep3" class="report-step hidden space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Upload Foto</label>
                    <input id="reportPhotoInput" type="file" name="fotos[]" accept="image/*" capture="environment" multiple required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="mt-2 text-xs text-slate-400">Bisa memilih beberapa foto atau membuka kamera langsung. Foto di atas 2 MB akan disiapkan otomatis sebelum dikirim.</p>
                    <p id="reportPhotoStatus" class="mt-2 hidden text-xs font-semibold"></p>
                    @error('fotos') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    @error('fotos.*') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Keterangan</label>
                    <textarea name="keterangan" rows="5" required class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-700 outline-none focus:ring-2 focus:ring-blue-500">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-between">
                <button type="button" id="prevReportStepButton" onclick="prevReportStep()" class="hidden rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Sebelumnya
                </button>

                <div class="flex justify-end gap-3 sm:ml-auto">
                    <button type="button" onclick="closeCreateReportModal()" class="rounded-2xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="button" id="nextReportStepButton" onclick="nextReportStep()" class="rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Selanjutnya
                    </button>
                    <button type="submit" id="submitReportButton" class="hidden rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Simpan Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="photoModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 p-4">
    <div class="relative max-h-[90vh] w-full max-w-4xl">
        <button type="button" onclick="closePhotoModal()" class="absolute -top-10 right-0 rounded-lg bg-white/90 px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-white">
            Tutup
        </button>
        <img id="photoModalImage" src="" alt="Preview foto gratifikasi" class="max-h-[90vh] w-full rounded-2xl object-contain bg-white shadow-2xl">
    </div>
</div>

<script>
    const photoModal = document.getElementById('photoModal');
    const photoModalImage = document.getElementById('photoModalImage');
    const createReportModal = document.getElementById('createReportModal');
    const createReportForm = document.getElementById('createReportForm');
    const reportSteps = [
        document.getElementById('reportStep1'),
        document.getElementById('reportStep2'),
        document.getElementById('reportStep3'),
    ];
    const stepIndicators = [
        document.getElementById('stepIndicator1'),
        document.getElementById('stepIndicator2'),
        document.getElementById('stepIndicator3'),
    ];
    const prevReportStepButton = document.getElementById('prevReportStepButton');
    const nextReportStepButton = document.getElementById('nextReportStepButton');
    const submitReportButton = document.getElementById('submitReportButton');
    const reportPhotoInput = document.getElementById('reportPhotoInput');
    const reportPhotoStatus = document.getElementById('reportPhotoStatus');
    const maxPhotoBytes = 2 * 1024 * 1024;
    let currentReportStep = 1;
    let photoPreparationToken = 0;
    let photosArePreparing = false;

    function openCreateReportModal(step = 1) {
        createReportModal.classList.remove('hidden');
        createReportModal.classList.add('flex');
        showReportStep(step);
    }

    function closeCreateReportModal() {
        createReportModal.classList.add('hidden');
        createReportModal.classList.remove('flex');
    }

    function showReportStep(step) {
        currentReportStep = step;

        reportSteps.forEach((element, index) => {
            element.classList.toggle('hidden', index + 1 !== step);
        });

        stepIndicators.forEach((element, index) => {
            const isActive = index + 1 === step;
            element.classList.toggle('bg-blue-600', isActive);
            element.classList.toggle('text-white', isActive);
            element.classList.toggle('bg-slate-100', !isActive);
            element.classList.toggle('text-slate-400', !isActive);
        });

        prevReportStepButton.classList.toggle('hidden', step === 1);
        nextReportStepButton.classList.toggle('hidden', step === 3);
        submitReportButton.classList.toggle('hidden', step !== 3);
    }

    function validateCurrentReportStep() {
        const fields = reportSteps[currentReportStep - 1].querySelectorAll('input, select, textarea');

        for (const field of fields) {
            if (!field.checkValidity()) {
                field.reportValidity();
                return false;
            }
        }

        return true;
    }

    function nextReportStep() {
        if (currentReportStep < 3 && validateCurrentReportStep()) {
            showReportStep(currentReportStep + 1);
        }
    }

    function prevReportStep() {
        if (currentReportStep > 1) {
            showReportStep(currentReportStep - 1);
        }
    }

    function updatePhotoStatus(message = '', type = 'info') {
        reportPhotoStatus.textContent = message;
        reportPhotoStatus.classList.toggle('hidden', message === '');
        reportPhotoStatus.classList.toggle('text-blue-600', type === 'info');
        reportPhotoStatus.classList.toggle('text-green-600', type === 'success');
        reportPhotoStatus.classList.toggle('text-red-500', type === 'error');
    }

    function setPhotoPreparationState(isPreparing) {
        photosArePreparing = isPreparing;
        submitReportButton.disabled = isPreparing;
        submitReportButton.classList.toggle('cursor-wait', isPreparing);
        submitReportButton.classList.toggle('opacity-60', isPreparing);
        submitReportButton.textContent = isPreparing ? 'Menyiapkan Foto...' : 'Simpan Laporan';
    }

    async function loadPhoto(file) {
        if ('createImageBitmap' in window) {
            return createImageBitmap(file, { imageOrientation: 'from-image' });
        }

        return new Promise((resolve, reject) => {
            const image = new Image();
            const url = URL.createObjectURL(file);

            image.onload = () => {
                URL.revokeObjectURL(url);
                resolve(image);
            };
            image.onerror = () => {
                URL.revokeObjectURL(url);
                reject(new Error('Foto tidak dapat dibaca.'));
            };
            image.src = url;
        });
    }

    function canvasToJpeg(canvas, quality) {
        return new Promise((resolve, reject) => {
            canvas.toBlob((blob) => {
                blob ? resolve(blob) : reject(new Error('Foto gagal dikompresi.'));
            }, 'image/jpeg', quality);
        });
    }

    async function compressPhotoInBrowser(file) {
        if (file.size <= maxPhotoBytes) {
            return file;
        }

        const image = await loadPhoto(file);
        const sourceWidth = image.width;
        const sourceHeight = image.height;
        let scale = Math.min(1, 1920 / Math.max(sourceWidth, sourceHeight));
        let quality = 0.82;
        let blob;

        try {
            for (let attempt = 0; attempt < 10; attempt++) {
                const canvas = document.createElement('canvas');
                canvas.width = Math.max(1, Math.round(sourceWidth * scale));
                canvas.height = Math.max(1, Math.round(sourceHeight * scale));

                const context = canvas.getContext('2d');
                context.fillStyle = '#ffffff';
                context.fillRect(0, 0, canvas.width, canvas.height);
                context.drawImage(image, 0, 0, canvas.width, canvas.height);
                blob = await canvasToJpeg(canvas, quality);

                if (blob.size <= maxPhotoBytes) {
                    break;
                }

                if (quality > 0.58) {
                    quality -= 0.1;
                } else {
                    scale *= 0.8;
                    quality = 0.76;
                }
            }
        } finally {
            if (typeof image.close === 'function') {
                image.close();
            }
        }

        if (!blob || blob.size > maxPhotoBytes) {
            throw new Error('Foto tidak dapat dikecilkan hingga maksimal 2 MB.');
        }

        const baseName = file.name.replace(/\.[^.]+$/, '') || 'foto';

        return new File([blob], `${baseName}.jpg`, {
            type: 'image/jpeg',
            lastModified: Date.now(),
        });
    }

    reportPhotoInput.addEventListener('change', async function () {
        const selectedFiles = Array.from(reportPhotoInput.files);
        const currentToken = ++photoPreparationToken;

        if (selectedFiles.length === 0) {
            updatePhotoStatus();
            return;
        }

        setPhotoPreparationState(true);
        updatePhotoStatus('Menyiapkan foto agar proses simpan lebih cepat...', 'info');

        try {
            const preparedFiles = [];

            for (const file of selectedFiles) {
                preparedFiles.push(await compressPhotoInBrowser(file));
            }

            if (currentToken !== photoPreparationToken) {
                return;
            }

            const transfer = new DataTransfer();
            preparedFiles.forEach((file) => transfer.items.add(file));
            reportPhotoInput.files = transfer.files;
            updatePhotoStatus(`${preparedFiles.length} foto siap dikirim.`, 'success');
        } catch (error) {
            if (currentToken === photoPreparationToken) {
                updatePhotoStatus('Foto akan diproses kembali saat laporan disimpan.', 'error');
            }
        } finally {
            if (currentToken === photoPreparationToken) {
                setPhotoPreparationState(false);
            }
        }
    });

    createReportForm.addEventListener('submit', function (event) {
        if (photosArePreparing) {
            event.preventDefault();
            updatePhotoStatus('Tunggu sebentar, foto masih disiapkan.', 'info');
        }
    });

    function openPhotoModal(src) {
        photoModalImage.src = src;
        photoModal.classList.remove('hidden');
        photoModal.classList.add('flex');
    }

    function closePhotoModal() {
        photoModal.classList.add('hidden');
        photoModal.classList.remove('flex');
        photoModalImage.src = '';
    }

    photoModal.addEventListener('click', function (event) {
        if (event.target === photoModal) {
            closePhotoModal();
        }
    });

    createReportModal.addEventListener('click', function (event) {
        if (event.target === createReportModal) {
            closeCreateReportModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            if (!photoModal.classList.contains('hidden')) {
                closePhotoModal();
            }

            if (!createReportModal.classList.contains('hidden')) {
                closeCreateReportModal();
            }
        }
    });

    @if ($errors->has('id_kegiatan') || $errors->has('bentuk_gratifikasi') || $errors->has('tanggal_kegiatan'))
        openCreateReportModal(2);
    @elseif ($errors->has('fotos') || $errors->has('fotos.*') || $errors->has('keterangan'))
        openCreateReportModal(3);
    @elseif ($errors->any())
        openCreateReportModal(1);
    @endif
</script>
@endsection
