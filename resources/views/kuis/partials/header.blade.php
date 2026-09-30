{{--
    Header bar — halaman Kelola Soal Kuis.
    Variabel: $materi, $settings, $soalList, $guru
--}}
<header class="flex-shrink-0 h-16 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-40 px-space-lg flex items-center justify-between">

    {{-- Judul + badge status --}}
    <div class="flex items-center gap-space-sm">
        <span class="material-symbols-outlined text-secondary text-[22px]">quiz</span>
        <div class="flex flex-col leading-none">
            <span class="font-title-sm text-title-sm font-bold text-on-surface">Kelola Soal Kuis</span>
            <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $materi->judul }}</span>
        </div>

        {{-- Badge status: Published / Draft --}}
        @if($settings && $settings->isPublished())
            <div class="flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-tertiary/10 border border-tertiary/30" id="status-badge">
                <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                <span class="font-label-badge text-label-badge text-tertiary font-bold">PUBLISHED</span>
            </div>
        @else
            <div class="flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-outline/10 border border-outline/20" id="status-badge">
                <span class="w-2 h-2 rounded-full bg-outline"></span>
                <span class="font-label-badge text-label-badge text-outline font-bold">DRAFT</span>
            </div>
        @endif
    </div>

    {{-- Kanan: tombol publish + counter + profil --}}
    <div class="flex items-center gap-space-md">

        {{-- Tombol Publish / Unpublish --}}
        @if($settings && $settings->isPublished())
            <button onclick="unpublishKuis()"
                class="flex items-center gap-space-xs px-space-md py-space-xs rounded-xl border-2 border-error/40 text-error hover:bg-error-container font-body-sm text-body-sm font-semibold transition-all"
                id="btn-publish">
                <span class="material-symbols-outlined text-[16px]">unpublished</span>
                Tarik ke Draft
            </button>
        @else
            <button onclick="publishKuis()"
                class="flex items-center gap-space-xs px-space-md py-space-xs rounded-xl bg-tertiary text-on-tertiary font-body-sm text-body-sm font-semibold hover:opacity-90 transition-opacity shadow-sm"
                id="btn-publish"
                {{ !$settings ? 'disabled title=Isi pengaturan kuis dulu' : '' }}>
                <span class="material-symbols-outlined text-[16px]">publish</span>
                Publish Kuis
            </button>
        @endif

        <span id="soal-counter" class="px-space-sm py-space-2xs rounded-full bg-secondary/10 text-secondary font-label-badge text-label-badge font-semibold">
            {{ $soalList->count() }} soal
        </span>

        {{-- Profil guru --}}
        <div class="flex items-center gap-space-sm pl-space-xs border-l border-outline-variant/30">
            <div class="flex flex-col text-right leading-none">
                <span class="font-title-sm text-title-sm text-on-surface font-semibold">{{ $guru->name ?? 'Guru' }}</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $guru->mata_pelajaran ?? 'Guru TIK' }}</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
            </div>
        </div>
    </div>
</header>
