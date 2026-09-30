{{--
    Tab: Pengaturan
    Variabel: $guru
--}}
<div id="view-pengaturan" class="view-section hidden">
    <div class="max-w-2xl mx-auto flex flex-col gap-space-lg">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-headline-md text-headline-md font-bold text-on-surface">Pengaturan</h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">Kelola profil, kelas, dan keamanan akun.</p>
            </div>
        </div>

        {{-- ── CARD: Foto & Identitas ── --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
            <div class="bg-surface-container-low px-space-lg py-space-md border-b border-outline-variant/20 flex items-center gap-space-xs">
                <span class="material-symbols-outlined text-primary text-[20px]">account_circle</span>
                <h3 class="font-title-sm text-title-sm font-bold text-on-surface">Profil & Identitas</h3>
            </div>
            <form id="form-profil" onsubmit="simpanProfil(event)" class="p-space-lg flex flex-col gap-space-md">

                {{-- Foto profil --}}
                <div class="flex items-center gap-space-lg">
                    <div class="relative flex-shrink-0">
                        <div class="w-20 h-20 rounded-2xl bg-primary flex items-center justify-center overflow-hidden" id="foto-wrapper">
                            @if($guru->foto_profil)
                                <img src="{{ Storage::disk('public')->url($guru->foto_profil) }}" class="w-full h-full object-cover" id="foto-preview"/>
                            @else
                                <span class="material-symbols-outlined text-on-primary text-[36px]" id="foto-icon">person</span>
                            @endif
                        </div>
                        <button type="button" onclick="document.getElementById('input-foto').click()"
                            class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-primary flex items-center justify-center shadow-md hover:opacity-90 transition-opacity">
                            <span class="material-symbols-outlined text-on-primary text-[14px]">photo_camera</span>
                        </button>
                        <input type="file" id="input-foto" class="hidden" accept="image/*" onchange="previewFoto(this)"/>
                    </div>
                    <div class="flex flex-col gap-space-2xs">
                        <span class="font-title-sm text-title-sm font-bold text-on-surface" id="display-name-profil">{{ $guru->name }}</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $guru->email }}</span>
                        <span class="font-label-badge text-label-badge text-outline uppercase">{{ $guru->role === 'teacher' ? 'Guru Pengajar' : 'Lab Admin' }}</span>
                    </div>
                </div>

                {{-- Grid field --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                    <div class="flex flex-col gap-space-2xs">
                        <label class="font-label-badge text-label-badge uppercase text-outline">Nama Lengkap <span class="text-error">*</span></label>
                        <input id="pg-name" name="name" type="text" required value="{{ $guru->name }}"
                            class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary"/>
                    </div>
                    <div class="flex flex-col gap-space-2xs">
                        <label class="font-label-badge text-label-badge uppercase text-outline">NIP <span class="text-error">*</span></label>
                        <input id="pg-nip" name="nip" type="text" required value="{{ $guru->nip }}"
                            class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-code-inline text-code-inline text-on-surface focus:outline-none focus:border-primary"/>
                    </div>
                    <div class="flex flex-col gap-space-2xs">
                        <label class="font-label-badge text-label-badge uppercase text-outline">Nama Sekolah</label>
                        <input id="pg-sekolah" name="sekolah" type="text" value="{{ $guru->sekolah }}"
                            class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-primary"/>
                    </div>
                    <div class="flex flex-col gap-space-2xs">
                        <label class="font-label-badge text-label-badge uppercase text-outline">Mata Pelajaran</label>
                        <input id="pg-mapel" name="mata_pelajaran" type="text" value="{{ $guru->mata_pelajaran ?? 'Teknologi Informasi & Komunikasi' }}"
                            class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-primary"/>
                    </div>
                    <div class="flex flex-col gap-space-2xs">
                        <label class="font-label-badge text-label-badge uppercase text-outline">No. HP</label>
                        <input id="pg-nohp" name="no_hp" type="text" value="{{ $guru->no_hp }}"
                            class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-primary"/>
                    </div>
                </div>

                <div class="flex justify-end pt-space-xs border-t border-outline-variant/20">
                    <button type="submit" id="btn-simpan-profil"
                        class="flex items-center gap-space-xs px-space-xl py-space-sm rounded-xl bg-primary text-on-primary font-title-sm text-title-sm font-semibold hover:opacity-90 transition-opacity shadow-sm active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        {{-- ── CARD: Kelas & Kurikulum ── --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
            <div class="bg-surface-container-low px-space-lg py-space-md border-b border-outline-variant/20 flex items-center gap-space-xs">
                <span class="material-symbols-outlined text-secondary text-[20px]">school</span>
                <h3 class="font-title-sm text-title-sm font-bold text-on-surface">Pengaturan Kelas</h3>
            </div>
            <div class="p-space-lg grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Tahun Ajaran <span class="text-error">*</span></label>
                    <input id="pg-tahun" name="tahun_ajaran" type="text" form="form-profil"
                        value="{{ $guru->tahun_ajaran ?? '2024/2025' }}" placeholder="2024/2025"
                        class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-code-inline text-code-inline text-on-surface focus:outline-none focus:border-secondary"/>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Semester <span class="text-error">*</span></label>
                    <select id="pg-semester" name="semester" form="form-profil"
                        class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-secondary cursor-pointer">
                        <option value="Ganjil" {{ ($guru->semester ?? 'Ganjil') === 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                        <option value="Genap"  {{ ($guru->semester ?? '') === 'Genap'  ? 'selected' : '' }}>Semester Genap</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ── CARD: Logout ── --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
            <div class="bg-surface-container-low px-space-lg py-space-md border-b border-outline-variant/20 flex items-center gap-space-xs">
                <span class="material-symbols-outlined text-error text-[20px]">logout</span>
                <h3 class="font-title-sm text-title-sm font-bold text-on-surface">Keluar dari Portal</h3>
            </div>
            <div class="p-space-lg flex items-center justify-between">
                <div class="flex flex-col gap-space-2xs">
                    <span class="font-body-md text-body-md text-on-surface font-semibold">Logout dari semua perangkat</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Sesi akan diakhiri dan kamu harus login ulang.</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-space-xs px-space-lg py-space-sm rounded-xl border-2 border-error/40 text-error hover:bg-error-container font-title-sm text-title-sm font-semibold transition-all">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
