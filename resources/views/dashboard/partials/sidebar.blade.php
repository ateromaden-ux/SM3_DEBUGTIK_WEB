{{--
    Sidebar navigasi utama — Dashboard Guru.
    Variabel yang dibutuhkan: $guru, $materiList, $kuisList
--}}
<aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest z-50 flex flex-col shadow-[0_1px_8px_rgba(0,0,0,0.04)]">

    {{-- Logo --}}
    <div class="h-16 px-space-lg flex items-center">
        <div class="flex flex-col leading-none ml-space-xs">
            <span class="font-headline-md text-headline-md font-bold tracking-tight text-on-surface">Debug<span class="text-primary">TIK</span></span>
            <span class="font-label-badge text-label-badge text-outline tracking-wider uppercase mt-space-2xs">Portal Guru</span>
        </div>
    </div>

    {{-- Navigasi --}}
    <nav class="flex flex-col gap-space-2xs px-space-md mt-space-sm">
        <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
           href="#" data-tab="dashboard"
           aria-label="Navigasi ke Dasbor Utama">
            <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
            <span class="font-body-md text-body-md">Dasbor Utama</span>
        </a>

        <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
           href="#" data-tab="kelola-materi"
           aria-label="Navigasi ke Kelola Materi Belajar">
            <span class="material-symbols-outlined text-[20px]">library_books</span>
            <span class="font-body-md text-body-md">Kelola Materi Belajar</span>
        </a>

        {{-- Kelola Kuis (Dropdown) --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                    aria-label="Buka/tutup daftar kuis"
                    aria-expanded="open"
                    class="w-full flex items-center justify-between gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-[20px]">quiz</span>
                    <span class="font-body-md text-body-md">Kelola Kuis</span>
                </div>
                <div class="flex items-center gap-space-xs">
                    <span class="font-label-badge text-label-badge bg-primary/10 text-primary px-2 py-0.5 rounded-lg">{{ $kuisList->count() }}</span>
                    <span class="material-symbols-outlined text-[16px] transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </div>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="mt-space-2xs ml-space-lg flex flex-col gap-space-3xs"
                 @click.away="open = false">
                
                {{-- Link ke halaman kelola kuis --}}
                <a href="{{ route('kelola-kuis') }}"
                   class="flex items-center gap-space-xs px-space-sm py-space-xs rounded-lg text-primary hover:bg-primary/5 transition-colors font-semibold">
                    <span class="material-symbols-outlined text-[14px]">list</span>
                    <span class="font-body-sm text-body-sm">Lihat Semua Kuis</span>
                </a>

                <div class="h-px bg-outline/20 my-space-3xs"></div>

                {{-- List kuis --}}
                <div class="max-h-64 overflow-y-auto flex flex-col gap-space-3xs">
                    @forelse($kuisList as $kuis)
                        <a href="{{ route('kuis.page', $kuis->id) }}"
                           class="flex items-start gap-space-xs px-space-sm py-space-xs rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group">
                            <span class="material-symbols-outlined text-[14px] mt-0.5 text-primary/60 group-hover:text-primary">arrow_right</span>
                            <div class="flex-1 min-w-0">
                                <p class="font-body-sm text-body-sm line-clamp-1">{{ $kuis->nama_kuis }}</p>
                                @if($kuis->materi)
                                    <p class="font-label-badge text-label-badge text-outline line-clamp-1">{{ $kuis->materi->judul }}</p>
                                @endif
                            </div>
                            <span class="font-label-badge text-label-badge px-1.5 py-0.5 rounded {{ $kuis->status === 'published' ? 'bg-tertiary/10 text-tertiary' : 'bg-outline/10 text-outline' }}">
                                {{ $kuis->status === 'published' ? 'Live' : 'Draft' }}
                            </span>
                        </a>
                    @empty
                        <div class="px-space-sm py-space-xs text-outline font-body-sm text-body-sm italic">
                            Belum ada kuis
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
           href="#" data-tab="rekap"
           aria-label="Navigasi ke Rekap Nilai">
            <span class="material-symbols-outlined text-[20px]">assessment</span>
            <span class="font-body-md text-body-md">Rekap Nilai</span>
        </a>

        <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
           href="#" data-tab="pengaturan"
           aria-label="Navigasi ke Pengaturan">
            <span class="material-symbols-outlined text-[20px]">settings</span>
            <span class="font-body-md text-body-md">Pengaturan</span>
        </a>
    </nav>
</aside>