{{--
    Panel Kiri — Bagian Pengaturan Kuis.
    Variabel: $materi, $settings
--}}
<div class="flex-shrink-0 border-b border-outline-variant/20">

    {{-- Toggle header --}}
    <button onclick="toggleSettings()"
        class="w-full flex items-center justify-between px-space-md py-space-sm hover:bg-surface-container-low transition-colors"
        id="btn-settings-toggle">
        <div class="flex items-center gap-space-xs">
            <span class="material-symbols-outlined text-secondary text-[18px]">settings</span>
            <span class="font-title-sm text-title-sm font-semibold text-on-surface">Pengaturan Kuis</span>
        </div>
        <div class="flex items-center gap-space-xs">
            @if($settings && $settings->isPublished())
                <span class="px-2 py-0.5 rounded-full bg-tertiary/10 text-tertiary font-label-badge text-label-badge font-semibold"
                      id="settings-status-badge">Published</span>
            @elseif($settings)
                <span class="px-2 py-0.5 rounded-full bg-outline/10 text-outline font-label-badge text-label-badge font-semibold"
                      id="settings-status-badge">Draft</span>
            @else
                <span class="px-2 py-0.5 rounded-full bg-error/10 text-error font-label-badge text-label-badge font-semibold"
                      id="settings-status-badge">Belum diset</span>
            @endif
            <span class="material-symbols-outlined text-outline text-[18px] transition-transform duration-200"
                  id="settings-chevron"
                  style="{{ !$settings ? '' : 'transform:rotate(180deg)' }}">expand_more</span>
        </div>
    </button>

    {{-- Form pengaturan (collapsed jika sudah ada settings) --}}
    <div id="settings-panel" class="{{ $settings ? 'hidden' : 'flex' }} flex-col gap-space-sm px-space-md pb-space-md pt-space-xs">
        <form id="settings-form" onsubmit="saveSettings(event)">
            <input type="hidden" id="s-materi-id" value="{{ $materi->id }}"/>

            {{-- Lock banner saat published --}}
            @if($settings && $settings->isPublished())
            <div class="flex items-center gap-space-xs p-space-sm rounded-xl bg-tertiary/10 border border-tertiary/20 mb-space-sm">
                <span class="material-symbols-outlined text-tertiary text-[18px]">lock</span>
                <div class="flex flex-col">
                    <span class="font-body-sm text-body-sm text-tertiary font-semibold">Kuis sedang aktif</span>
                    <span class="font-label-badge text-label-badge text-tertiary/70">
                        Dipublish {{ $settings->published_at?->format('d M Y, H:i') }}. Tarik ke Draft untuk edit.
                    </span>
                </div>
            </div>
            @endif

            {{-- ID Kuis --}}
            <div class="flex flex-col gap-space-2xs mb-space-sm">
                <label class="font-label-badge text-label-badge uppercase text-outline">
                    ID Kuis <span class="text-error">*</span>
                </label>
                <input id="s-id-kuis" type="text" required
                    placeholder="Contoh: KUIS-HTML-2024"
                    value="{{ $settings?->id_kuis ?? '' }}"
                    {{ $settings?->isPublished() ? 'disabled' : '' }}
                    class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-code-inline text-code-inline text-on-surface focus:outline-none focus:border-secondary disabled:opacity-50 disabled:cursor-not-allowed"/>
                <p class="font-body-sm text-body-sm text-outline">ID ini dipakai sebagai prefix semua soal.</p>
            </div>

            {{-- Waktu per soal --}}
            <div class="flex flex-col gap-space-2xs mb-space-sm">
                <label class="font-label-badge text-label-badge uppercase text-outline">
                    Waktu Per Soal <span class="text-error">*</span>
                </label>
                <div class="flex gap-space-xs">
                    <input id="s-waktu" type="number" min="1" max="3600" required
                        value="{{ $settings?->waktu_per_soal ?? 30 }}"
                        {{ $settings?->isPublished() ? 'disabled' : '' }}
                        class="flex-1 h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-code-inline text-code-inline text-on-surface focus:outline-none focus:border-secondary text-center disabled:opacity-50 disabled:cursor-not-allowed"/>
                    <select id="s-satuan"
                        {{ $settings?->isPublished() ? 'disabled' : '' }}
                        class="w-24 h-10 px-space-xs rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-secondary cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                        <option value="detik" {{ ($settings?->satuan_waktu ?? 'detik') === 'detik' ? 'selected' : '' }}>Detik</option>
                        <option value="menit" {{ ($settings?->satuan_waktu) === 'menit' ? 'selected' : '' }}>Menit</option>
                        <option value="jam"   {{ ($settings?->satuan_waktu) === 'jam'   ? 'selected' : '' }}>Jam</option>
                    </select>
                </div>
            </div>

            {{-- KKM --}}
            <div class="flex flex-col gap-space-2xs mb-space-md">
                <label class="font-label-badge text-label-badge uppercase text-outline">
                    KKM (%) <span class="text-error">*</span>
                </label>
                <div class="flex items-center gap-space-sm">
                    <input id="s-kkm" type="range" min="0" max="100"
                        value="{{ $settings?->kkm ?? 70 }}"
                        {{ $settings?->isPublished() ? 'disabled' : '' }}
                        class="flex-1 accent-secondary cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                        oninput="document.getElementById('s-kkm-val').textContent = this.value + '%'"/>
                    <span id="s-kkm-val"
                          class="w-12 text-right font-code-inline text-code-inline font-bold text-secondary">
                        {{ ($settings?->kkm ?? 70) }}%
                    </span>
                </div>
                <p class="font-body-sm text-body-sm text-outline">Minimal % jawaban benar untuk lulus.</p>
            </div>

            <button type="submit" id="btn-save-settings"
                {{ $settings?->isPublished() ? 'disabled' : '' }}
                class="w-full flex items-center justify-center gap-space-xs py-space-sm rounded-xl bg-secondary text-on-secondary font-title-sm text-title-sm font-semibold hover:opacity-90 transition-opacity shadow-sm disabled:opacity-40 disabled:cursor-not-allowed">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan Pengaturan
            </button>
        </form>
    </div>

    {{-- Summary (collapsed state) --}}
    @if($settings)
    <div id="settings-summary" class="flex items-center gap-space-md px-space-md pb-space-sm">
        <div class="flex items-center gap-space-xs">
            <span class="material-symbols-outlined text-outline text-[14px]">badge</span>
            <span class="font-code-inline text-code-inline text-on-surface font-semibold">{{ $settings->id_kuis }}</span>
        </div>
        <div class="flex items-center gap-space-2xs text-on-surface-variant">
            <span class="material-symbols-outlined text-[14px]">timer</span>
            <span class="font-body-sm text-body-sm">{{ $settings->waktu_per_soal }} {{ $settings->satuan_waktu }}</span>
        </div>
        <div class="flex items-center gap-space-2xs text-on-surface-variant">
            <span class="material-symbols-outlined text-[14px]">school</span>
            <span class="font-body-sm text-body-sm">KKM {{ $settings->kkm }}%</span>
        </div>
    </div>
    @else
    <div id="settings-summary" class="hidden"></div>
    @endif

</div>
