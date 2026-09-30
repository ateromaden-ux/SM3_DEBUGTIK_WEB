{{--
    Header bar atas — Dashboard Guru.
    Variabel yang dibutuhkan: $guru
--}}
<header class="fixed top-0 left-72 right-0 h-16 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-40 px-space-lg flex items-center justify-between">

    {{-- Search bar --}}
    <div class="flex items-center gap-space-md flex-1 max-w-xl">
        <div class="relative w-full">
            <span class="material-symbols-outlined absolute left-space-sm top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
            <input class="w-full h-10 pl-10 pr-space-md rounded-xl bg-surface-container-low text-on-surface placeholder:text-outline font-body-sm text-body-sm focus:outline-none focus:bg-surface-container-lowest shadow-[0_1px_8px_rgba(0,0,0,0.04)] transition-all"
                   placeholder="Cari modul, sesi lab kode, atau nama siswa..."
                   type="text"/>
        </div>
    </div>

    {{-- Kanan: info kurikulum + notif + profil --}}
    <div class="flex items-center gap-space-md">
        <div class="hidden lg:flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-surface-container">
            <span class="material-symbols-outlined text-primary text-[16px]">school</span>
            <span class="font-label-badge text-label-badge text-on-surface font-medium">Kurikulum Merdeka 2024</span>
            <span class="text-outline text-label-badge">•</span>
            <span class="font-label-badge text-label-badge text-primary font-bold">Sem. Ganjil</span>
        </div>

        <button class="relative w-10 h-10 rounded-xl bg-surface-container-low hover:bg-surface-container hover:text-on-surface text-on-surface-variant flex items-center justify-center transition-colors"
                type="button">
            <span class="material-symbols-outlined text-[20px]">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-error"></span>
        </button>

        {{-- Profil guru --}}
        <div class="flex items-center gap-space-sm pl-space-2xs">
            <div class="flex flex-col text-right leading-none">
                <span class="font-title-sm text-title-sm text-on-surface font-semibold" id="display-name">{{ $guru->name ?? 'Guru' }}</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">{{ $guru->mata_pelajaran ?? 'Guru TIK' }}</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center overflow-hidden">
                @if($guru->foto_profil)
                    <img src="{{ Storage::disk('public')->url($guru->foto_profil) }}" class="w-full h-full object-cover"/>
                @else
                    <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                @endif
            </div>
        </div>
    </div>
</header>
