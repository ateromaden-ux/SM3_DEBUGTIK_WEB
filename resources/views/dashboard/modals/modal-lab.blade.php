{{--
    Modal: Tambah / Edit Lab Praktik
    Dipanggil via JS: toggleLabModal(true/false), openEditLabModal(lab)
--}}
<div class="fixed inset-0 z-[100] bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-space-md" id="lab-modal">
    <div class="bg-surface-container-lowest rounded-2xl max-w-2xl w-full p-space-lg shadow-xl flex flex-col gap-space-md max-h-[90vh] overflow-y-auto">

        {{-- Header modal --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-space-xs">
                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined text-[24px]">terminal</span>
                </div>
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface font-bold" id="lab-modal-title">Tambah Lab Praktik</h3>
                    <span class="font-body-sm text-body-sm text-outline" id="lab-modal-subtitle">Entitas: `lab_praktik`</span>
                </div>
            </div>
            <button class="w-8 h-8 rounded-full bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface-variant transition-colors"
                    onclick="toggleLabModal(false)" type="button">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        {{-- Form --}}
        <form class="flex flex-col gap-space-md mt-space-2xs" id="lab-form" onsubmit="handleLabSubmit(event)">
            <input type="hidden" id="lab-materi-id" value=""/>
            <input type="hidden" id="lab-db-id" value=""/>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">ID Lab (PK) <span class="text-error">*</span></label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm"
                           id="lab-id-lab" placeholder="Contoh: LAB-CSS-02" required type="text"/>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Tingkat Kesulitan <span class="text-error">*</span></label>
                    <select class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm cursor-pointer"
                            id="lab-kesulitan">
                        <option value="mudah">Mudah</option>
                        <option value="sedang">Sedang</option>
                        <option value="sulit">Sulit</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Deskripsi Kasus Bug <span class="text-error">*</span></label>
                <textarea class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm resize-none"
                          id="lab-deskripsi" rows="2" required placeholder="Deskripsikan bug yang harus diperbaiki siswa..."></textarea>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Kode Soal Awal (dengan bug) <span class="text-error">*</span></label>
                <textarea class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm resize-none"
                          id="lab-kode-awal" rows="4" required placeholder="Tulis kode yang mengandung bug..."></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Bug Target <span class="text-error">*</span></label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm"
                           id="lab-bug-target" required placeholder="Baris/kode yang mengandung bug" type="text"/>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Poin Maksimal <span class="text-error">*</span></label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm"
                           id="lab-poin-max" min="10" max="200" type="number" value="100"/>
                </div>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Solusi Fix (kode yang benar) <span class="text-error">*</span></label>
                <textarea class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm resize-none"
                          id="lab-solusi" rows="3" required placeholder="Kode yang sudah diperbaiki..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-space-sm pt-space-sm border-t border-surface-container">
                <button class="px-space-md py-space-sm rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-body-sm text-body-sm font-medium transition-colors"
                        onclick="toggleLabModal(false)" type="button">Batal</button>
                <button class="px-space-lg py-space-sm rounded-xl bg-tertiary hover:opacity-90 text-on-tertiary font-body-sm text-body-sm font-semibold transition-all shadow-sm active:scale-95"
                        type="submit" id="btn-simpan-lab">Simpan Lab</button>
            </div>
        </form>
    </div>
</div>
