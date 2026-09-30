<aside class="fixed left-0 top-0 h-full w-64 bg-surface-container-lowest z-50 flex flex-col shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <!-- Logo Section -->
    <div class="h-16 px-space-md flex items-center gap-space-xs bg-surface-container-lowest">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-lg text-white">terminal</span>
            </div>
            <div class="flex flex-col">
                <span class="font-headline-md text-headline-md font-bold tracking-tight text-primary leading-none">DebugTIK</span>
                <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface-variant">Portal Pengajar</span>
            </div>
        </div>
    </div>

    <!-- Schema Info Badge -->
    <div class="px-space-md py-space-xs">
        <div class="bg-surface-container-low rounded-xl px-space-sm py-space-xs flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-body-sm text-body-sm text-on-surface-variant">Sistem Skema</span>
                <span class="font-title-sm text-title-sm font-semibold text-primary">ERD Kelompok 5</span>
            </div>
            <span class="font-code-inline text-code-inline text-tertiary font-bold bg-surface-container-lowest px-2 py-0.5 rounded-lg">v2.4</span>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-space-sm py-space-xs flex flex-col gap-1">
        <a href="{{ route('dashboard') }}" 
           data-path="dasbor-guru"
           class="flex items-center gap-3 px-space-sm py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-primary-container text-on-primary-container font-semibold shadow-sm' : 'text-on-surface-variant font-body-md text-body-md hover:bg-surface-container hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
            Dasbor Guru
        </a>
        <a href="#" 
           data-path="kelola-materi"
           class="flex items-center gap-3 px-space-sm py-2.5 rounded-xl text-on-surface-variant font-body-md text-body-md hover:bg-surface-container hover:text-on-surface transition-all">
            <span class="material-symbols-outlined text-[20px]">menu_book</span>
            Kelola Materi
        </a>
        <a href="#" 
           data-path="penugasan-dan-progres-siswa"
           class="flex items-center gap-3 px-space-sm py-2.5 rounded-xl text-on-surface-variant font-body-md text-body-md hover:bg-surface-container hover:text-on-surface transition-all">
            <span class="material-symbols-outlined text-[20px]">assignment_ind</span>
            Penugasan & Progres Siswa
        </a>
        <a href="{{ route('rekap-nilai') }}" 
           data-path="rekap-nilai-dan-evaluasi"
           class="flex items-center gap-3 px-space-sm py-2.5 rounded-xl transition-all {{ request()->routeIs('rekap-nilai') ? 'bg-primary-container text-on-primary-container font-semibold shadow-sm' : 'text-on-surface-variant font-body-md text-body-md hover:bg-surface-container hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[20px]">analytics</span>
            Rekap Nilai & Evaluasi
        </a>
    </nav>

    <!-- User Profile Section -->
    <div class="p-space-md mt-auto bg-surface-container-lowest">
        <div class="bg-surface-container-low rounded-xl p-space-sm flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-semibold text-sm">
                {{ substr(Auth::guard('guru')->user()->name ?? Auth::user()->name ?? 'G', 0, 1) }}
            </div>
            <div class="flex flex-col min-w-0 flex-1">
                <span class="font-body-md text-body-md font-semibold text-on-surface truncate">{{ Auth::guard('guru')->user()->name ?? Auth::user()->name ?? 'Guru' }}</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Guru Pengampu TIK</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="material-symbols-outlined text-on-surface-variant text-[18px] cursor-pointer hover:text-on-surface">
                    logout
                </button>
            </form>
        </div>
    </div>
</aside>
