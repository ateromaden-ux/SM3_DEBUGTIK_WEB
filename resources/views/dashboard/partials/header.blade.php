{{--
    Header bar atas — Dashboard Guru.
    Variabel yang dibutuhkan: $guru
--}}
<header class="fixed top-0 left-72 right-0 h-16 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-40 px-space-lg flex items-center justify-between">

    {{-- Search bar dihapus --}}
    <div class="flex items-center gap-space-md flex-1 max-w-xl">
    </div>

    {{-- Kanan: profil --}}
    <a href="#" data-tab="pengaturan" class="flex items-center gap-space-md ml-auto cursor-pointer">
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
    </a>
</header>
