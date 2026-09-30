{{--
    Modal: Tambah / Edit Materi Belajar
    Dipanggil via JS: toggleModal(true/false), openEditorModal(...)
--}}
<div class="fixed inset-0 z-[100] bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-space-md" id="materi-modal">
    <div class="bg-surface-container-lowest rounded-2xl max-w-xl w-full shadow-xl flex flex-col max-h-[90vh]">

        {{-- Header modal — sticky, tidak ikut scroll --}}
        <div class="flex items-center justify-between flex-shrink-0 px-space-lg pt-space-lg pb-space-md border-b border-outline-variant/20">
            <div class="flex items-center gap-space-xs">
                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">dataset</span>
                </div>
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface font-bold" id="modal-title">+ Tambah Materi Belajar Baru</h3>
                    <span class="font-body-sm text-body-sm text-outline">Entitas: `materi_belajar`</span>
                </div>
            </div>
            <button class="w-8 h-8 rounded-full bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface-variant transition-colors"
                    onclick="toggleModal(false)" type="button">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        {{-- Form — scrollable --}}
        <form class="flex flex-col gap-space-md px-space-lg py-space-md overflow-y-auto flex-1" id="materi-form" onsubmit="handleMateriSubmit(event)">
            <input type="hidden" id="input-materi-db-id" value=""/>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">ID Materi (PK) <span class="text-error">*</span></label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm"
                           id="input-id-materi" placeholder="Contoh: BKMP-10, HTML-01, TIK-2024" required type="text"/>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Level Materi <span class="text-error">*</span></label>
                    <select class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm cursor-pointer"
                            id="input-level-materi">
                        <option value="Pemula">Pemula (Fase E - Kelas X)</option>
                        <option value="Menengah">Menengah (Fase F - Kelas XI)</option>
                        <option value="Lanjutan">Lanjutan (Fase F - Kelas XII)</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Judul Materi Belajar <span class="text-error">*</span></label>
                <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface shadow-sm"
                       id="input-judul-materi" placeholder="Contoh: JavaScript Lanjutan: DOM Manipulation & Event Listener" required type="text"/>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Kategori Modul <span class="text-error">*</span></label>
                    <select class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm cursor-pointer"
                            id="input-kategori">
                        <option value="HTML Dasar">HTML Dasar</option>
                        <option value="CSS Dasar">CSS Dasar</option>
                        <option value="JS Dasar">JavaScript Dasar</option>
                        <option value="Web Responsif">Web Responsif (Flex & Grid)</option>
                    </select>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Estimasi Waktu <span class="text-error">*</span></label>
                    <div class="flex gap-space-xs">
                        <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm disabled:opacity-50"
                               id="input-estimasi-waktu" min="10" required type="number" value="45"/>
                        <select id="input-estimasi-tak-terbatas"
                            onchange="toggleEstimasiTakTerbatas(this.value)"
                            class="h-10 px-space-xs rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none cursor-pointer flex-shrink-0">
                            <option value="menit">Menit</option>
                            <option value="tak-terbatas">Tak Terbatas</option>
                        </select>
                    </div>
                    <p class="font-body-sm text-body-sm text-outline">"Tak Terbatas" = siswa bisa baca kapanpun tanpa batas waktu.</p>
                </div>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Deskripsi Singkat</label>
                <textarea class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm resize-none"
                          id="input-deskripsi" rows="2" placeholder="Deskripsi singkat materi ini... (opsional)"></textarea>
            </div>

            <div class="p-space-sm rounded-xl bg-surface-container flex items-center justify-between">
                <div class="flex items-center gap-space-xs text-on-surface-variant font-body-sm text-body-sm">
                    <span class="material-symbols-outlined text-[18px] text-primary">person</span>
                    <span>Guru Pengampu:</span>
                </div>
                <span class="font-code-inline text-code-inline font-bold text-on-surface">{{ $guru->name ?? 'Guru' }}</span>
            </div>

            {{-- Attachment Zone --}}
            <div class="flex flex-col gap-space-xs" id="attachment-zone-wrapper">
                <label class="font-label-badge text-label-badge uppercase text-outline">Lampiran Materi (PDF / Gambar)</label>
                <div id="materi-drop-zone"
                     class="relative flex flex-col items-center justify-center gap-space-xs rounded-xl border-2 border-dashed border-outline-variant/50 bg-surface-container-low hover:border-primary hover:bg-primary/5 transition-all cursor-pointer p-space-lg text-center"
                     onclick="document.getElementById('materi-file-input').click()"
                     ondragover="event.preventDefault(); this.classList.add('border-primary','bg-primary/5')"
                     ondragleave="this.classList.remove('border-primary','bg-primary/5')"
                     ondrop="handleMateriDrop(event)">
                    <span class="material-symbols-outlined text-outline text-[32px]">cloud_upload</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">
                        Drag & drop file di sini, atau <span class="text-primary font-semibold">klik untuk pilih</span>
                    </span>
                    <span class="font-label-badge text-label-badge text-outline">PDF, JPG, PNG, DOCX · Maks 20 MB per file</span>
                    <input type="file" id="materi-file-input" class="hidden" multiple
                           accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx,.ppt,.pptx"
                           onchange="handleMateriFileSelect(this.files)"/>
                </div>
                <div id="materi-file-preview" class="hidden flex-col gap-space-xs mt-space-xs"></div>
                <div id="materi-saved-attachments" class="hidden flex-col gap-space-xs"></div>
            </div>

            <div class="flex items-center justify-end gap-space-sm pt-space-sm border-t border-surface-container">
                <button class="px-space-md py-space-sm rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-body-sm text-body-sm font-medium transition-colors"
                        onclick="toggleModal(false)" type="button">Batal</button>
                <button class="px-space-lg py-space-sm rounded-xl bg-primary hover:bg-primary-container text-on-primary font-body-sm text-body-sm font-semibold transition-all shadow-sm active:scale-95"
                        type="submit" id="btn-simpan-materi">Simpan Materi</button>
            </div>
        </form>
    </div>
</div>
