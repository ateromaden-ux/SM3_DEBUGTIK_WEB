{{--
    Tab: Kelola Materi Belajar
    Variabel: $materiList, $metrics, $guru
--}}
<div id="view-kelola-materi" class="view-section hidden">
    <div class="flex flex-col w-full gap-space-lg">

        {{-- ── Kartu Metrik ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md">
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-space-sm">
                    <span class="font-label-badge text-label-badge uppercase text-outline">Modul</span>
                    <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">menu_book</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-space-2xs">
                    <span class="font-headline-xl text-headline-xl font-bold text-on-surface">{{ $metrics['total_modul'] ?? 0 }}</span>
                    <span class="font-body-sm text-body-sm text-tertiary font-semibold">Aktif</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-space-sm">
                    <span class="font-label-badge text-label-badge uppercase text-outline">Kuis</span>
                    <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined text-[18px]">quiz</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-space-2xs">
                    <span class="font-headline-xl text-headline-xl font-bold text-on-surface">{{ $metrics['total_kuis'] ?? 0 }}</span>
                    <span class="font-body-sm text-body-sm text-tertiary font-semibold">Soal</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-space-sm">
                    <span class="font-label-badge text-label-badge uppercase text-outline">Lab</span>
                    <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-tertiary">
                        <span class="material-symbols-outlined text-[18px]">terminal</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-space-2xs">
                    <span class="font-headline-xl text-headline-xl font-bold text-on-surface">{{ $metrics['total_lab'] ?? 0 }}</span>
                    <span class="font-body-sm text-body-sm text-tertiary font-semibold">Aktif</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-space-sm">
                    <span class="font-label-badge text-label-badge uppercase text-outline">Siswa</span>
                    <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">people</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-space-2xs">
                    <span class="font-headline-xl text-headline-xl font-bold text-on-surface">{{ $metrics['siswa_online'] ?? 0 }}</span>
                    <span class="font-body-sm text-body-sm text-tertiary font-semibold">Online</span>
                </div>
            </div>
        </div>

        {{-- ── Daftar Materi ── --}}
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-space-lg py-space-md border-b border-outline-variant/20">
                <h2 class="font-headline-md text-headline-md font-bold text-on-surface">Daftar Materi Belajar</h2>
                <button
                    onclick="toggleModal(true)"
                    class="flex items-center gap-space-xs px-space-md py-space-sm rounded-xl bg-primary hover:opacity-90 text-on-primary font-body-sm text-body-sm font-semibold shadow-sm transition-all active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    Tambah Materi
                </button>
            </div>

            {{-- List --}}
            <div class="divide-y divide-outline-variant/10">
                @forelse($materiList as $materi)
                @php
                    $waktu       = ($materi->estimasi_waktu == 0) ? 'Tak Terbatas' : $materi->estimasi_waktu . ' menit';
                    $jumlahSoal  = $materi->kuis->count();
                    $jumlahLab   = $materi->labPraktik->count();
                    $isPublished = $materi->kuisSettings?->isPublished();
                    $icons       = ['code','storage','terminal','dataset','menu_book'];
                    $colors      = ['primary','secondary','tertiary'];
                    $icon        = $icons[$loop->index % 5];
                    $color       = $colors[$loop->index % 3];
                @endphp
                <div class="group flex items-center gap-space-md px-space-lg py-space-md hover:bg-surface-container-low transition-colors">

                    {{-- Ikon --}}
                    <div class="w-12 h-12 rounded-2xl bg-{{ $color }}/10 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-{{ $color }} text-[22px]">{{ $icon }}</span>
                    </div>

                    {{-- Info utama --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-space-xs flex-wrap mb-space-2xs">
                            <span class="px-space-xs py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-badge text-label-badge uppercase">{{ $materi->level }}</span>
                            <span class="px-space-xs py-0.5 rounded-full bg-primary/10 text-primary font-label-badge text-label-badge">{{ $materi->kategori }}</span>
                            @if($isPublished)
                            <span class="flex items-center gap-1 px-space-xs py-0.5 rounded-full bg-tertiary/10">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                <span class="font-label-badge text-label-badge text-tertiary font-bold">Published</span>
                            </span>
                            @endif
                        </div>
                        <h3 class="font-title-sm text-title-sm font-semibold text-on-surface line-clamp-1">{{ $materi->judul }}</h3>
                        @if($materi->deskripsi)
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs line-clamp-1">{{ $materi->deskripsi }}</p>
                        @endif
                        <div class="flex items-center gap-space-md mt-space-xs">
                            <span class="flex items-center gap-space-2xs text-on-surface-variant">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                <span class="font-label-badge text-label-badge">{{ $waktu }}</span>
                            </span>
                            <span class="flex items-center gap-space-2xs {{ $jumlahSoal > 0 ? 'text-secondary' : 'text-outline' }}">
                                <span class="material-symbols-outlined text-[14px]">quiz</span>
                                <span class="font-label-badge text-label-badge">{{ $jumlahSoal }} soal</span>
                            </span>
                            <span class="flex items-center gap-space-2xs {{ $jumlahLab > 0 ? 'text-tertiary' : 'text-outline' }}">
                                <span class="material-symbols-outlined text-[14px]">terminal</span>
                                <span class="font-label-badge text-label-badge">{{ $jumlahLab }} lab</span>
                            </span>
                        </div>
                    </div>

                    {{-- Tombol aksi --}}
                    <div class="flex items-center gap-space-xs flex-shrink-0">
                        {{-- Edit materi --}}
                        <button
                            type="button"
                            title="Edit materi"
                            onclick="openEditorModal(
                                '{{ $materi->id }}',
                                '{{ addslashes($materi->id_materi) }}',
                                '{{ addslashes($materi->judul) }}',
                                '{{ $materi->kategori }}',
                                '{{ $materi->level }}',
                                {{ $materi->estimasi_waktu }},
                                '{{ addslashes($materi->deskripsi ?? '') }}'
                            )"
                            class="w-9 h-9 rounded-xl bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </button>
                        {{-- Kelola soal kuis --}}
                        <a
                            href="{{ route('kuis.page', $materi->id) }}"
                            title="Kelola soal kuis"
                            class="w-9 h-9 rounded-xl bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-secondary/10 hover:text-secondary transition-colors">
                            <span class="material-symbols-outlined text-[18px]">quiz</span>
                        </a>
                        {{-- Hapus --}}
                        <button
                            type="button"
                            title="Hapus materi"
                            onclick="deleteMateri('{{ $materi->id }}')"
                            class="w-9 h-9 rounded-xl bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>

                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-16 gap-space-md text-center px-space-lg">
                    <div class="w-16 h-16 rounded-2xl bg-surface-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-outline text-[32px]">menu_book</span>
                    </div>
                    <div>
                        <p class="font-title-sm text-title-sm font-semibold text-on-surface">Belum ada materi</p>
                        <p class="font-body-sm text-body-sm text-outline mt-space-2xs">Buat materi pertama untuk mulai mengelola soal kuis.</p>
                    </div>
                    <button
                        onclick="toggleModal(true)"
                        class="flex items-center gap-space-xs px-space-lg py-space-sm rounded-xl bg-primary text-on-primary font-body-sm text-body-sm font-semibold hover:opacity-90 shadow-sm transition-all active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        Tambah Materi Pertama
                    </button>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
