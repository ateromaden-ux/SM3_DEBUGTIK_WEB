<!-- Manage Materials Section -->
<div class="xl:col-span-5">
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-surface-container-low px-space-lg py-space-md flex items-center justify-between border-b border-outline-variant/20">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[24px]">menu_book</span>
                <h2 class="font-headline-md text-headline-md font-bold text-on-surface">Kelola Materi</h2>
            </div>
            <button class="text-secondary font-body-sm text-body-sm font-semibold hover:underline">Tambah Materi</button>
        </div>

        <!-- Materials List -->
        <div class="p-space-md space-y-space-sm">
            @foreach($materiList as $materi)
                <div class="bg-surface-container-low rounded-xl p-space-md hover:bg-surface-container transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3 flex-1">
                            <div class="w-10 h-10 rounded-lg bg-{{ ['primary', 'secondary', 'tertiary'][($loop->index) % 3] }}/10 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-{{ ['primary', 'secondary', 'tertiary'][($loop->index) % 3] }} text-[20px]">
                                    {{ ['code', 'storage', 'terminal', 'dataset'][($loop->index) % 4] }}
                                </span>
                            </div>
                            <div class="flex flex-col flex-1 min-w-0">
                                <span class="font-body-md text-body-md font-semibold text-on-surface">{{ $materi->judul }}</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">{{ $materi->deskripsi }}</span>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="font-code-inline text-code-inline text-on-surface-variant">{{ $materi->tipe_materi }}</span>
                                    <span class="text-on-surface-variant">•</span>
                                    <span class="font-code-inline text-code-inline text-on-surface-variant">{{ $materi->durasi_menit }} menit</span>
                                </div>
                            </div>
                        </div>
                        <button class="material-symbols-outlined text-on-surface-variant text-[20px] hover:text-on-surface ml-2">
                            more_vert
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
