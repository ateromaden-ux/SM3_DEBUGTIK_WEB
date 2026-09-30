{{--
    Panel Kiri — Daftar Soal + footer total poin.
    Variabel: $settings, $soalList
--}}

{{-- Header daftar soal --}}
<div class="flex items-center justify-between px-space-md py-space-sm border-b border-outline-variant/20 flex-shrink-0">
    <span class="font-title-sm text-title-sm font-bold text-on-surface">Daftar Soal</span>
    <button onclick="newSoal()"
        id="btn-soal-baru"
        class="flex items-center gap-space-2xs px-space-sm py-space-2xs rounded-lg bg-secondary text-on-secondary font-body-sm text-body-sm font-semibold hover:opacity-90 transition-opacity {{ (!$settings || $settings->isPublished()) ? 'opacity-50 cursor-not-allowed' : '' }}"
        {{ (!$settings || $settings->isPublished()) ? 'disabled' : '' }}
        title="{{ !$settings ? 'Atur pengaturan kuis dulu' : ($settings->isPublished() ? 'Tarik ke Draft untuk menambah soal' : '') }}">
        <span class="material-symbols-outlined text-[16px]">add</span>
        Soal Baru
    </button>
</div>

{{-- List soal --}}
<div class="flex-1 overflow-y-auto p-space-sm flex flex-col gap-space-xs" id="soal-list">
    @if(!$settings)
        <div class="flex flex-col items-center justify-center py-10 gap-space-sm text-center px-space-md">
            <span class="material-symbols-outlined text-outline text-[32px]">settings</span>
            <span class="font-body-sm text-body-sm text-outline">Isi pengaturan kuis di atas terlebih dahulu sebelum menambah soal.</span>
        </div>
    @else
        @forelse($soalList as $soal)
            @php
                $tipeBadgeColor = match($soal->tipe) {
                    'multiple_answer' => 'bg-secondary/10 text-secondary',
                    'essay'           => 'bg-tertiary/10 text-tertiary',
                    default           => 'bg-primary/10 text-primary',
                };
                $tipeLabel = match($soal->tipe) {
                    'multiple_answer' => 'Multi',
                    'essay'           => 'Essay',
                    default           => 'PG',
                };
            @endphp
            <div class="soal-item rounded-xl p-space-sm bg-surface-container-low hover:bg-surface-container cursor-pointer transition-colors border-2 border-transparent"
                 data-id="{{ $soal->id }}"
                 onclick="loadSoalToForm({{ $soal->id }})">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-center gap-space-xs flex-shrink-0">
                        <span class="w-6 h-6 rounded-md bg-surface-container-high flex items-center justify-center font-code-inline text-code-inline font-bold text-on-surface-variant">{{ $loop->iteration }}</span>
                        <span class="px-1.5 py-0.5 rounded-md {{ $tipeBadgeColor }} font-label-badge text-label-badge font-bold">{{ $tipeLabel }}</span>
                    </div>
                    <button onclick="event.stopPropagation(); deleteSoal({{ $soal->id }}, this)"
                        class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors flex-shrink-0">
                        <span class="material-symbols-outlined text-[14px]">delete</span>
                    </button>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface mt-space-xs line-clamp-2">{{ $soal->pertanyaan }}</p>
                <div class="flex items-center justify-between mt-space-xs">
                    <span class="font-code-inline text-code-inline text-outline">{{ $soal->id_soal }}</span>
                    <span class="font-label-badge text-label-badge text-on-surface-variant">{{ $soal->poin }} poin</span>
                </div>
            </div>
        @empty
            <div id="empty-state" class="flex flex-col items-center justify-center py-12 gap-space-sm text-center">
                <span class="material-symbols-outlined text-outline text-[40px]">quiz</span>
                <span class="font-body-sm text-body-sm text-outline">Belum ada soal.<br>Klik "Soal Baru" untuk mulai.</span>
            </div>
        @endforelse
    @endif
</div>

{{-- Footer: total poin --}}
<div class="flex-shrink-0 px-space-md py-space-sm border-t border-outline-variant/20 bg-surface-container-low">
    <div class="flex items-center justify-between">
        <span class="font-body-sm text-body-sm text-on-surface-variant">Total poin</span>
        <span class="font-code-inline text-code-inline font-bold text-on-surface" id="total-poin">{{ $soalList->sum('poin') }}</span>
    </div>
    <div id="kkm-row" class="flex items-center justify-between mt-space-2xs {{ $settings ? '' : 'hidden' }}">
        <span class="font-body-sm text-body-sm text-on-surface-variant" id="kkm-label">
            Lulus jika ≥ KKM {{ $settings?->kkm ?? 70 }}%
        </span>
        <span class="font-code-inline text-code-inline text-secondary font-bold" id="poin-kkm">
            ≥ {{ $settings ? round($soalList->sum('poin') * $settings->kkm / 100) : 0 }} poin
        </span>
    </div>
</div>
