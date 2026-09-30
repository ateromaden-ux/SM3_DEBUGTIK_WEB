{{--
    Panel Kanan — Editor Soal (toolbar + form pertanyaan + opsi/essay + footer actions).
    Variabel: $materi
--}}

{{-- ── Toolbar tipe soal ── --}}
<div id="type-toolbar" class="hidden flex-shrink-0 bg-surface-container-lowest border-b border-outline-variant/20 px-space-lg py-space-sm items-center gap-space-xs overflow-x-auto">
    <span class="font-label-badge text-label-badge uppercase text-outline mr-space-xs whitespace-nowrap">Tipe Soal:</span>
    @foreach([
        ['pilihan_ganda',  'radio_button_checked', 'Pilihan Ganda'],
        ['multiple_answer','checklist',             'Multi Jawaban'],
        ['essay',          'edit_note',             'Essay'],
    ] as [$val, $icon, $label])
    <button type="button"
        onclick="setTipe('{{ $val }}')"
        data-tipe="{{ $val }}"
        class="tipe-btn flex items-center gap-space-xs px-space-sm py-space-xs rounded-lg border border-outline-variant/40 text-on-surface-variant hover:border-secondary hover:text-secondary font-body-sm text-body-sm transition-all whitespace-nowrap">
        <span class="material-symbols-outlined text-[16px]">{{ $icon }}</span>
        {{ $label }}
    </button>
    @endforeach

    <div class="ml-auto flex items-center gap-space-xs">
        <label class="font-label-badge text-label-badge uppercase text-outline whitespace-nowrap">Poin:</label>
        <input id="f-poin" type="number" min="1" max="200" value="25"
            class="w-16 h-8 px-space-xs rounded-lg bg-surface-container-low border border-outline-variant/40 font-code-inline text-code-inline text-on-surface text-center focus:outline-none focus:border-secondary"/>
    </div>
</div>

{{-- ── Editor area ── --}}
<div class="flex-1 overflow-y-auto">

    {{-- State kosong --}}
    <div id="form-empty-state" class="flex flex-col items-center justify-center h-full min-h-96 gap-space-lg text-center p-space-xl">
        <div class="w-20 h-20 rounded-3xl bg-secondary/10 flex items-center justify-center">
            <span class="material-symbols-outlined text-secondary text-[40px]">quiz</span>
        </div>
        <div>
            <p class="font-headline-md text-headline-md font-bold text-on-surface">Pilih soal atau buat baru</p>
            <p class="font-body-md text-body-md text-on-surface-variant mt-space-xs max-w-xs mx-auto">
                Klik soal di panel kiri untuk mengeditnya, atau mulai dari soal baru.
            </p>
        </div>
        <button onclick="newSoal()"
            class="flex items-center gap-space-xs px-space-xl py-space-sm rounded-xl bg-secondary text-on-secondary font-title-sm text-title-sm font-semibold shadow-md hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-[20px]">add_circle</span>
            Buat Soal Pertama
        </button>
    </div>

    {{-- Form editor aktif --}}
    <div id="soal-form-wrapper" class="hidden flex-col h-full">
        <form id="soal-form" onsubmit="handleSimpan(event)" class="flex flex-col h-full">
            <input type="hidden" id="f-db-id" value=""/>
            <input type="hidden" id="f-materi-id" value="{{ $materi->id }}"/>
            <input type="hidden" id="f-tipe" value="pilihan_ganda"/>
            <input type="hidden" id="f-kunci" value=""/>

            {{-- Zona pertanyaan --}}
            <div class="flex-shrink-0 bg-surface-container-lowest border-b border-outline-variant/20 px-space-xl py-space-lg">
                <div class="max-w-3xl mx-auto">
                    <div class="flex items-center gap-space-xs mb-space-sm">
                        <span class="font-label-badge text-label-badge uppercase text-outline">Pertanyaan</span>
                        <span class="text-error font-label-badge">*</span>
                    </div>
                    <textarea id="f-pertanyaan" required rows="3"
                        placeholder="Tulis pertanyaan di sini..."
                        class="w-full px-space-md py-space-sm rounded-2xl bg-surface border-2 border-outline-variant/30 focus:border-secondary focus:outline-none font-body-lg text-body-lg text-on-surface shadow-sm resize-none transition-colors placeholder:text-outline/50"></textarea>

                    <div class="flex items-center gap-space-md mt-space-sm">
                        <div class="flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-outline text-[14px]">tag</span>
                            <span class="font-label-badge text-label-badge uppercase text-outline">ID Soal:</span>
                            <span class="font-code-inline text-code-inline text-on-surface-variant" id="f-id-soal-display">auto</span>
                            <input id="f-id-soal" type="hidden" value=""/>
                        </div>
                    </div>

                    {{-- Attachment zone --}}
                    <div class="mt-space-md flex flex-col gap-space-xs" id="soal-attachment-zone">
                        <div class="flex items-center justify-between">
                            <span class="font-label-badge text-label-badge uppercase text-outline">Lampiran Soal</span>
                            <span class="font-body-sm text-body-sm text-outline">Gambar, PDF · Maks 5 MB</span>
                        </div>
                        <div id="soal-saved-attachments" class="hidden flex-col gap-space-xs"></div>
                        <div id="soal-drop-zone"
                             class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl border-2 border-dashed border-outline-variant/40 bg-surface hover:border-secondary hover:bg-secondary/5 transition-all cursor-pointer"
                             onclick="document.getElementById('soal-file-input').click()"
                             ondragover="event.preventDefault(); this.classList.add('border-secondary','bg-secondary/5')"
                             ondragleave="this.classList.remove('border-secondary','bg-secondary/5')"
                             ondrop="handleSoalDrop(event)">
                            <span class="material-symbols-outlined text-outline text-[20px]">add_photo_alternate</span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">
                                <span class="text-secondary font-semibold">Klik</span> atau drag untuk lampirkan file
                            </span>
                            <input type="file" id="soal-file-input" class="hidden" multiple
                                   accept=".jpg,.jpeg,.png,.gif,.webp,.pdf"
                                   onchange="handleSoalFileSelect(this.files)"/>
                        </div>
                        <div id="soal-file-preview" class="hidden flex-col gap-space-xs"></div>
                    </div>
                </div>
            </div>

            {{-- Zona opsi jawaban (Pilihan Ganda / Multi) --}}
            <div id="opsi-section" class="flex-1 px-space-xl py-space-lg">
                <div class="max-w-3xl mx-auto flex flex-col gap-space-md h-full">
                    <div class="flex items-center justify-between">
                        <span class="font-label-badge text-label-badge uppercase text-outline" id="opsi-hint">Klik tile untuk tandai jawaban benar</span>
                    </div>

                    {{-- Grid 2x2 tile opsi --}}
                    <div class="grid grid-cols-2 gap-space-md flex-1" id="opsi-grid">
                        @foreach(['A','B','C','D'] as $huruf)
                        <div class="opsi-tile group relative flex flex-col rounded-2xl border-2 border-outline-variant/30 bg-surface-container-lowest hover:border-outline-variant transition-all cursor-pointer overflow-hidden"
                             id="tile-{{ strtolower($huruf) }}"
                             onclick="toggleOpsiKunci('{{ $huruf }}')">

                            {{-- Badge huruf + checkmark --}}
                            <div class="flex items-center justify-between px-space-md pt-space-sm pb-space-xs flex-shrink-0">
                                <div class="w-8 h-8 rounded-xl border-2 border-outline-variant/40 flex items-center justify-center transition-all opsi-badge-wrap"
                                     id="badge-{{ strtolower($huruf) }}">
                                    <span class="font-code-inline text-code-inline font-bold text-on-surface-variant opsi-badge-letter">{{ $huruf }}</span>
                                    <span class="material-symbols-outlined text-on-tertiary text-[16px] opsi-badge-check hidden">check</span>
                                </div>
                            </div>

                            {{-- Preview gambar opsi --}}
                            <div id="opsi-img-preview-{{ strtolower($huruf) }}" class="hidden px-space-md pb-space-xs" onclick="event.stopPropagation()">
                                <div class="relative rounded-xl overflow-hidden bg-surface-container-low" style="max-height:120px">
                                    <img id="opsi-img-{{ strtolower($huruf) }}" src="" alt="" class="w-full object-cover" style="max-height:120px"/>
                                    <button type="button"
                                        onclick="removeOpsiImage('{{ strtolower($huruf) }}')"
                                        class="absolute top-1 right-1 w-6 h-6 rounded-full bg-inverse-surface/60 flex items-center justify-center hover:bg-error transition-colors">
                                        <span class="material-symbols-outlined text-surface text-[14px]">close</span>
                                    </button>
                                </div>
                            </div>

                            {{-- Input teks opsi --}}
                            <div class="flex-1 px-space-md pb-space-sm" onclick="event.stopPropagation()">
                                <input type="text" id="opsi-{{ strtolower($huruf) }}"
                                    placeholder="Opsi {{ $huruf }}..."
                                    class="w-full bg-transparent font-body-md text-body-md text-on-surface focus:outline-none placeholder:text-outline/50"/>
                            </div>

                            {{-- Penjelasan --}}
                            <div class="px-space-md border-t border-outline-variant/20 pt-space-xs" onclick="event.stopPropagation()">
                                <input type="text" id="penj-{{ strtolower($huruf) }}"
                                    placeholder="+ Penjelasan (opsional)..."
                                    class="w-full bg-transparent font-body-sm text-body-sm text-on-surface-variant focus:outline-none placeholder:text-outline/40"/>
                            </div>

                            {{-- Upload foto opsi --}}
                            <div class="px-space-md pb-space-sm pt-space-xs flex items-center gap-space-xs" onclick="event.stopPropagation()">
                                <button type="button"
                                    onclick="document.getElementById('opsi-file-{{ strtolower($huruf) }}').click()"
                                    class="flex items-center gap-space-2xs px-space-xs py-space-2xs rounded-lg text-outline hover:text-secondary hover:bg-secondary/10 transition-colors font-body-sm text-body-sm">
                                    <span class="material-symbols-outlined text-[14px]">add_photo_alternate</span>
                                    <span id="opsi-foto-label-{{ strtolower($huruf) }}" class="text-[11px]">Foto</span>
                                </button>
                                <input type="file" id="opsi-file-{{ strtolower($huruf) }}" class="hidden"
                                       accept="image/*"
                                       onchange="handleOpsiImage('{{ strtolower($huruf) }}', this)"/>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Zona essay --}}
            <div id="essay-section" class="hidden flex-1 px-space-xl py-space-lg">
                <div class="max-w-3xl mx-auto">
                    <div class="rounded-2xl border-2 border-dashed border-outline-variant/40 bg-surface-container-lowest p-space-xl flex flex-col items-center justify-center gap-space-md text-center">
                        <span class="material-symbols-outlined text-outline text-[36px]">edit_note</span>
                        <div>
                            <p class="font-title-sm text-title-sm font-semibold text-on-surface">Jawaban Terbuka (Essay)</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-xs">Siswa akan mengetik jawaban secara bebas. Penilaian dilakukan secara manual.</p>
                        </div>
                        <div class="flex flex-col gap-space-2xs w-full max-w-sm">
                            <label class="font-label-badge text-label-badge uppercase text-outline text-left">Panduan Jawaban (opsional)</label>
                            <textarea id="f-essay-panduan" rows="3"
                                placeholder="Contoh: Sebutkan 3 tag HTML dasar..."
                                class="w-full px-space-sm py-space-xs rounded-xl bg-surface border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none resize-none"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer actions --}}
            <div class="flex-shrink-0 bg-surface-container-lowest border-t border-outline-variant/20 px-space-xl py-space-md flex items-center justify-between">
                <div class="flex items-center gap-space-sm">
                    <button type="button" onclick="resetForm()"
                        class="flex items-center gap-space-xs px-space-md py-space-xs rounded-xl border border-outline-variant text-on-surface-variant hover:bg-surface-container font-body-sm text-body-sm transition-colors">
                        <span class="material-symbols-outlined text-[16px]">refresh</span>
                        Reset
                    </button>
                    <button type="button" id="btn-hapus" onclick="deleteSoalFromForm()"
                        class="hidden items-center gap-space-xs px-space-md py-space-xs rounded-xl border border-error/40 text-error hover:bg-error-container font-body-sm text-body-sm transition-colors">
                        <span class="material-symbols-outlined text-[16px]">delete</span>
                        Hapus
                    </button>
                </div>
                <button type="submit" id="btn-simpan"
                    class="flex items-center gap-space-xs px-space-xl py-space-sm rounded-xl bg-secondary text-on-secondary font-title-sm text-title-sm font-semibold shadow-md hover:opacity-90 transition-opacity active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Soal
                </button>
            </div>
        </form>
    </div>
</div>
