<header class="fixed top-0 left-64 right-0 h-16 bg-surface-container-lowest/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-40 flex items-center justify-between px-space-lg">
    <!-- Left Section -->
    <div class="flex items-center gap-space-sm">
        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-container-low text-on-surface-variant">
            <span class="material-symbols-outlined text-[16px] text-primary">school</span>
            <span class="font-body-sm text-body-sm font-medium">Kelas TIK X & XI RPL</span>
        </div>
        <span class="font-code-inline text-code-inline text-on-surface-variant hidden md:inline-block">| TA 2024/2025</span>
    </div>

    <!-- Right Section: Search, Notifications, Profile -->
    <div class="flex items-center gap-space-sm">
        <!-- Search -->
        <div class="flex items-center bg-surface-container-low rounded-xl px-3 py-1.5 gap-2 transition-all hover:ring-2 hover:ring-primary">
            <span class="material-symbols-outlined text-outline text-[18px]">search</span>
            <input class="bg-transparent border-none outline-none font-body-sm text-body-sm text-on-surface placeholder:text-outline w-44 md:w-60"
                   placeholder="Cari siswa, materi, modul..."
                   type="search"
                   aria-label="Search">
        </div>

        <!-- Notifications -->
        <button type="button"
                aria-label="Notifications"
                class="w-9 h-9 rounded-xl bg-surface-container-low flex items-center justify-center text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all relative">
            <span class="material-symbols-outlined text-[20px]">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-error"></span>
        </button>

        <!-- User Profile -->
        <div class="flex items-center gap-2 pl-2">
            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-semibold text-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <span class="font-body-sm text-body-sm font-semibold text-on-surface hidden lg:inline-block">{{ Auth::user()->name }}</span>
        </div>
    </div>
</header>
