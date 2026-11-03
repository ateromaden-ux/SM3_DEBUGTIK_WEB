{{--
    Modal: Lab Praktik
    Dipanggil via JS: toggleLabModal(true/false)
--}}
<div class="fixed inset-0 z-[100] bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-space-md" id="lab-modal">
    <div class="bg-surface-container-lowest rounded-2xl max-w-xl w-full shadow-xl flex flex-col max-h-[90vh]">

        {{-- Header modal — sticky, tidak ikut scroll --}}
        <div class="flex items-center justify-between flex-shrink-0 px-space-lg pt-space-lg pb-space-md border-b border-outline-variant/20">
            <div class="flex items-center gap-space-xs">
                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">code</span>
                </div>
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface font-bold" id="modal-lab-title">+ Lab Praktik Baru</h3>
                    <span class="font-body-sm text-body-sm text-outline">Entitas: `lab_praktik`</span>
                </div>
            </div>
            <button class="w-8 h-8 rounded-full bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface-variant transition-colors"
                    onclick="toggleLabModal(false)" type="button"
                    aria-label="Tutup modal">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        {{-- Form — scrollable --}}
        <form class="flex flex-col gap-space-md px-space-lg py-space-md overflow-y-auto flex-1" id="lab-form" onsubmit="handleLabSubmit(event)">
            <input type="hidden" id="input-lab-id" value=""/>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Judul Lab Praktik <span class="text-error">*</span></label>
                <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface shadow-sm"
                       id="input-lab-judul" placeholder="Contoh: Membuat Form Validasi dengan JavaScript" required type="text"/>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Materi Terkait</label>
                <select class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm cursor-pointer"
                        id="input-lab-materi-id">
                    <option value="">-- Pilih Materi --</option>
                    @if(isset($materi_list) && count($materi_list) > 0)
                        @foreach($materi_list as $materi)
                            <option value="{{ $materi->id }}">{{ $materi->judul_materi }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Instruksi Praktik <span class="text-error">*</span></label>
                <textarea class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm resize-none"
                          id="input-lab-instruksi" rows="6" placeholder="Tuliskan instruksi langkah-langkah praktikum..."></textarea>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Durasi (menit) <span class="text-error">*</span></label>
                <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm"
                       id="input-lab-durasi" type="number" min="5" max="180" value="60" required/>
            </div>

            <div class="p-space-sm rounded-xl bg-surface-container flex items-center justify-between">
                <div class="flex items-center gap-space-xs text-on-surface-variant font-body-sm text-body-sm">
                    <span class="material-symbols-outlined text-[18px] text-primary">person</span>
                    <span>Guru Pengampu:</span>
                </div>
                <span class="font-code-inline text-code-inline font-bold text-on-surface">{{ $guru->name ?? 'Guru' }}</span>
            </div>

            <div class="flex items-center justify-end gap-space-sm pt-space-sm border-t border-surface-container">
                <button class="px-space-md py-space-sm rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-body-sm text-body-sm font-medium transition-colors"
                        onclick="toggleLabModal(false)" type="button">Batal</button>
                <button class="px-space-lg py-space-sm rounded-xl bg-primary hover:bg-primary-container text-on-primary font-body-sm text-body-sm font-semibold transition-all shadow-sm active:scale-95"
                        type="submit" id="btn-simpan-lab">Simpan Lab</button>
            </div>
        </form>
    </div>
</div>