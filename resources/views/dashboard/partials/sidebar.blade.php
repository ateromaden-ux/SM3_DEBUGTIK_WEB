{{--
    Sidebar navigasi utama — Dashboard Guru.
    Variabel yang dibutuhkan: $guru, $materiList
--}}
<aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="flex flex-col">

        {{-- Logo --}}
        <div class="h-16 px-space-lg flex items-center gap-space-xs bg-surface-container-lowest">
            <div class="flex flex-col leading-none ml-space-xs">
                <span class="font-headline-md text-headline-md font-bold tracking-tight text-on-surface">Debug<span class="text-primary">TIK</span></span>
                <span class="font-label-badge text-label-badge text-outline tracking-wider uppercase mt-space-2xs">Portal Guru</span>
            </div>
        </div>

        {{-- Kurikulum badge --}}
        <div class="px-space-md py-space-sm">
            <div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col gap-space-2xs">
                <div class="flex items-center justify-between">
                    <span class="font-label-badge text-label-badge uppercase text-primary font-semibold">Kurikulum Merdeka</span>
                    <span class="h-2 w-2 rounded-full bg-tertiary"></span>
                </div>
                <span class="font-body-sm text-body-sm font-medium text-on-surface">Fase E & F (Kelas X - XI)</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">
                    Semester {{ $guru->semester ?? 'Ganjil' }} {{ $guru->tahun_ajaran ?? '2024/2025' }}
                </span>
            </div>
        </div>

        {{-- Navigasi --}}
        <nav class="flex flex-col gap-space-2xs px-space-md mt-space-xs">
            <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
               href="#" data-tab="dashboard">
                <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
                <span class="font-body-md text-body-md">Dasbor Utama</span>
            </a>

            <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
               href="#" data-tab="kelola-materi">
                <span class="material-symbols-outlined text-[20px]">library_books</span>
                <span class="font-body-md text-body-md">Kelola Materi Belajar</span>
            </a>

            {{-- Kelola Kuis — dropdown per materi --}}
            <div>
                <button onclick="toggleKuisDropdown()"
                    class="w-full flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
                    id="btn-kuis-dropdown">
                    <span class="material-symbols-outlined text-[20px]">quiz</span>
                    <span class="font-body-md text-body-md flex-1 text-left">Kelola Kuis</span>
                    <span class="material-symbols-outlined text-[18px] transition-transform duration-200" id="kuis-nav-chevron">expand_more</span>
                </button>
                <div id="kuis-nav-dropdown" class="hidden flex-col gap-space-2xs mt-space-2xs pl-space-md">
                    @forelse($materiList as $m)
                    <a href="{{ route('kuis.page', $m->id) }}"
                       class="flex items-center gap-space-xs px-space-sm py-space-xs rounded-lg text-on-surface-variant hover:bg-secondary/10 hover:text-secondary transition-colors">
                        <span class="material-symbols-outlined text-[14px] flex-shrink-0">quiz</span>
                        <span class="font-body-sm text-body-sm truncate flex-1">{{ $m->judul }}</span>
                        <div class="flex items-center gap-space-2xs flex-shrink-0">
                            <span class="font-label-badge text-label-badge text-outline">{{ $m->kuis->count() }}</span>
                            @if($m->kuisSettings?->isPublished())
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <span class="px-space-sm py-space-xs font-body-sm text-body-sm text-outline italic">Belum ada materi</span>
                    @endforelse
                </div>
            </div>

            <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
               href="#" data-tab="rekap">
                <span class="material-symbols-outlined text-[20px]">assessment</span>
                <span class="font-body-md text-body-md">Rekap Nilai & Evaluasi</span>
            </a>

            <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
               href="#" data-tab="pengaturan">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                <span class="font-body-md text-body-md">Pengaturan</span>
            </a>
        </nav>
    </div>

    {{-- Footer sidebar --}}
    <div class="p-space-md">
        <div class="p-space-sm rounded-xl bg-surface-container flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-badge text-label-badge text-outline">Compiler Engine</span>
                <span class="font-code-inline text-code-inline text-on-surface font-semibold">V8 Node 20.x Online</span>
            </div>
            <span class="material-symbols-outlined text-tertiary text-[18px]">check_circle</span>
        </div>
    </div>
</aside>
