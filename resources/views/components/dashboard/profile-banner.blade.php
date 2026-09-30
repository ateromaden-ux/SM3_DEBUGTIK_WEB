<!-- Profile Banner Section -->
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary to-secondary p-space-lg mb-space-lg shadow-lg">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS13aWR0aD0iMSIgb3BhY2l0eT0iMC4xIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-40"></div>
    
    <div class="relative flex items-center justify-between">
        <div class="flex items-center gap-space-md">
            <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                <span class="material-symbols-outlined text-[32px] text-white">school</span>
            </div>
            <div class="flex flex-col">
                <span class="font-headline-lg text-headline-lg font-bold text-white">Selamat Datang, {{ $guru->name }}</span>
                <span class="font-body-md text-body-md text-white/80 mt-1">{{ $guru->email }} • Lab Komputer TIK RPL</span>
            </div>
        </div>
        
        <div class="hidden lg:flex items-center gap-space-sm">
            <div class="bg-white/20 backdrop-blur-sm rounded-xl px-space-md py-space-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-white text-[20px]">event</span>
                    <span class="font-body-sm text-body-sm text-white font-medium">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
