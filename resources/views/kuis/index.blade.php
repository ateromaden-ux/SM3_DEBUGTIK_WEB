<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet"/>
    <style>
        @layer base { html, body { margin: 0; padding: 0; } body { overscroll-behavior: none; } }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-thumb { background: #bfc7d2; border-radius: 9999px; }
        ::-webkit-scrollbar-track { background: transparent; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    spacing: {
                        'space-2xs': '0.25rem', 'space-xs': '0.5rem', 'space-sm': '0.75rem',
                        'space-md': '1rem', 'space-lg': '1.5rem', 'space-xl': '2rem', 'space-2xl': '3rem',
                    },
                    colors: {
                        "on-primary-container": "#fdfcff", "on-tertiary": "#ffffff",
                        "surface-container-highest": "#d3e4fe", "on-primary": "#ffffff",
                        "inverse-surface": "#213145", "inverse-primary": "#93ccff",
                        "surface-container": "#e5eeff", "tertiary": "#006947",
                        "tertiary-container": "#00855b", "primary": "#006194",
                        "inverse-on-surface": "#eaf1ff", "on-surface-variant": "#3f4850",
                        "on-secondary-container": "#004666", "outline": "#707881",
                        "on-background": "#0b1c30", "on-surface": "#0b1c30",
                        "surface-dim": "#cbdbf5", "surface-bright": "#f8f9ff",
                        "surface-variant": "#d3e4fe", "error-container": "#ffdad6",
                        "outline-variant": "#bfc7d2", "error": "#ba1a1a",
                        "secondary": "#006591", "on-secondary": "#ffffff",
                        "primary-fixed": "#cce5ff", "background": "#f8f9ff",
                        "primary-container": "#007bb9", "tertiary-fixed": "#6ffbbe",
                        "surface-container-high": "#dce9ff", "secondary-container": "#39b8fd",
                        "surface": "#f8f9ff", "surface-container-low": "#eff4ff",
                        "on-error-container": "#93000a", "on-error": "#ffffff",
                        "surface-container-lowest": "#ffffff", "on-secondary-fixed": "#001e2f",
                        "on-tertiary-container": "#f5fff6",
                    },
                    fontFamily: {
                        "headline-md": ["Space Grotesk"], "headline-lg": ["Space Grotesk"],
                        "headline-xl": ["Space Grotesk"], "body-md": ["Geist"], "body-sm": ["Geist"],
                        "body-lg": ["Geist"], "label-badge": ["JetBrains Mono"],
                        "code-inline": ["JetBrains Mono"], "code-editor": ["JetBrains Mono"],
                        "title-sm": ["Geist"],
                    },
                    fontSize: {
                        "headline-md": ["20px", { lineHeight: "28px", letterSpacing: "-0.01em", fontWeight: "500" }],
                        "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.015em", fontWeight: "600" }],
                        "body-md": ["14px", { lineHeight: "22px", fontWeight: "400" }],
                        "body-sm": ["12px", { lineHeight: "18px", fontWeight: "400" }],
                        "label-badge": ["11px", { lineHeight: "14px", letterSpacing: "0.04em", fontWeight: "600" }],
                        "code-inline": ["12px", { lineHeight: "16px", fontWeight: "500" }],
                        "code-editor": ["13px", { lineHeight: "22px", fontWeight: "400" }],
                        "title-sm": ["16px", { lineHeight: "24px", letterSpacing: "-0.005em", fontWeight: "600" }],
                    }
                }
            }
        }
    </script>
    <title>Kelola Soal Kuis — {{ $materi->judul }}</title>
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface h-screen overflow-hidden">

{{-- ═══════════════════════════════════ SIDEBAR ═══════════════════════════════════ --}}
<aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="flex flex-col">
        {{-- Logo --}}
        <div class="h-16 px-space-lg flex items-center gap-space-xs">
            <div class="flex flex-col leading-none ml-space-xs">
                <span class="font-headline-md text-headline-md font-bold tracking-tight text-on-surface">Debug<span class="text-primary">TIK</span></span>
                <span class="font-label-badge text-label-badge text-outline tracking-wider uppercase mt-space-2xs">Portal Guru</span>
            </div>
        </div>

        {{-- Kurikulum badge --}}
        <div class="px-space-md py-space-sm">
            <div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col gap-space-2xs">
                <div class="flex items-center justify-between">
                    <span class="font-label-badge text-label-badge uppercase text-primary font-semibold">Kurikulum Merdeka</span>
                    <span class="h-2 w-2 rounded-full bg-tertiary"></span>
                </div>
                <span class="font-body-sm text-body-sm font-medium text-on-surface">Fase E & F (Kelas X - XI)</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Semester Ganjil 2024/2025</span>
            </div>
        </div>

        {{-- Breadcrumb konteks materi --}}
        <div class="px-space-md mt-space-xs">
            <a href="{{ url('/dashboard?tab=kelola-materi') }}" class="flex items-center gap-space-xs text-on-surface-variant hover:text-primary transition-colors font-body-sm text-body-sm mb-space-xs">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Kembali ke Kelola Materi
            </a>
            <div class="p-space-sm rounded-xl border border-secondary/30 bg-secondary/5 flex flex-col gap-space-2xs">
                <div class="flex items-center gap-space-xs">
                    <span class="material-symbols-outlined text-secondary text-[16px]">quiz</span>
                    <span class="font-label-badge text-label-badge uppercase text-secondary font-semibold">Soal Kuis</span>
                </div>
                <span class="font-body-sm text-body-sm font-semibold text-on-surface line-clamp-2">{{ $materi->judul }}</span>
                <div class="flex items-center gap-space-xs mt-space-2xs">
                    <span class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-badge text-label-badge">{{ $materi->kategori }}</span>
                    <span class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-badge text-label-badge">{{ $materi->level }}</span>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex flex-col gap-space-2xs px-space-md mt-space-md">
            <a href="{{ url('/dashboard?tab=dashboard') }}" class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
                <span class="font-body-md text-body-md">Dasbor Utama</span>
            </a>

            {{-- ── Kelola Materi Belajar ── --}}
            <a href="{{ url('/dashboard?tab=kelola-materi') }}"
                class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">library_books</span>
                <span class="font-body-md text-body-md">Kelola Materi Belajar</span>
            </a>

            {{-- ── Kelola Kuis (dropdown, aktif di halaman ini) ── --}}
            <div>
                <button onclick="toggleKuisDropdown()"
                    class="w-full flex items-center gap-space-sm px-space-md py-space-sm rounded-xl bg-secondary/10 text-secondary font-semibold"
                    id="btn-kuis-dropdown">
                    <span class="material-symbols-outlined text-[20px]">quiz</span>
                    <span class="font-body-md text-body-md flex-1 text-left">Kelola Kuis</span>
                    <span class="material-symbols-outlined text-[18px] transition-transform duration-200" id="kuis-nav-chevron" style="transform:rotate(180deg)">expand_more</span>
                </button>
                <div id="kuis-nav-dropdown" class="flex flex-col gap-space-2xs mt-space-2xs pl-space-md">
                    @forelse($allMateri as $m)
                    <a href="{{ route('kuis.page', $m->id) }}"
                        class="flex items-center gap-space-xs px-space-sm py-space-xs rounded-lg transition-colors {{ $m->id === $materi->id ? 'bg-secondary/10 text-secondary font-semibold' : 'text-on-surface-variant hover:bg-secondary/10 hover:text-secondary' }}">
                        <span class="material-symbols-outlined text-[14px] flex-shrink-0">quiz</span>
                        <span class="font-body-sm text-body-sm truncate flex-1">{{ $m->judul }}</span>
                        <div class="flex items-center gap-space-2xs flex-shrink-0">
                            <span class="font-label-badge text-label-badge text-outline">{{ $m->kuis->count() }}</span>
                            @if($m->kuisSettings?->isPublished())
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary flex-shrink-0"></span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <span class="px-space-sm py-space-xs font-body-sm text-body-sm text-outline italic">Belum ada materi</span>
                    @endforelse
                </div>
            </div>

            <a href="{{ url('/dashboard?tab=rekap') }}" class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">assessment</span>
                <span class="font-body-md text-body-md">Rekap Nilai & Evaluasi</span>
            </a>
            <a href="{{ url('/dashboard?tab=pengaturan') }}" class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                <span class="font-body-md text-body-md">Pengaturan</span>
            </a>
        </nav>
    </div>

    {{-- Footer sidebar --}}
    <div class="p-space-md">
        <div class="p-space-sm rounded-xl bg-surface-container flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-badge text-label-badge text-outline">Compiler Engine</span>
                <span class="font-code-inline text-code-inline text-on-surface font-semibold">V8 Node 20.x Online</span>
            </div>
            <span class="material-symbols-outlined text-tertiary text-[18px]">check_circle</span>
        </div>
    </div>
</aside>

{{-- ═══════════════════════════════════ MAIN ═══════════════════════════════════ --}}
<div class="pl-72 h-screen flex flex-col min-w-0 overflow-hidden">

    {{-- Header --}}
    <header class="flex-shrink-0 h-16 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-40 px-space-lg flex items-center justify-between">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-secondary text-[22px]">quiz</span>
            <div class="flex flex-col leading-none">
                <span class="font-title-sm text-title-sm font-bold text-on-surface">Kelola Soal Kuis</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $materi->judul }}</span>
            </div>
            {{-- Badge status kuis --}}
            @if($settings)
                @if($settings->isPublished())
                    <div class="flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-tertiary/10 border border-tertiary/30" id="status-badge">
                        <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                        <span class="font-label-badge text-label-badge text-tertiary font-bold">PUBLISHED</span>
                    </div>
                @else
                    <div class="flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-outline/10 border border-outline/20" id="status-badge">
                        <span class="w-2 h-2 rounded-full bg-outline"></span>
                        <span class="font-label-badge text-label-badge text-outline font-bold">DRAFT</span>
                    </div>
                @endif
            @else
                <div class="flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-outline/10 border border-outline/20" id="status-badge">
                    <span class="w-2 h-2 rounded-full bg-outline"></span>
                    <span class="font-label-badge text-label-badge text-outline font-bold">DRAFT</span>
                </div>
            @endif
        </div>
        <div class="flex items-center gap-space-md">
            {{-- Tombol Publish / Unpublish --}}
            @if($settings && $settings->isPublished())
                <button
                    onclick="unpublishKuis()"
                    class="flex items-center gap-space-xs px-space-md py-space-xs rounded-xl border-2 border-error/40 text-error hover:bg-error-container font-body-sm text-body-sm font-semibold transition-all"
                    id="btn-publish"
                >
                    <span class="material-symbols-outlined text-[16px]">unpublished</span>
                    Tarik ke Draft
                </button>
            @else
                <button
                    onclick="publishKuis()"
                    class="flex items-center gap-space-xs px-space-md py-space-xs rounded-xl bg-tertiary text-on-tertiary font-body-sm text-body-sm font-semibold hover:opacity-90 transition-opacity shadow-sm"
                    id="btn-publish"
                    {{ !$settings ? 'disabled title=Isi pengaturan kuis dulu' : '' }}
                >
                    <span class="material-symbols-outlined text-[16px]">publish</span>
                    Publish Kuis
                </button>
            @endif
            <span id="soal-counter" class="px-space-sm py-space-2xs rounded-full bg-secondary/10 text-secondary font-label-badge text-label-badge font-semibold">
                {{ $soalList->count() }} soal
            </span>
            <div class="flex items-center gap-space-sm pl-space-xs border-l border-outline-variant/30">
                <div class="flex flex-col text-right leading-none">
                    <span class="font-title-sm text-title-sm text-on-surface font-semibold">{{ $guru->name ?? 'Guru' }}</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $guru->role ?? 'Guru TIK' }}</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                </div>
            </div>
        </div>
    </header>

    {{-- ── Body: panel kiri + panel kanan ── --}}
    <div class="flex-1 flex overflow-hidden">

        {{-- ═══ PANEL KIRI: settings + daftar soal ═══ --}}
        <div class="w-80 flex-shrink-0 border-r border-outline-variant/20 flex flex-col bg-surface-container-lowest overflow-hidden">

            {{-- ── SECTION: Pengaturan Kuis ── --}}
            <div class="flex-shrink-0 border-b border-outline-variant/20">
                {{-- Header settings --}}
                <button
                    onclick="toggleSettings()"
                    class="w-full flex items-center justify-between px-space-md py-space-sm hover:bg-surface-container-low transition-colors"
                    id="btn-settings-toggle"
                >
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-secondary text-[18px]">settings</span>
                        <span class="font-title-sm text-title-sm font-semibold text-on-surface">Pengaturan Kuis</span>
                    </div>
                    <div class="flex items-center gap-space-xs">
                        {{-- Badge status --}}
                        @if($settings && $settings->isPublished())
                            <span class="px-2 py-0.5 rounded-full bg-tertiary/10 text-tertiary font-label-badge text-label-badge font-semibold" id="settings-status-badge">Published</span>
                        @elseif($settings)
                            <span class="px-2 py-0.5 rounded-full bg-outline/10 text-outline font-label-badge text-label-badge font-semibold" id="settings-status-badge">Draft</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-error/10 text-error font-label-badge text-label-badge font-semibold" id="settings-status-badge">Belum diset</span>
                        @endif
                        <span class="material-symbols-outlined text-outline text-[18px] transition-transform duration-200" id="settings-chevron"
                            style="{{ !$settings ? '' : 'transform:rotate(180deg)' }}">expand_more</span>
                    </div>
                </button>

                {{-- Form settings (collapsed by default jika sudah ada settings) --}}
                <div id="settings-panel" class="{{ $settings ? 'hidden' : 'flex' }} flex-col gap-space-sm px-space-md pb-space-md pt-space-xs">
                    <form id="settings-form" onsubmit="saveSettings(event)">
                        <input type="hidden" id="s-materi-id" value="{{ $materi->id }}"/>

                        {{-- Lock banner saat published --}}
                        @if($settings && $settings->isPublished())
                        <div class="flex items-center gap-space-xs p-space-sm rounded-xl bg-tertiary/10 border border-tertiary/20 mb-space-sm">
                            <span class="material-symbols-outlined text-tertiary text-[18px]">lock</span>
                            <div class="flex flex-col">
                                <span class="font-body-sm text-body-sm text-tertiary font-semibold">Kuis sedang aktif</span>
                                <span class="font-label-badge text-label-badge text-tertiary/70">Dipublish {{ $settings->published_at?->format('d M Y, H:i') }}. Tarik ke Draft untuk edit.</span>
                            </div>
                        </div>
                        @endif

                        {{-- ID Kuis --}}
                        <div class="flex flex-col gap-space-2xs mb-space-sm">
                            <label class="font-label-badge text-label-badge uppercase text-outline">
                                ID Kuis <span class="text-error">*</span>
                            </label>
                            <input
                                id="s-id-kuis"
                                type="text"
                                required
                                placeholder="Contoh: KUIS-HTML-2024"
                                value="{{ $settings?->id_kuis ?? '' }}"
                                {{ $settings?->isPublished() ? 'disabled' : '' }}
                                class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-code-inline text-code-inline text-on-surface focus:outline-none focus:border-secondary disabled:opacity-50 disabled:cursor-not-allowed"
                            />
                            <p class="font-body-sm text-body-sm text-outline">ID ini dipakai sebagai prefix semua soal.</p>
                        </div>

                        {{-- Waktu per soal --}}
                        <div class="flex flex-col gap-space-2xs mb-space-sm">
                            <label class="font-label-badge text-label-badge uppercase text-outline">
                                Waktu Per Soal <span class="text-error">*</span>
                            </label>
                            <div class="flex gap-space-xs">
                                <input
                                    id="s-waktu"
                                    type="number"
                                    min="1"
                                    max="3600"
                                    required
                                    value="{{ $settings?->waktu_per_soal ?? 30 }}"
                                    {{ $settings?->isPublished() ? 'disabled' : '' }}
                                    class="flex-1 h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-code-inline text-code-inline text-on-surface focus:outline-none focus:border-secondary text-center disabled:opacity-50 disabled:cursor-not-allowed"
                                />
                                <select
                                    id="s-satuan"
                                    {{ $settings?->isPublished() ? 'disabled' : '' }}
                                    class="w-24 h-10 px-space-xs rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-secondary cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                >
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
                                <input
                                    id="s-kkm"
                                    type="range"
                                    min="0"
                                    max="100"
                                    value="{{ $settings?->kkm ?? 70 }}"
                                    {{ $settings?->isPublished() ? 'disabled' : '' }}
                                    value="{{ $settings?->kkm ?? 70 }}"
                                    class="flex-1 accent-secondary cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                    oninput="document.getElementById('s-kkm-val').textContent = this.value + '%'"
                                />
                                <span
                                    id="s-kkm-val"
                                    class="w-12 text-right font-code-inline text-code-inline font-bold text-secondary"
                                >{{ ($settings?->kkm ?? 70) }}%</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-outline">Minimal % jawaban benar untuk lulus.</p>
                        </div>

                        <button
                            type="submit"
                            id="btn-save-settings"
                            {{ $settings?->isPublished() ? 'disabled' : '' }}
                            class="w-full flex items-center justify-center gap-space-xs py-space-sm rounded-xl bg-secondary text-on-secondary font-title-sm text-title-sm font-semibold hover:opacity-90 transition-opacity shadow-sm disabled:opacity-40 disabled:cursor-not-allowed"
                        >
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Simpan Pengaturan
                        </button>
                    </form>
                </div>

                {{-- Summary (saat settings sudah ada & panel collapsed) --}}
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

            {{-- ── SECTION: Header daftar soal ── --}}
            <div class="flex items-center justify-between px-space-md py-space-sm border-b border-outline-variant/20 flex-shrink-0">
                <span class="font-title-sm text-title-sm font-bold text-on-surface">Daftar Soal</span>
                <button
                    onclick="newSoal()"
                    id="btn-soal-baru"
                    class="flex items-center gap-space-2xs px-space-sm py-space-2xs rounded-lg bg-secondary text-on-secondary font-body-sm text-body-sm font-semibold hover:opacity-90 transition-opacity {{ (!$settings || $settings->isPublished()) ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ (!$settings || $settings->isPublished()) ? 'disabled' : '' }}
                    title="{{ !$settings ? 'Atur pengaturan kuis dulu' : ($settings->isPublished() ? 'Tarik ke Draft untuk menambah soal' : '') }}"
                >
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
                        <div
                            class="soal-item rounded-xl p-space-sm bg-surface-container-low hover:bg-surface-container cursor-pointer transition-colors border-2 border-transparent"
                            data-id="{{ $soal->id }}"
                            onclick="loadSoalToForm({{ $soal->id }})"
                        >
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-center gap-space-xs flex-shrink-0">
                                    <span class="w-6 h-6 rounded-md bg-surface-container-high flex items-center justify-center font-code-inline text-code-inline font-bold text-on-surface-variant">{{ $loop->iteration }}</span>
                                    <span class="px-1.5 py-0.5 rounded-md {{ $tipeBadgeColor }} font-label-badge text-label-badge font-bold">{{ $tipeLabel }}</span>
                                </div>
                                <button
                                    onclick="event.stopPropagation(); deleteSoal({{ $soal->id }}, this)"
                                    class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors flex-shrink-0"
                                >
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

            {{-- Footer: total poin + KKM info --}}
            <div class="flex-shrink-0 px-space-md py-space-sm border-t border-outline-variant/20 bg-surface-container-low">
                <div class="flex items-center justify-between">
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Total poin</span>
                    <span class="font-code-inline text-code-inline font-bold text-on-surface" id="total-poin">{{ $soalList->sum('poin') }}</span>
                </div>
                <div id="kkm-row" class="flex items-center justify-between mt-space-2xs {{ $settings ? '' : 'hidden' }}">
                    <span class="font-body-sm text-body-sm text-on-surface-variant" id="kkm-label">Lulus jika ≥ KKM {{ $settings?->kkm ?? 70 }}%</span>
                    <span class="font-code-inline text-code-inline text-secondary font-bold" id="poin-kkm">
                        ≥ {{ $settings ? round($soalList->sum('poin') * $settings->kkm / 100) : 0 }} poin
                    </span>
                </div>
            </div>
        </div>

        {{-- ═══ PANEL KANAN: Wayground-style editor ═══ --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-surface-container-low">

            {{-- ── Toolbar tipe soal ── --}}
            <div id="type-toolbar" class="hidden flex-shrink-0 bg-surface-container-lowest border-b border-outline-variant/20 px-space-lg py-space-sm items-center gap-space-xs overflow-x-auto">
                <span class="font-label-badge text-label-badge uppercase text-outline mr-space-xs whitespace-nowrap">Tipe Soal:</span>
                @foreach([
                    ['pilihan_ganda',  'radio_button_checked',  'Pilihan Ganda'],
                    ['multiple_answer','checklist',              'Multi Jawaban'],
                    ['essay',          'edit_note',              'Essay'],
                ] as [$val, $icon, $label])
                <button
                    type="button"
                    onclick="setTipe('{{ $val }}')"
                    data-tipe="{{ $val }}"
                    class="tipe-btn flex items-center gap-space-xs px-space-sm py-space-xs rounded-lg border border-outline-variant/40 text-on-surface-variant hover:border-secondary hover:text-secondary font-body-sm text-body-sm transition-all whitespace-nowrap"
                >
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

            {{-- ── Editor area (scrollable) ── --}}
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
                    <button onclick="newSoal()" class="flex items-center gap-space-xs px-space-xl py-space-sm rounded-xl bg-secondary text-on-secondary font-title-sm text-title-sm font-semibold shadow-md hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-[20px]">add_circle</span>
                        Buat Soal Pertama
                    </button>
                </div>

                {{-- Editor aktif --}}
                <div id="soal-form-wrapper" class="hidden flex-col h-full">
                    <form id="soal-form" onsubmit="handleSimpan(event)" class="flex flex-col h-full">
                        <input type="hidden" id="f-db-id" value=""/>
                        <input type="hidden" id="f-materi-id" value="{{ $materi->id }}"/>
                        <input type="hidden" id="f-tipe" value="pilihan_ganda"/>
                        <input type="hidden" id="f-kunci" value=""/>

                        {{-- ── Zona pertanyaan (atas, lebar penuh, krem/putih besar) ── --}}
                        <div class="flex-shrink-0 bg-surface-container-lowest border-b border-outline-variant/20 px-space-xl py-space-lg">
                            <div class="max-w-3xl mx-auto">
                                <div class="flex items-center gap-space-xs mb-space-sm">
                                    <span class="font-label-badge text-label-badge uppercase text-outline">Pertanyaan</span>
                                    <span class="text-error font-label-badge">*</span>
                                </div>
                                <textarea
                                    id="f-pertanyaan"
                                    required
                                    rows="3"
                                    placeholder="Tulis pertanyaan di sini..."
                                    class="w-full px-space-md py-space-sm rounded-2xl bg-surface border-2 border-outline-variant/30 focus:border-secondary focus:outline-none font-body-lg text-body-lg text-on-surface shadow-sm resize-none transition-colors placeholder:text-outline/50"
                                ></textarea>

                                {{-- ID Soal kecil di bawah pertanyaan (auto-generate, readonly) --}}
                                <div class="flex items-center gap-space-md mt-space-sm">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-outline text-[14px]">tag</span>
                                        <span class="font-label-badge text-label-badge uppercase text-outline">ID Soal:</span>
                                        <span class="font-code-inline text-code-inline text-on-surface-variant" id="f-id-soal-display">auto</span>
                                        <input id="f-id-soal" type="hidden" value=""/>
                                    </div>
                                </div>

                                {{-- ── Attachment zone ── --}}
                                <div class="mt-space-md flex flex-col gap-space-xs" id="soal-attachment-zone">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-badge text-label-badge uppercase text-outline">Lampiran Soal</span>
                                        <span class="font-body-sm text-body-sm text-outline">Gambar, PDF · Maks 5 MB</span>
                                    </div>

                                    {{-- Saved attachments (mode edit) --}}
                                    <div id="soal-saved-attachments" class="hidden flex-col gap-space-xs"></div>

                                    {{-- Drop zone --}}
                                    <div
                                        id="soal-drop-zone"
                                        class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl border-2 border-dashed border-outline-variant/40 bg-surface hover:border-secondary hover:bg-secondary/5 transition-all cursor-pointer"
                                        onclick="document.getElementById('soal-file-input').click()"
                                        ondragover="event.preventDefault(); this.classList.add('border-secondary','bg-secondary/5')"
                                        ondragleave="this.classList.remove('border-secondary','bg-secondary/5')"
                                        ondrop="handleSoalDrop(event)"
                                    >
                                        <span class="material-symbols-outlined text-outline text-[20px]">add_photo_alternate</span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">
                                            <span class="text-secondary font-semibold">Klik</span> atau drag untuk lampirkan file
                                        </span>
                                        <input type="file" id="soal-file-input" class="hidden" multiple accept=".jpg,.jpeg,.png,.gif,.webp,.pdf" onchange="handleSoalFileSelect(this.files)"/>
                                    </div>

                                    {{-- Preview pending files --}}
                                    <div id="soal-file-preview" class="hidden flex-col gap-space-xs"></div>
                                </div>
                            </div>
                        </div>

                        {{-- ── Zona opsi jawaban (Wayground tile style) ── --}}
                        <div id="opsi-section" class="flex-1 px-space-xl py-space-lg">
                            <div class="max-w-3xl mx-auto flex flex-col gap-space-md h-full">

                                <div class="flex items-center justify-between">
                                    <span class="font-label-badge text-label-badge uppercase text-outline" id="opsi-hint">Klik tile untuk tandai jawaban benar</span>
                                </div>

                                {{-- Grid 2x2 tile opsi ── Wayground style --}}
                                <div class="grid grid-cols-2 gap-space-md flex-1" id="opsi-grid">
                                    @foreach(['A','B','C','D'] as $huruf)
                                    @php $colors = ['A'=>'from-primary/5', 'B'=>'from-secondary/5', 'C'=>'from-tertiary/5', 'D'=>'from-error/5']; @endphp
                                    <div
                                        class="opsi-tile group relative flex flex-col rounded-2xl border-2 border-outline-variant/30 bg-surface-container-lowest hover:border-outline-variant transition-all cursor-pointer overflow-hidden"
                                        id="tile-{{ strtolower($huruf) }}"
                                        onclick="toggleOpsiKunci('{{ $huruf }}')"
                                    >
                                        {{-- Badge huruf + checkmark --}}
                                        <div class="flex items-center justify-between px-space-md pt-space-sm pb-space-xs flex-shrink-0">
                                            <div class="w-8 h-8 rounded-xl border-2 border-outline-variant/40 flex items-center justify-center transition-all opsi-badge-wrap" id="badge-{{ strtolower($huruf) }}">
                                                <span class="font-code-inline text-code-inline font-bold text-on-surface-variant opsi-badge-letter">{{ $huruf }}</span>
                                                <span class="material-symbols-outlined text-on-tertiary text-[16px] opsi-badge-check hidden">check</span>
                                            </div>
                                        </div>

                                        {{-- Preview gambar opsi (muncul kalau ada foto) --}}
                                        <div id="opsi-img-preview-{{ strtolower($huruf) }}" class="hidden px-space-md pb-space-xs" onclick="event.stopPropagation()">
                                            <div class="relative rounded-xl overflow-hidden bg-surface-container-low" style="max-height:120px">
                                                <img id="opsi-img-{{ strtolower($huruf) }}" src="" alt="" class="w-full object-cover" style="max-height:120px"/>
                                                <button
                                                    type="button"
                                                    onclick="removeOpsiImage('{{ strtolower($huruf) }}')"
                                                    class="absolute top-1 right-1 w-6 h-6 rounded-full bg-inverse-surface/60 flex items-center justify-center hover:bg-error transition-colors"
                                                >
                                                    <span class="material-symbols-outlined text-surface text-[14px]">close</span>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Input teks opsi --}}
                                        <div class="flex-1 px-space-md pb-space-sm" onclick="event.stopPropagation()">
                                            <input
                                                type="text"
                                                id="opsi-{{ strtolower($huruf) }}"
                                                placeholder="Opsi {{ $huruf }}..."
                                                class="w-full bg-transparent font-body-md text-body-md text-on-surface focus:outline-none placeholder:text-outline/50"
                                            />
                                        </div>

                                        {{-- Penjelasan --}}
                                        <div class="px-space-md border-t border-outline-variant/20 pt-space-xs" onclick="event.stopPropagation()">
                                            <input
                                                type="text"
                                                id="penj-{{ strtolower($huruf) }}"
                                                placeholder="+ Penjelasan (opsional)..."
                                                class="w-full bg-transparent font-body-sm text-body-sm text-on-surface-variant focus:outline-none placeholder:text-outline/40"
                                            />
                                        </div>

                                        {{-- Tombol upload foto + hidden file input --}}
                                        <div class="px-space-md pb-space-sm pt-space-xs flex items-center gap-space-xs" onclick="event.stopPropagation()">
                                            <button
                                                type="button"
                                                onclick="document.getElementById('opsi-file-{{ strtolower($huruf) }}').click()"
                                                class="flex items-center gap-space-2xs px-space-xs py-space-2xs rounded-lg text-outline hover:text-secondary hover:bg-secondary/10 transition-colors font-body-sm text-body-sm"
                                            >
                                                <span class="material-symbols-outlined text-[14px]">add_photo_alternate</span>
                                                <span id="opsi-foto-label-{{ strtolower($huruf) }}" class="text-[11px]">Foto</span>
                                            </button>
                                            <input
                                                type="file"
                                                id="opsi-file-{{ strtolower($huruf) }}"
                                                class="hidden"
                                                accept="image/*"
                                                onchange="handleOpsiImage('{{ strtolower($huruf) }}', this)"
                                            />
                                            {{-- hidden: menyimpan pending file object --}}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        {{-- ── Zona essay ── --}}
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
                                        <textarea id="f-essay-panduan" rows="3" placeholder="Contoh: Sebutkan 3 tag HTML dasar..."
                                            class="w-full px-space-sm py-space-xs rounded-xl bg-surface border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none resize-none"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── Footer actions ── --}}
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
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════ TOAST ═══════════════════════════════════ --}}
<div id="toast" class="fixed bottom-6 right-6 z-[200] hidden items-center gap-2 px-4 py-3 rounded-xl shadow-lg font-body-sm text-body-sm font-medium transition-all"></div>

{{-- ═══════════════════════════════════ SCRIPT ═══════════════════════════════════ --}}
<script>
    const CSRF      = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const MATERI_ID = {{ $materi->id }};

    // Data soal dari server (untuk load ke form tanpa fetch ulang)
    let soalData = @json($soalList->keyBy('id'));

    // ─── TOAST ────────────────────────────────────────────────────────────────
    function showToast(msg, type = 'success') {
        const t = document.getElementById('toast');
        const colors = type === 'success'
            ? 'bg-tertiary-container text-on-tertiary-container'
            : 'bg-error-container text-on-error-container';
        const icon = type === 'success' ? 'check_circle' : 'error';
        t.className = `fixed bottom-6 right-6 z-[200] flex items-center gap-2 px-4 py-3 rounded-xl shadow-lg font-body-sm text-body-sm font-medium ${colors}`;
        t.innerHTML = `<span class="material-symbols-outlined text-[18px]">${icon}</span>${msg}`;
        t.classList.remove('hidden');
        setTimeout(() => t.classList.add('hidden'), 3000);
    }

    // ─── TIPE SOAL ────────────────────────────────────────────────────────────
    function setTipe(tipe) {
        document.getElementById('f-tipe').value = tipe;

        // update toolbar button states
        document.querySelectorAll('.tipe-btn').forEach(btn => {
            const isActive = btn.dataset.tipe === tipe;
            btn.classList.toggle('bg-secondary', isActive);
            btn.classList.toggle('text-on-secondary', isActive);
            btn.classList.toggle('border-secondary', isActive);
            btn.classList.toggle('font-semibold', isActive);
            btn.classList.toggle('text-on-surface-variant', !isActive);
            btn.classList.toggle('border-outline-variant/40', !isActive);
        });

        const opsiSection  = document.getElementById('opsi-section');
        const essaySection = document.getElementById('essay-section');
        const hint         = document.getElementById('opsi-hint');
        const isMulti      = tipe === 'multiple_answer';
        const isEssay      = tipe === 'essay';

        opsiSection.classList.toggle('hidden', isEssay);
        opsiSection.classList.toggle('flex',   !isEssay);
        essaySection.classList.toggle('hidden', !isEssay);
        essaySection.classList.toggle('flex',   isEssay);

        // switch tile shape: lingkaran = single, kotak = multi
        ['a','b','c','d'].forEach(h => {
            const badge = document.getElementById(`badge-${h}`);
            if (isMulti) { badge.classList.remove('rounded-xl'); badge.classList.add('rounded-md'); }
            else          { badge.classList.add('rounded-xl');    badge.classList.remove('rounded-md'); }
        });

        if (hint) hint.innerText = isMulti
            ? 'Klik tile untuk pilih (boleh lebih dari satu jawaban benar)'
            : 'Klik tile untuk tandai jawaban benar';

        clearKunci();
    }

    // alias untuk backward-compat
    function onTipeChange() { setTipe(document.getElementById('f-tipe').value); }

    function clearKunci() {
        ['a','b','c','d'].forEach(h => _deselect(h));
        document.getElementById('f-kunci').value = '';
    }

    function _select(hl) {
        const tile  = document.getElementById(`tile-${hl}`);
        const badge = document.getElementById(`badge-${hl}`);
        const letter = badge.querySelector('.opsi-badge-letter');
        const check  = badge.querySelector('.opsi-badge-check');
        tile.classList.add('border-tertiary','bg-tertiary/5','shadow-md');
        tile.classList.remove('border-outline-variant/30');
        badge.classList.add('bg-tertiary','border-tertiary');
        badge.classList.remove('border-outline-variant/40');
        if (letter) letter.classList.add('hidden');
        if (check)  check.classList.remove('hidden');
    }

    function _deselect(hl) {
        const tile  = document.getElementById(`tile-${hl}`);
        const badge = document.getElementById(`badge-${hl}`);
        const letter = badge?.querySelector('.opsi-badge-letter');
        const check  = badge?.querySelector('.opsi-badge-check');
        tile?.classList.remove('border-tertiary','bg-tertiary/5','shadow-md');
        tile?.classList.add('border-outline-variant/30');
        badge?.classList.remove('bg-tertiary','border-tertiary');
        badge?.classList.add('border-outline-variant/40');
        if (letter) letter.classList.remove('hidden');
        if (check)  check.classList.add('hidden');
    }

    function toggleOpsiKunci(huruf) {
        const tipe = document.getElementById('f-tipe').value;
        const hl   = huruf.toLowerCase();
        const tile = document.getElementById(`tile-${hl}`);
        const isOn = tile.classList.contains('border-tertiary');

        if (tipe !== 'multiple_answer') {
            clearKunci();
            _select(hl);
            document.getElementById('f-kunci').value = JSON.stringify([huruf]);
        } else {
            if (isOn) _deselect(hl); else _select(hl);
            const selected = ['A','B','C','D'].filter(h => {
                const t = document.getElementById(`tile-${h.toLowerCase()}`);
                return t && t.classList.contains('border-tertiary');
            });
            document.getElementById('f-kunci').value = JSON.stringify(selected);
        }
    }

    // ─── PANEL KIRI: highlight soal aktif ────────────────────────────────────
    function setActiveCard(id) {
        document.querySelectorAll('.soal-item').forEach(el => {
            el.classList.remove('border-secondary','bg-secondary/5');
            el.classList.add('border-transparent');
        });
        if (id) {
            const el = document.querySelector(`.soal-item[data-id="${id}"]`);
            if (el) {
                el.classList.remove('border-transparent');
                el.classList.add('border-secondary','bg-secondary/5');
            }
        }
    }

    function loadSoalToForm(id) {
        const soal = soalData[id];
        if (!soal) return;

        showFormWrapper();
        setActiveCard(id);

        document.getElementById('f-db-id').value     = soal.id;
        document.getElementById('f-id-soal').value   = soal.id_soal; // hidden
        const disp = document.getElementById('f-id-soal-display');
        if (disp) disp.textContent = soal.id_soal;
        document.getElementById('f-pertanyaan').value = soal.pertanyaan;
        document.getElementById('f-poin').value       = soal.poin;
        document.getElementById('btn-hapus').classList.remove('hidden');
        document.getElementById('btn-hapus').classList.add('flex');

        setTipe(soal.tipe);

        // Load attachment soal yang sudah tersimpan
        loadSoalAttachments(soal.id);
        // Load gambar opsi
        loadOpsiImages(soal.id);

        if (soal.tipe !== 'essay') {
            const opsi = Array.isArray(soal.opsi_jawaban) ? soal.opsi_jawaban
                : (soal.opsi_jawaban ? JSON.parse(soal.opsi_jawaban) : []);
            const penj = Array.isArray(soal.penjelasan_opsi) ? soal.penjelasan_opsi
                : (soal.penjelasan_opsi ? JSON.parse(soal.penjelasan_opsi) : []);
            ['a','b','c','d'].forEach((h, i) => {
                document.getElementById(`opsi-${h}`).value = opsi[i] || '';
                document.getElementById(`penj-${h}`).value = penj[i] || '';
            });

            const kunci = Array.isArray(soal.kunci_jawaban) ? soal.kunci_jawaban
                : (soal.kunci_jawaban ? JSON.parse(soal.kunci_jawaban) : []);
            const hurufIdx = {'A':0,'B':1,'C':2,'D':3};
            kunci.forEach(k => {
                const huruf = ['A','B','C','D'].find(h => h === k || opsi[hurufIdx[h]] === k);
                if (huruf) _select(huruf.toLowerCase());
            });
            document.getElementById('f-kunci').value = JSON.stringify(kunci);
        } else {
            document.getElementById('f-essay-panduan').value = soal.kunci_jawaban?.[0] || '';
        }
    }

    function newSoal() {
        resetForm();
        showFormWrapper();
        setActiveCard(null);
        document.getElementById('f-pertanyaan').focus();
    }

    function resetForm() {
        document.getElementById('soal-form').reset();
        document.getElementById('f-db-id').value  = '';
        document.getElementById('f-id-soal').value = '';
        const disp = document.getElementById('f-id-soal-display');
        if (disp) disp.textContent = 'auto';
        document.getElementById('f-kunci').value  = '';
        document.getElementById('f-poin').value   = '25';
        document.getElementById('btn-hapus').classList.add('hidden');
        document.getElementById('btn-hapus').classList.remove('flex');
        document.querySelectorAll('.dup-hint').forEach(el => { el.textContent = ''; });
        document.getElementById('f-id-soal')?.classList.remove('ring-2','ring-error','ring-tertiary');
        clearSoalAttachments();
        clearOpsiImages();
        setTipe('pilihan_ganda');
    }

    function showFormWrapper() {
        document.getElementById('form-empty-state').classList.add('hidden');
        document.getElementById('type-toolbar').classList.remove('hidden');
        document.getElementById('type-toolbar').classList.add('flex');
        const w = document.getElementById('soal-form-wrapper');
        w.classList.remove('hidden');
        w.classList.add('flex');
    }

    // ─── SIMPAN ───────────────────────────────────────────────────────────────
    function handleSimpan(e) {
        e.preventDefault();
        const dbId   = document.getElementById('f-db-id').value;
        const isEdit = dbId !== '';
        const tipe   = document.getElementById('f-tipe').value;

        let opsi = null, penj = null, kunci = [''];
        if (tipe !== 'essay') {
            opsi = ['a','b','c','d'].map(h => document.getElementById(`opsi-${h}`).value.trim()).filter(v => v);
            penj = ['a','b','c','d'].map(h => document.getElementById(`penj-${h}`).value.trim());

            const kunciRaw = document.getElementById('f-kunci').value;
            try { kunci = JSON.parse(kunciRaw); } catch(e) { kunci = kunciRaw ? [kunciRaw] : []; }

            if (!kunci.length) { showToast('Pilih minimal satu jawaban benar', 'error'); return; }
            if (opsi.length < 2) { showToast('Isi minimal 2 opsi jawaban', 'error'); return; }

            // simpan teks opsi sebagai kunci
            const hurufIdx = {'A':0,'B':1,'C':2,'D':3};
            kunci = kunci.map(k => opsi[hurufIdx[k]] ?? k);
        } else {
            const panduan = document.getElementById('f-essay-panduan').value.trim();
            kunci = panduan ? [panduan] : [''];
        }

        const body = {
            materi_id:       MATERI_ID,
            // id_soal tidak dikirim saat create — auto-generate di backend dari id_kuis
            // saat edit, tidak perlu dikirim juga (tidak berubah)
            tipe,
            pertanyaan:      document.getElementById('f-pertanyaan').value,
            opsi_jawaban:    opsi,
            kunci_jawaban:   kunci,
            penjelasan_opsi: penj,
            poin:            document.getElementById('f-poin').value,
        };

        const url    = isEdit ? `/api/kuis/${dbId}` : '/api/kuis';
        const method = isEdit ? 'PUT' : 'POST';
        const btn    = document.getElementById('btn-simpan');
        btn.disabled = true;

        fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify(body),
        })
        .then(r => r.json())
        .then(async data => {
            if (data.success) {
                showToast(isEdit ? 'Soal diperbarui' : 'Soal disimpan: ' + data.data.id_soal);
                // Upload attachment jika ada file pending
                if (_soalPendingFiles.length) {
                    await uploadSoalAttachments(data.data.id);
                }
                // Upload gambar opsi jawaban jika ada
                if (['a','b','c','d'].some(h => _opsiPendingImages[h])) {
                    await uploadOpsiImages(data.data.id);
                }
                updateSoalData(data.data, isEdit);
                if (!isEdit) {
                    const disp = document.getElementById('f-id-soal-display');
                    if (disp) disp.textContent = data.data.id_soal;
                    newSoal();
                }
            } else {
                const err = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Gagal');
                showToast(err, 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'))
        .finally(() => { btn.disabled = false; });
    }

    // ─── UPDATE PANEL KIRI (tanpa full reload) ────────────────────────────────
    function updateSoalData(soal, isEdit) {
        // update in-memory data
        soalData[soal.id] = soal;

        const tipeBadge = { pilihan_ganda: ['bg-primary/10 text-primary','PG'], multiple_answer: ['bg-secondary/10 text-secondary','Multi'], essay: ['bg-tertiary/10 text-tertiary','Essay'] };
        const [badgeClass, badgeLabel] = tipeBadge[soal.tipe] ?? tipeBadge['pilihan_ganda'];

        if (isEdit) {
            // update card yang ada
            const card = document.querySelector(`.soal-item[data-id="${soal.id}"]`);
            if (card) {
                card.querySelector('p').innerText = soal.pertanyaan;
                card.querySelector('.font-code-inline').innerText = soal.id_soal;
                card.querySelectorAll('.font-label-badge')[0].innerText = soal.poin + ' poin';
            }
        } else {
            // tambah card baru di panel kiri
            const emptyState = document.getElementById('empty-state');
            if (emptyState) emptyState.remove();

            const list  = document.getElementById('soal-list');
            const count = list.querySelectorAll('.soal-item').length + 1;
            const div   = document.createElement('div');
            div.className = 'soal-item rounded-xl p-space-sm bg-surface-container-low hover:bg-surface-container cursor-pointer transition-colors border-2 border-transparent';
            div.setAttribute('data-id', soal.id);
            div.setAttribute('onclick', `loadSoalToForm(${soal.id})`);
            div.innerHTML = `
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-center gap-space-xs flex-shrink-0">
                        <span class="w-6 h-6 rounded-md bg-surface-container-high flex items-center justify-center font-code-inline text-code-inline font-bold text-on-surface-variant">${count}</span>
                        <span class="px-1.5 py-0.5 rounded-md ${badgeClass} font-label-badge text-label-badge font-bold">${badgeLabel}</span>
                    </div>
                    <button onclick="event.stopPropagation(); deleteSoal(${soal.id}, this)"
                        class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors flex-shrink-0">
                        <span class="material-symbols-outlined text-[14px]">delete</span>
                    </button>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface mt-space-xs line-clamp-2">${soal.pertanyaan}</p>
                <div class="flex items-center justify-between mt-space-xs">
                    <span class="font-code-inline text-code-inline text-outline">${soal.id_soal}</span>
                    <span class="font-label-badge text-label-badge text-on-surface-variant">${soal.poin} poin</span>
                </div>`;
            list.appendChild(div);
        }

        updateCounter();
    }

    function updateCounter() {
        const count     = document.querySelectorAll('.soal-item').length;
        const totalPoin = Object.values(soalData).reduce((s, d) => s + (parseInt(d.poin) || 0), 0);
        document.getElementById('soal-counter').innerText = count + ' soal';
        document.getElementById('total-poin').innerText   = totalPoin;

        // Update poin KKM jika row sudah visible
        const kkmRow = document.getElementById('kkm-row');
        const poinEl = document.getElementById('poin-kkm');
        const kkmVal = parseInt(document.getElementById('s-kkm')?.value) || 0;
        if (poinEl && kkmRow && !kkmRow.classList.contains('hidden')) {
            poinEl.textContent = '≥ ' + Math.round(totalPoin * kkmVal / 100) + ' poin';
        }
    }

    // ─── HAPUS (dari list card) ───────────────────────────────────────────────
    function deleteSoal(id, btn) {
        if (!confirm('Hapus soal ini?')) return;
        fetch(`/api/kuis/${id}`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Soal dihapus');
                delete soalData[id];
                const card = document.querySelector(`.soal-item[data-id="${id}"]`);
                if (card) card.remove();
                updateCounter();
                renumberCards();
                // kalau form lagi edit soal ini, reset
                if (document.getElementById('f-db-id').value == id) resetForm();
            } else {
                showToast(data.message || 'Gagal menghapus', 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'));
    }

    // ─── HAPUS (dari tombol di form) ─────────────────────────────────────────
    function deleteSoalFromForm() {
        const id = document.getElementById('f-db-id').value;
        if (!id) return;
        deleteSoal(id, null);
    }

    function renumberCards() {
        document.querySelectorAll('.soal-item').forEach((el, i) => {
            const numEl = el.querySelector('.w-6.h-6');
            if (numEl) numEl.innerText = i + 1;
        });
    }

    // ─── SETTINGS PANEL ──────────────────────────────────────────────────────
    function toggleSettings() {
        const panel   = document.getElementById('settings-panel');
        const summary = document.getElementById('settings-summary');
        const chevron = document.getElementById('settings-chevron');
        const isOpen  = panel.classList.contains('flex');

        if (isOpen) {
            panel.classList.replace('flex', 'hidden');
            summary?.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            panel.classList.replace('hidden', 'flex');
            summary?.classList.add('hidden');
            chevron.style.transform = '';
        }
    }

    function saveSettings(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-save-settings');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">sync</span> Menyimpan...';

        const body = {
            materi_id:      document.getElementById('s-materi-id').value,
            id_kuis:        document.getElementById('s-id-kuis').value.trim(),
            waktu_per_soal: document.getElementById('s-waktu').value,
            satuan_waktu:   document.getElementById('s-satuan').value,
            kkm:            document.getElementById('s-kkm').value,
        };

        fetch('/api/kuis/settings', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body:    JSON.stringify(body),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Pengaturan kuis disimpan');

                // Update summary tanpa reload
                const s = data.data;
                document.getElementById('settings-summary').innerHTML = `
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-outline text-[14px]">badge</span>
                        <span class="font-code-inline text-code-inline text-on-surface font-semibold">${s.id_kuis}</span>
                    </div>
                    <div class="flex items-center gap-space-2xs text-on-surface-variant">
                        <span class="material-symbols-outlined text-[14px]">timer</span>
                        <span class="font-body-sm text-body-sm">${s.waktu_per_soal} ${s.satuan_waktu}</span>
                    </div>
                    <div class="flex items-center gap-space-2xs text-on-surface-variant">
                        <span class="material-symbols-outlined text-[14px]">school</span>
                        <span class="font-body-sm text-body-sm">KKM ${s.kkm}%</span>
                    </div>`;
                document.getElementById('settings-summary').className =
                    'flex items-center gap-space-md px-space-md pb-space-sm';

                // Update status badge
                document.querySelector('#btn-settings-toggle .rounded-full').textContent = 'Tersimpan';
                document.querySelector('#btn-settings-toggle .rounded-full').className =
                    'px-2 py-0.5 rounded-full bg-tertiary/10 text-tertiary font-label-badge text-label-badge font-semibold';

                // Update KKM footer
                const poinEl = document.getElementById('poin-kkm');
                const kkmRow = document.getElementById('kkm-row');
                const kkmLabel = document.getElementById('kkm-label');
                if (poinEl) {
                    const totalPoin = parseInt(document.getElementById('total-poin').textContent) || 0;
                    poinEl.textContent = '≥ ' + Math.round(totalPoin * s.kkm / 100) + ' poin';
                }
                if (kkmLabel) kkmLabel.textContent = 'Lulus jika ≥ KKM ' + s.kkm + '%';
                if (kkmRow)  kkmRow.classList.remove('hidden');

                // Enable tombol soal baru
                const btnSoal = document.getElementById('btn-soal-baru');
                if (btnSoal) {
                    btnSoal.disabled = false;
                    btnSoal.classList.remove('opacity-50','cursor-not-allowed');
                    btnSoal.title = '';
                }

                toggleSettings(); // collapse panel
            } else {
                const err = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Gagal');
                showToast(err, 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">save</span> Simpan Pengaturan';
        });
    }
    let _debounceTimer = null;
    function debounceCheck(fn, ms = 500) {
        clearTimeout(_debounceTimer); _debounceTimer = setTimeout(fn, ms);
    }

    function setFieldState(inputEl, state, msg = '') {
        let hint = inputEl.parentElement.querySelector('.dup-hint');
        if (!hint) {
            hint = document.createElement('span');
            hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs block';
            inputEl.parentElement.appendChild(hint);
        }
        inputEl.classList.remove('ring-2','ring-error','ring-tertiary');
        hint.textContent = msg;
        if (state === 'error') {
            inputEl.classList.add('ring-2','ring-error');
            hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs block text-error';
        } else if (state === 'ok') {
            inputEl.classList.add('ring-2','ring-tertiary');
            hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs block text-tertiary';
        } else {
            hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs block text-outline';
        }
    }

    // ─── GAMBAR OPSI JAWABAN ──────────────────────────────────────────────────
    // Menyimpan pending File object per huruf opsi: { a: File|null, b: File|null, ... }
    const _opsiPendingImages = { a: null, b: null, c: null, d: null };
    // URL gambar opsi yang sudah tersimpan di server (saat mode edit): { a: url|null, ... }
    const _opsiSavedImages   = { a: null, b: null, c: null, d: null };

    function handleOpsiImage(huruf, input) {
        const file = input.files[0];
        if (!file) return;

        // Validasi: hanya gambar, maks 5 MB
        if (!file.type.startsWith('image/')) { showToast('Hanya file gambar yang diizinkan', 'error'); return; }
        if (file.size > 5 * 1024 * 1024)    { showToast('Ukuran gambar maksimal 5 MB', 'error'); return; }

        _opsiPendingImages[huruf] = file;

        // Preview langsung
        const reader = new FileReader();
        reader.onload = e => _showOpsiImagePreview(huruf, e.target.result);
        reader.readAsDataURL(file);
    }

    function _showOpsiImagePreview(huruf, src) {
        const wrapper = document.getElementById(`opsi-img-preview-${huruf}`);
        const img     = document.getElementById(`opsi-img-${huruf}`);
        const label   = document.getElementById(`opsi-foto-label-${huruf}`);
        img.src       = src;
        wrapper.classList.remove('hidden');
        if (label) label.textContent = 'Ganti';
    }

    function removeOpsiImage(huruf) {
        _opsiPendingImages[huruf] = null;
        _opsiSavedImages[huruf]   = null;

        const wrapper = document.getElementById(`opsi-img-preview-${huruf}`);
        const img     = document.getElementById(`opsi-img-${huruf}`);
        const label   = document.getElementById(`opsi-foto-label-${huruf}`);
        const input   = document.getElementById(`opsi-file-${huruf}`);
        img.src       = '';
        wrapper.classList.add('hidden');
        if (label) label.textContent = 'Foto';
        if (input) input.value = '';
    }

    // Upload semua pending gambar opsi setelah soal berhasil disimpan
    async function uploadOpsiImages(soalId) {
        for (const huruf of ['a','b','c','d']) {
            const file = _opsiPendingImages[huruf];
            if (!file) continue;

            // Rename dengan prefix opsi-A- agar identifiable saat load
            const ext      = file.name.split('.').pop();
            const renamed  = new File([file], `opsi-${huruf.toUpperCase()}-${Date.now()}.${ext}`, { type: file.type });

            const fd = new FormData();
            fd.append('files[]', renamed);
            fd.append('_token', CSRF);

            try {
                await fetch(`/api/attachment/soal/${soalId}`, { method: 'POST', body: fd });
            } catch(e) { /* non-critical */ }

            _opsiPendingImages[huruf] = null;
        }
    }

    // Load saved gambar opsi saat mode edit — cari attachment per soal yang punya opsi_huruf
    function loadOpsiImages(soalId) {
        // Reset dulu
        ['a','b','c','d'].forEach(h => {
            _opsiSavedImages[h] = null;
            removeOpsiImage(h);
        });

        fetch(`/api/attachment/soal/${soalId}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                // Kita pakai konvensi nama file: "opsi-A-...", "opsi-B-..." untuk gambar opsi
                data.data.forEach(att => {
                    const match = att.nama_file.match(/^opsi-([ABCD])-/i);
                    if (match) {
                        const huruf = match[1].toLowerCase();
                        _opsiSavedImages[huruf] = att.url;
                        _showOpsiImagePreview(huruf, att.url);
                    }
                });
            });
    }

    // Reset semua gambar opsi
    function clearOpsiImages() {
        ['a','b','c','d'].forEach(h => removeOpsiImage(h));
    }

    // ─── ATTACHMENT SOAL ──────────────────────────────────────────────────────
    let _soalPendingFiles = [];

    function handleSoalDrop(e) {
        e.preventDefault();
        document.getElementById('soal-drop-zone').classList.remove('border-secondary','bg-secondary/5');
        handleSoalFileSelect(e.dataTransfer.files);
    }

    function handleSoalFileSelect(files) {
        Array.from(files).forEach(f => _soalPendingFiles.push(f));
        renderSoalFilePreview();
    }

    function renderSoalFilePreview() {
        const container = document.getElementById('soal-file-preview');
        if (!_soalPendingFiles.length) { container.classList.add('hidden'); return; }
        container.classList.remove('hidden');
        container.classList.add('flex');
        container.innerHTML = _soalPendingFiles.map((f, i) => `
            <div class="flex items-center gap-space-xs px-space-sm py-space-xs rounded-xl bg-surface-container border border-outline-variant/20">
                ${f.type.startsWith('image/')
                    ? `<img src="${URL.createObjectURL(f)}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0"/>`
                    : `<span class="material-symbols-outlined text-error text-[24px] flex-shrink-0">picture_as_pdf</span>`
                }
                <span class="font-body-sm text-body-sm text-on-surface flex-1 truncate">${f.name}</span>
                <span class="font-label-badge text-label-badge text-outline flex-shrink-0">${(f.size/1024/1024).toFixed(1)} MB</span>
                <button type="button" onclick="removeSoalFile(${i})"
                    class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors flex-shrink-0">
                    <span class="material-symbols-outlined text-[14px]">close</span>
                </button>
            </div>`).join('');
    }

    function removeSoalFile(idx) {
        _soalPendingFiles.splice(idx, 1);
        renderSoalFilePreview();
    }

    function renderSoalSavedAttachments(attachments) {
        const container = document.getElementById('soal-saved-attachments');
        if (!attachments || !attachments.length) {
            container.classList.add('hidden');
            return;
        }
        container.classList.remove('hidden');
        container.classList.add('flex');
        container.innerHTML = attachments.map(a => `
            <div class="flex items-center gap-space-xs px-space-sm py-space-xs rounded-xl bg-surface-container border border-outline-variant/20 group" id="soal-att-${a.id}">
                ${a.is_image
                    ? `<img src="${a.url}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0 cursor-pointer" onclick="window.open('${a.url}','_blank')"/>`
                    : `<span class="material-symbols-outlined text-error text-[24px] flex-shrink-0">picture_as_pdf</span>`
                }
                <a href="${a.url}" target="_blank"
                    class="font-body-sm text-body-sm text-primary hover:underline flex-1 truncate">${a.nama_file}</a>
                <span class="font-label-badge text-label-badge text-outline flex-shrink-0">${a.ukuran_readable}</span>
                <button type="button" onclick="deleteSoalAttachment(${a.id})"
                    class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors flex-shrink-0 opacity-0 group-hover:opacity-100">
                    <span class="material-symbols-outlined text-[14px]">delete</span>
                </button>
            </div>`).join('');
    }

    async function uploadSoalAttachments(soalId) {
        if (!_soalPendingFiles.length) return;
        const fd = new FormData();
        _soalPendingFiles.forEach(f => fd.append('files[]', f));
        fd.append('_token', CSRF);
        const res  = await fetch(`/api/attachment/soal/${soalId}`, { method: 'POST', body: fd });
        const data = await res.json();
        if (data.success) renderSoalSavedAttachments([
            ...Array.from(document.querySelectorAll(`[id^="soal-att-"]`)).map(el => ({ id: el.id.replace('soal-att-','') })),
            ...data.data,
        ]);
        _soalPendingFiles = [];
        renderSoalFilePreview();
    }

    function deleteSoalAttachment(id) {
        if (!confirm('Hapus file ini?')) return;
        fetch(`/api/attachment/${id}`, {
            method:  'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                document.getElementById(`soal-att-${id}`)?.remove();
                showToast('File dihapus');
            }
        });
    }

    function loadSoalAttachments(soalId) {
        fetch(`/api/attachment/soal/${soalId}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
            .then(r => r.json())
            .then(d => { if (d.success) renderSoalSavedAttachments(d.data); });
    }

    function clearSoalAttachments() {
        _soalPendingFiles = [];
        renderSoalFilePreview();
        const c = document.getElementById('soal-saved-attachments');
        if (c) { c.innerHTML = ''; c.classList.add('hidden'); }
    }

    // ─── PUBLISH / UNPUBLISH ──────────────────────────────────────────────────
    const MATERI_ID_PAGE = {{ $materi->id }};

    function publishKuis() {
        if (!confirm('Publish kuis ini? Siswa akan bisa mengerjakan kuis setelah dipublish.')) return;

        const btn = document.getElementById('btn-publish');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">sync</span> Memproses...';

        fetch(`/api/kuis/publish/${MATERI_ID_PAGE}`, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                _updatePublishUI('published', data.published_at);
            } else {
                showToast(data.message || 'Gagal publish', 'error');
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">publish</span> Publish Kuis';
            }
        })
        .catch(err => {
            showToast('Error: ' + err.message, 'error');
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">publish</span> Publish Kuis';
        });
    }

    function unpublishKuis() {
        if (!confirm('Tarik kuis ke Draft? Siswa tidak akan bisa mengerjakan kuis selama dalam Draft.')) return;

        const btn = document.getElementById('btn-publish');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">sync</span> Memproses...';

        fetch(`/api/kuis/unpublish/${MATERI_ID_PAGE}`, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                _updatePublishUI('draft', null);
            } else {
                showToast(data.message || 'Gagal', 'error');
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">unpublished</span> Tarik ke Draft';
            }
        })
        .catch(err => {
            showToast('Error: ' + err.message, 'error');
            btn.disabled = false;
        });
    }

    function _updatePublishUI(status, publishedAt) {
        const isPublished = status === 'published';
        const btn         = document.getElementById('btn-publish');
        const badge       = document.getElementById('status-badge');
        const settingsBadge = document.getElementById('settings-status-badge');
        const btnSoal     = document.getElementById('btn-soal-baru');
        const btnSave     = document.getElementById('btn-save-settings');
        const inputs      = document.querySelectorAll('#s-id-kuis, #s-waktu, #s-satuan, #s-kkm');

        // Tombol publish ↔ unpublish
        if (isPublished) {
            btn.className = 'flex items-center gap-space-xs px-space-md py-space-xs rounded-xl border-2 border-error/40 text-error hover:bg-error-container font-body-sm text-body-sm font-semibold transition-all';
            btn.setAttribute('onclick', 'unpublishKuis()');
            btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">unpublished</span> Tarik ke Draft';
        } else {
            btn.className = 'flex items-center gap-space-xs px-space-md py-space-xs rounded-xl bg-tertiary text-on-tertiary font-body-sm text-body-sm font-semibold hover:opacity-90 transition-opacity shadow-sm';
            btn.setAttribute('onclick', 'publishKuis()');
            btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">publish</span> Publish Kuis';
        }
        btn.disabled = false;

        // Badge di header
        if (badge) {
            badge.innerHTML = isPublished
                ? '<span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span><span class="font-label-badge text-label-badge text-tertiary font-bold">PUBLISHED</span>'
                : '<span class="w-2 h-2 rounded-full bg-outline"></span><span class="font-label-badge text-label-badge text-outline font-bold">DRAFT</span>';
            badge.className = isPublished
                ? 'flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-tertiary/10 border border-tertiary/30'
                : 'flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-outline/10 border border-outline/20';
        }

        // Badge di settings panel
        if (settingsBadge) {
            settingsBadge.textContent = isPublished ? 'Published' : 'Draft';
            settingsBadge.className   = isPublished
                ? 'px-2 py-0.5 rounded-full bg-tertiary/10 text-tertiary font-label-badge text-label-badge font-semibold'
                : 'px-2 py-0.5 rounded-full bg-outline/10 text-outline font-label-badge text-label-badge font-semibold';
        }

        // Lock / unlock inputs
        inputs.forEach(el => { el.disabled = isPublished; });
        if (btnSave) btnSave.disabled = isPublished;

        // Lock / unlock tombol Soal Baru
        if (btnSoal) {
            btnSoal.disabled = isPublished;
            btnSoal.classList.toggle('opacity-50',           isPublished);
            btnSoal.classList.toggle('cursor-not-allowed',   isPublished);
            btnSoal.title = isPublished ? 'Tarik ke Draft untuk menambah soal' : '';
        }

        // Lock / unlock tombol delete di daftar soal saat published
        document.querySelectorAll('.soal-item button').forEach(b => {
            b.disabled = isPublished;
            b.classList.toggle('opacity-30', isPublished);
        });

        // Tombol hapus & reset di form soal
        const btnHapus = document.getElementById('btn-hapus');
        if (btnHapus) btnHapus.disabled = isPublished;
        const btnSimpan = document.getElementById('btn-simpan');
        if (btnSimpan) btnSimpan.disabled = isPublished;
    }

    // ─── DROPDOWN SIDEBAR ────────────────────────────────────────────────────
    function toggleKuisDropdown() {
        const dropdown = document.getElementById('kuis-nav-dropdown');
        const chevron  = document.getElementById('kuis-nav-chevron');
        const isOpen   = dropdown.classList.contains('flex');
        if (isOpen) {
            dropdown.classList.replace('flex','hidden');
            chevron.style.transform = '';
        } else {
            dropdown.classList.replace('hidden','flex');
            chevron.style.transform = 'rotate(180deg)';
        }
    }

    // stub — tidak dipakai lagi
    function toggleMateriDropdown() {}
    function toggleMateriSub() {}

    // ─── INIT ─────────────────────────────────────────────────────────────────
    // Init state
    onTipeChange();
    @if($settings && $settings->isPublished())
    // Kuis sudah published — lock semua edit controls saat load
    (function() {
        const btnSoal  = document.getElementById('btn-soal-baru');
        const btnSave  = document.getElementById('btn-save-settings');
        const btnSimpan = document.getElementById('btn-simpan');
        const btnHapus = document.getElementById('btn-hapus');
        if (btnSoal)  { btnSoal.disabled  = true; }
        if (btnSave)  { btnSave.disabled   = true; }
        if (btnSimpan) btnSimpan.disabled  = true;
        if (btnHapus)  btnHapus.disabled   = true;
        document.querySelectorAll('.soal-item button').forEach(b => {
            b.disabled = true; b.classList.add('opacity-30');
        });
    })();
    @endif
</script>

<!-- Modal Simulasi -->
<div id="modal-simulasi" class="hidden fixed inset-0 z-[100] bg-black/80 flex items-center justify-center p-4">
    <div class="relative w-full max-w-lg h-[85vh] bg-indigo-900 rounded-3xl overflow-hidden shadow-2xl flex flex-col">
        <button onclick="tutupSimulasi()" class="absolute top-4 right-4 text-white z-50 bg-black/50 p-2 rounded-full hover:bg-black">
            <span class="material-symbols-outlined text-white">close</span>
        </button>
        <div class="w-full h-full overflow-y-auto">
            <livewire:kuis-player :materi="$materi" />
        </div>
    </div>
</div>

<script>
    function bukaSimulasi() {
        document.getElementById('modal-simulasi').classList.remove('hidden');
    }
    function tutupSimulasi() {
        document.getElementById('modal-simulasi').classList.add('hidden');
        window.location.reload();
    }
</script>
</body>
</html>
