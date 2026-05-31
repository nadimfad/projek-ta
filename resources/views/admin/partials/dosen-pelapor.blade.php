<div class="space-y-4">
    @forelse ($dosenPelapor as $index => $dosen)
        <div class="flex items-center gap-4 rounded-xl bg-gray-50 p-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-sm font-bold text-white">
                {{ $dosenPelapor->firstItem() + $index }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate font-semibold text-gray-700">{{ $dosen->nama }}</p>
                <p class="truncate text-xs text-gray-400">{{ $dosen->email }}</p>
            </div>
            <span class="rounded-lg bg-blue-50 px-3 py-1 text-sm font-bold text-blue-700">
                {{ $dosen->laporans_count }}
            </span>
        </div>
    @empty
        <div class="rounded-xl bg-gray-50 p-6 text-center text-sm text-gray-400">
            Belum ada data dosen.
        </div>
    @endforelse
</div>

@if ($dosenPelapor->hasPages())
    <div class="mt-5 flex flex-col gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-xs font-medium text-gray-400">
            {{ $dosenPelapor->firstItem() }}-{{ $dosenPelapor->lastItem() }} dari {{ $dosenPelapor->total() }} dosen
        </p>

        <div class="flex items-center gap-2">
            @if ($dosenPelapor->onFirstPage())
                <span class="rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-400">
                    Prev
                </span>
            @else
                <a href="{{ route('dashboard.dosen-pelapor', ['dosen_page' => $dosenPelapor->currentPage() - 1]) }}" data-dosen-page class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                    Prev
                </a>
            @endif

            <span class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-bold text-white">
                {{ $dosenPelapor->currentPage() }} / {{ $dosenPelapor->lastPage() }}
            </span>

            @if ($dosenPelapor->hasMorePages())
                <a href="{{ route('dashboard.dosen-pelapor', ['dosen_page' => $dosenPelapor->currentPage() + 1]) }}" data-dosen-page class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-600 hover:text-white">
                    Next
                </a>
            @else
                <span class="rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-400">
                    Next
                </span>
            @endif
        </div>
    </div>
@endif
