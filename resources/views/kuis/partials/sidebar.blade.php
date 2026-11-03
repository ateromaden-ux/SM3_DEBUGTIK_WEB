{{--
    Sidebar navigasi — halaman Kelola Soal Kuis.
    Variabel: $settings, $guru, $judulKuis
--}}
<aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="flex flex-col">

        {{-- Logo --}}
        <div class="h-16 px-space-lg flex items-center gap-space-xs">
            <div class="flex flex-col leading-none ml-space-xs">
                <span class="font-headline-md text-headline-md font-bold tracking-tight text-on-surface">Debug<span class="text-primary">TIK</span></span>
                <span class="font-label-badge text-label-badge text-outline tracking-wider uppercase mt-space-2xs">Portal Guru</span>
            </div>
        </div>

        {{-- Breadcrumb konteks kuis --}}
        <div class="px-space-md mt-space-xs">
            <a href="{{ route('kelola-kuis') }}"
               class="flex items-center gap-space-xs text-on-surface-variant hover:text-primary hover:translate-x-1 transition-transform duration-150 font-body-sm text-body-sm mb-space-xs">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Kembali ke Kelola Kuis
            </a>
            <div class="p-space-sm rounded-xl border border-secondary/30 bg-secondary/5 flex flex-col gap-space-2xs">
                <div class="flex items-center gap-space-xs">
                    <span class="material-symbols-outlined text-secondary text-[16px]">quiz</span>
                    <span class="font-label-badge text-label-badge uppercase text-secondary font-semibold">Soal Kuis</span>
                </div>
                <span class="font-body-sm text-body-sm font-semibold text-on-surface line-clamp-2">{{ $judulKuis }}</span>
                <div class="flex items-center gap-space-xs mt-space-2xs">
                    <span class="font-code-inline text-code-inline text-outline font-label-badge text-label-badge">{{ $settings->id_kuis }}</span>
                    @if($settings->isPublished())
                        <span class="px-2 py-0.5 rounded-full bg-tertiary/10 text-tertiary font-label-badge text-label-badge font-bold">Published</span>
                    @else
                        <span class="px-2 py-0.5 rounded-full bg-outline/10 text-outline font-label-badge text-label-badge">Draft</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Navigasi --}}
        <nav class="flex flex-col gap-space-2xs px-space-md mt-space-md">
            <a href="{{ url('/dashboard?tab=dashboard') }}"
               class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface hover:translate-x-1 transition-transform duration-150">
                <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
                <span class="font-body-md text-body-md">Dasbor Utama</span>
            </a>

            <a href="{{ url('/dashboard?tab=kelola-materi') }}"
               class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface hover:translate-x-1 transition-transform duration-150">
                <span class="material-symbols-outlined text-[20px]">library_books</span>
                <span class="font-body-md text-body-md">Kelola Materi Belajar</span>
            </a>

            {{-- Kelola Kuis — aktif di halaman ini --}}
            <a href="{{ route('kelola-kuis') }}"
               class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl bg-secondary/10 text-secondary font-semibold">
                <span class="material-symbols-outlined text-[20px]">quiz</span>
                <span class="font-body-md text-body-md">Kelola Kuis</span>
            </a>

            <a href="{{ url('/dashboard?tab=rekap') }}"
               class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface hover:translate-x-1 transition-transform duration-150">
                <span class="material-symbols-outlined text-[20px]">assessment</span>
                <span class="font-body-md text-body-md">Rekap Nilai & Evaluasi</span>
            </a>

            <a href="{{ url('/dashboard?tab=pengaturan') }}"
               class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface hover:translate-x-1 transition-transform duration-150">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                <span class="font-body-md text-body-md">Pengaturan</span>
            </a>
        </nav>
    </div>
</aside>
