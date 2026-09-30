<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_dashboard" name="shell-type"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
            body { overscroll-behavior: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child { margin-bottom: 0 !important; }
        }
        ::-webkit-scrollbar { display: none; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    spacing: {
                        'space-2xs': '0.25rem',
                        'space-xs': '0.5rem',
                        'space-sm': '0.75rem',
                        'space-md': '1rem',
                        'space-lg': '1.5rem',
                        'space-xl': '2rem',
                        'space-2xl': '3rem',
                    },
                    colors: {
                    "on-primary-container": "#fdfcff",
                    "on-tertiary": "#ffffff",
                    "surface-container-highest": "#d3e4fe",
                    "on-primary": "#ffffff",
                    "inverse-surface": "#213145",
                    "inverse-primary": "#93ccff",
                    "surface-container": "#e5eeff",
                    "tertiary": "#006947",
                    "tertiary-container": "#00855b",
                    "primary": "#006194",
                    "inverse-on-surface": "#eaf1ff",
                    "on-surface-variant": "#3f4850",
                    "on-secondary-container": "#004666",
                    "outline": "#707881",
                    "primary-fixed-dim": "#93ccff",
                    "on-primary-fixed-variant": "#004b73",
                    "on-background": "#0b1c30",
                    "on-surface": "#0b1c30",
                    "surface-dim": "#cbdbf5",
                    "surface-tint": "#006398",
                    "surface-bright": "#f8f9ff",
                    "surface-variant": "#d3e4fe",
                    "error-container": "#ffdad6",
                    "outline-variant": "#bfc7d2",
                    "error": "#ba1a1a",
                    "on-primary-fixed": "#001d31",
                    "secondary": "#006591",
                    "on-secondary": "#ffffff",
                    "on-tertiary-fixed": "#002113",
                    "secondary-fixed-dim": "#89ceff",
                    "primary-fixed": "#cce5ff",
                    "background": "#f8f9ff",
                    "on-tertiary-fixed-variant": "#005236",
                    "primary-container": "#007bb9",
                    "tertiary-fixed": "#6ffbbe",
                    "surface-container-high": "#dce9ff",
                    "secondary-container": "#39b8fd",
                    "surface": "#f8f9ff",
                    "surface-container-low": "#eff4ff",
                    "secondary-fixed": "#c9e6ff",
                    "tertiary-fixed-dim": "#4edea3",
                    "on-error-container": "#93000a",
                    "on-error": "#ffffff",
                    "surface-container-lowest": "#ffffff",
                    "on-secondary-fixed": "#001e2f",
                    "on-secondary-fixed-variant": "#004c6e",
                    "on-tertiary-container": "#f5fff6"
                    },
                    fontFamily: {
                        "headline-md": ["Space Grotesk"],
                        "display-hero": ["Space Grotesk"],
                        "headline-xl": ["Space Grotesk"],
                        "body-md": ["Geist"],
                        "body-sm": ["Geist"],
                        "headline-lg": ["Space Grotesk"],
                        "code-editor": ["JetBrains Mono"],
                        "body-lg": ["Geist"],
                        "label-badge": ["JetBrains Mono"],
                        "code-inline": ["JetBrains Mono"],
                        "title-sm": ["Geist"]
                    },
                    fontSize: {
                        "headline-md": ["20px", { lineHeight: "28px", letterSpacing: "-0.01em", fontWeight: "500" }],
                        "display-hero": ["48px", { lineHeight: "56px", letterSpacing: "-0.03em", fontWeight: "700" }],
                        "headline-xl": ["36px", { lineHeight: "44px", letterSpacing: "-0.025em", fontWeight: "600" }],
                        "body-md": ["14px", { lineHeight: "22px", letterSpacing: "0em", fontWeight: "400" }],
                        "body-sm": ["12px", { lineHeight: "18px", letterSpacing: "0.005em", fontWeight: "400" }],
                        "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.015em", fontWeight: "600" }],
                        "code-editor": ["13px", { lineHeight: "22px", letterSpacing: "0em", fontWeight: "400" }],
                        "body-lg": ["18px", { lineHeight: "28px", letterSpacing: "0em", fontWeight: "400" }],
                        "label-badge": ["11px", { lineHeight: "14px", letterSpacing: "0.04em", fontWeight: "600" }],
                        "code-inline": ["12px", { lineHeight: "16px", letterSpacing: "-0.01em", fontWeight: "500" }],
                        "title-sm": ["16px", { lineHeight: "24px", letterSpacing: "-0.005em", fontWeight: "600" }]
                    }
                } // end extend
            }
        }
    </script>
    <title>Dasbor Guru - DebugTIK</title>
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface">
<aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="flex flex-col">
        <div class="h-16 px-space-lg flex items-center gap-space-xs bg-surface-container-lowest">
            <div class="flex flex-col leading-none ml-space-xs">
                <span class="font-headline-md text-headline-md font-bold tracking-tight text-on-surface">Debug<span class="text-primary">TIK</span></span>
                <span class="font-label-badge text-label-badge text-outline tracking-wider uppercase mt-space-2xs">Portal Guru</span>
            </div>
        </div>
        <div class="px-space-md py-space-sm">
            <div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col gap-space-2xs">
                <div class="flex items-center justify-between">
                    <span class="font-label-badge text-label-badge uppercase text-primary font-semibold">Kurikulum Merdeka</span>
                    <span class="h-2 w-2 rounded-full bg-tertiary"></span>
                </div>
                <span class="font-body-sm text-body-sm font-medium text-on-surface">Fase E & F (Kelas X - XI)</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Semester {{ $guru->semester ?? 'Ganjil' }} {{ $guru->tahun_ajaran ?? '2024/2025' }}</span>
            </div>
        </div>
        <nav class="flex flex-col gap-space-2xs px-space-md mt-space-xs">
            <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors" href="#" data-tab="dashboard">
                <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
                <span class="font-body-md text-body-md">Dasbor Utama</span>
            </a>

            {{-- ── Kelola Materi Belajar ── --}}
            <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors" href="#" data-tab="kelola-materi">
                <span class="material-symbols-outlined text-[20px]">library_books</span>
                <span class="font-body-md text-body-md">Kelola Materi Belajar</span>
            </a>

            {{-- ── Kelola Kuis (dropdown per materi) ── --}}
            <div>
                <button
                    onclick="toggleKuisDropdown()"
                    class="w-full flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors"
                    id="btn-kuis-dropdown"
                >
                    <span class="material-symbols-outlined text-[20px]">quiz</span>
                    <span class="font-body-md text-body-md flex-1 text-left">Kelola Kuis</span>
                    <span class="material-symbols-outlined text-[18px] transition-transform duration-200" id="kuis-nav-chevron">expand_more</span>
                </button>

                <div id="kuis-nav-dropdown" class="hidden flex-col gap-space-2xs mt-space-2xs pl-space-md">
                    @forelse($materiList as $m)
                    <a
                        href="{{ route('kuis.page', $m->id) }}"
                        class="flex items-center gap-space-xs px-space-sm py-space-xs rounded-lg text-on-surface-variant hover:bg-secondary/10 hover:text-secondary transition-colors"
                    >
                        <span class="material-symbols-outlined text-[14px] flex-shrink-0">quiz</span>
                        <span class="font-body-sm text-body-sm truncate flex-1">{{ $m->judul }}</span>
                        <div class="flex items-center gap-space-2xs flex-shrink-0">
                            <span class="font-label-badge text-label-badge text-outline">{{ $m->kuis->count() }}</span>
                            @if($m->kuisSettings?->isPublished())
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <span class="px-space-sm py-space-xs font-body-sm text-body-sm text-outline italic">Belum ada materi</span>
                    @endforelse
                </div>
            </div>

            <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors" href="#" data-tab="rekap">
                <span class="material-symbols-outlined text-[20px]">assessment</span>
                <span class="font-body-md text-body-md">Rekap Nilai & Evaluasi</span>
            </a>
            <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors" href="#" data-tab="pengaturan">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                <span class="font-body-md text-body-md">Pengaturan</span>
            </a>
        </nav>
    </div>
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

<div class="pl-72 min-w-0 overflow-hidden">
    <header class="fixed top-0 left-72 right-0 h-16 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-40 px-space-lg flex items-center justify-between">
        <div class="flex items-center gap-space-md flex-1 max-w-xl">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-space-sm top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                <input class="w-full h-10 pl-10 pr-space-md rounded-xl bg-surface-container-low text-on-surface placeholder:text-outline font-body-sm text-body-sm focus:outline-none focus:bg-surface-container-lowest shadow-[0_1px_8px_rgba(0,0,0,0.04)] transition-all" placeholder="Cari modul, sesi lab kode, atau nama siswa..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-space-md">
            <div class="hidden lg:flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-surface-container">
                <span class="material-symbols-outlined text-primary text-[16px]">school</span>
                <span class="font-label-badge text-label-badge text-on-surface font-medium">Kurikulum Merdeka 2024</span>
                <span class="text-outline text-label-badge">•</span>
                <span class="font-label-badge text-label-badge text-primary font-bold">Sem. Ganjil</span>
            </div>
            <button class="relative w-10 h-10 rounded-xl bg-surface-container-low hover:bg-surface-container hover:text-on-surface text-on-surface-variant flex items-center justify-center transition-colors" type="button">
                <span class="material-symbols-outlined text-[20px]">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-error"></span>
            </button>
            <div class="flex items-center gap-space-sm pl-space-2xs">
                <div class="flex flex-col text-right leading-none">
                    <span class="font-title-sm text-title-sm text-on-surface font-semibold">{{ $guru->name ?? 'Guru' }}</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">{{ $guru->mata_pelajaran ?? 'Guru TIK' }}</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center overflow-hidden">
                    @if($guru->foto_profil)
                        <img src="{{ Storage::disk('public')->url($guru->foto_profil) }}" class="w-full h-full object-cover"/>
                    @else
                        <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="w-full pt-16 bg-surface min-h-screen px-space-lg py-space-lg">
        <!-- Dashboard View -->
        <div id="view-dashboard" class="view-section">
            @include('components.dashboard.profile-banner')
            @include('components.dashboard.stats-grid')
            
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg">
                @include('components.dashboard.progress-students')
                @include('components.dashboard.manage-materials')
            </div>
        </div>

        <!-- Kelola Materi View -->
        <div id="view-kelola-materi" class="view-section hidden">
            <div class="flex flex-col w-full gap-space-lg">
                <!-- Metrics -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md mb-space-xl">
                    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-space-sm">
                            <span class="font-label-badge text-label-badge uppercase text-outline">Modul Terbit</span>
                            <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-[18px]">menu_book</span>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-2xs">
                                <span class="text-on-surface leading-none" style="font-size: 48px; line-height: 56px; letter-spacing: -0.03em; font-weight: 700; font-family: 'Space Grotesk';">{{ $metrics['total_modul'] ?? 0 }}</span>
                                <span class="font-body-sm text-body-sm text-tertiary font-semibold">Aktif</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">
                                HTML, CSS, JS Dasar (Kurikulum Inti)
                            </p>
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-space-sm">
                            <span class="font-label-badge text-label-badge uppercase text-outline">Kuis Terhubung</span>
                            <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-[18px]">quiz</span>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-2xs">
                                <span class="text-on-surface leading-none" style="font-size: 48px; line-height: 56px; letter-spacing: -0.03em; font-weight: 700; font-family: 'Space Grotesk';">{{ $metrics['total_kuis'] ?? 0 }}</span>
                                <span class="font-body-sm text-body-sm text-tertiary font-semibold">Aktif</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">
                                Kuis interaktif dengan feedback otomatis
                            </p>
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-space-sm">
                            <span class="font-label-badge text-label-badge uppercase text-outline">Lab Praktik</span>
                            <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-tertiary-container">
                                <span class="material-symbols-outlined text-[18px]">terminal</span>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-2xs">
                                <span class="text-on-surface leading-none" style="font-size: 48px; line-height: 56px; letter-spacing: -0.03em; font-weight: 700; font-family: 'Space Grotesk';">{{ $metrics['total_lab'] ?? 0 }}</span>
                                <span class="font-body-sm text-body-sm text-tertiary font-semibold">Aktif</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">
                                Sesi praktik coding dengan live compiler
                            </p>
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-space-sm">
                            <span class="font-label-badge text-label-badge uppercase text-outline">Siswa Aktif</span>
                            <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary-container">
                                <span class="material-symbols-outlined text-[18px]">people</span>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-2xs">
                                <span class="text-on-surface leading-none" style="font-size: 48px; line-height: 56px; letter-spacing: -0.03em; font-weight: 700; font-family: 'Space Grotesk';">{{ $metrics['siswa_online'] ?? 0 }}</span>
                                <span class="font-body-sm text-body-sm text-tertiary font-semibold">Online</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">
                                Siswa sedang aktif belajar saat ini
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Materi Grid -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg">
                    <div class="flex items-center justify-between mb-space-lg">
                        <h2 class="font-headline-md text-headline-md font-bold text-on-surface">Daftar Materi Belajar</h2>
                        <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded-xl bg-primary hover:bg-primary-container text-on-primary font-title-sm text-title-sm shadow-md transition-all" type="button" onclick="toggleModal(true)">
                            <span class="material-symbols-outlined text-[18px]">add_circle</span>
                            Tambah Materi
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg">
                        @foreach($materiList as $materi)
                        <div class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-space-md">
                                <div class="flex items-center gap-space-xs">
                                    @php
                                        $levelColors = [
                                            'Pemula' => 'bg-success/20 text-success',
                                            'Menengah' => 'bg-warning/20 text-warning',
                                            'Lanjutan' => 'bg-error/20 text-error'
                                        ];
                                        $levelColor = $levelColors[$materi->level] ?? 'bg-surface-container text-on-surface';
                                    @endphp
                                    <span class="px-space-xs py-0.5 rounded-full bg-surface-container {{ str_replace(['success', 'warning', 'error'], ['text-success', 'text-warning', 'text-error'], $levelColor) }} font-label-badge text-label-badge font-semibold uppercase">
                                        {{ $materi->level }}
                                    </span>
                                    <span class="px-space-xs py-0.5 rounded-full bg-primary/10 text-primary font-label-badge text-label-badge font-semibold">
                                        {{ $materi->kategori ?? 'Umum' }}
                                    </span>
                                </div>
                                <button class="text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">more_horiz</span>
                                </button>
                            </div>

                            <h3 class="font-title-sm text-title-sm font-bold text-on-surface mb-space-xs line-clamp-2">{{ $materi->judul }}</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md line-clamp-2">{{ $materi->deskripsi }}</p>

                            <div class="mt-auto pt-space-md border-t border-surface-container-high flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <div class="flex items-center gap-space-1 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[16px]">quiz</span>
                                        <span class="font-body-sm text-body-sm">{{ $materi->kuis->count() ?? 0 }}</span>
                                    </div>
                                    <div class="flex items-center gap-space-1 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[16px]">terminal</span>
                                        <span class="font-body-sm text-body-sm">{{ $materi->labPraktik->count() ?? 0 }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-space-sm">
                                    <button class="px-space-xs py-1 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" title="Edit" onclick="openEditorModal('{{ $materi->id }}', '{{ $materi->id_materi }}', '{{ addslashes($materi->judul) }}', '{{ $materi->kategori }}', '{{ $materi->level }}', {{ $materi->estimasi_waktu }}, '{{ addslashes($materi->deskripsi) }}')">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </button>
                                    <a href="{{ route('kuis.page', $materi->id) }}" class="px-space-xs py-1 rounded-lg bg-surface-container hover:bg-secondary/10 hover:text-secondary text-on-surface-variant transition-colors" title="Kelola Soal Kuis">
                                        <span class="material-symbols-outlined text-[16px]">quiz</span>
                                    </a>
                                    <button class="px-space-xs py-1 rounded-lg bg-surface-container hover:bg-tertiary-container hover:text-on-tertiary-container transition-colors" title="Tambah Lab" onclick="toggleLabModal(true, '{{ $materi->id }}')">
                                        <span class="material-symbols-outlined text-[16px]">terminal</span>
                                    </button>
                                    <button class="px-space-xs py-1 rounded-lg bg-surface-container hover:bg-error-container hover:text-error transition-colors" title="Hapus" onclick="deleteMateri('{{ $materi->id }}')">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- ERD Panel -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg">
                    <h2 class="font-headline-md text-headline-md font-bold text-on-surface mb-space-lg">Database Schema</h2>
                    <div class="bg-[#0F172A] rounded-xl p-space-md overflow-x-auto">
                        <div class="flex flex-col gap-space-sm font-code-editor text-code-editor">
                            <div class="flex items-center gap-space-xs text-sky-400"><span class="text-slate-500 select-none">ERD</span><span class="text-slate-300">// Database Relationships</span></div>
                            <div class="flex flex-col gap-space-xs pl-space-lg">
                                <div class="text-emerald-400">user</div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- id</span><span class="text-sky-400">PK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- nama</span><span class="text-sky-400">FK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- email</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs text-slate-400">
                                <span>1</span>
                                <span class="w-8 border-t border-slate-600"></span>
                                <span class="text-slate-500">●━━━━━━━━━━━━━━━━━━━━━━●</span>
                                <span class="w-8 border-t border-slate-600"></span>
                                <span> N</span>
                            </div>
                            <div class="flex flex-col gap-space-xs pl-space-lg">
                                <div class="text-amber-400">materi_belajar</div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- id</span><span class="text-sky-400">PK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- guru_id</span><span class="text-sky-400">FK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- judul</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- level</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs text-slate-400">
                                <span>1</span>
                                <span class="w-8 border-t border-slate-600"></span>
                                <span class="text-slate-500">●━━━━━━━━━━━━━━━━━━━━━━●</span>
                                <span class="w-8 border-t border-slate-600"></span>
                                <span> N</span>
                            </div>
                            <div class="flex flex-col gap-space-xs pl-space-lg">
                                <div class="text-emerald-400">kuis_tik</div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- id</span><span class="text-sky-400">PK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- materi_id</span><span class="text-sky-400">FK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- soal_json</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-space-xs pl-space-lg">
                                <div class="text-emerald-400">lab_praktik</div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- id</span><span class="text-sky-400">PK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- materi_id</span><span class="text-sky-400">FK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- deskripsi</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs text-slate-400">
                                <span>1</span>
                                <span class="w-8 border-t border-slate-600"></span>
                                <span class="text-slate-500">●━━━━━━━━━━━━━━━━━━━━━━●</span>
                                <span class="w-8 border-t border-slate-600"></span>
                                <span> N</span>
                            </div>
                            <div class="flex flex-col gap-space-xs pl-space-lg">
                                <div class="text-amber-400">progress_belajar</div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- id</span><span class="text-sky-400">PK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- user_id</span><span class="text-sky-400">FK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- materi_id</span><span class="text-sky-400">FK</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- nilai_kuis</span>
                                </div>
                                <div class="flex items-center gap-space-xs pl-space-lg text-slate-400">
                                    <span>- nilai_lab</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Rekap Nilai View -->
        <div id="view-rekap" class="view-section hidden">
            <!-- Header Section with Action Group -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-sm mb-space-lg">
                <div class="flex flex-col gap-space-2xs">
                    <div class="flex items-center gap-space-xs">
                        <span class="px-space-xs py-0.5 rounded-full bg-surface-container text-primary font-label-badge text-label-badge">ERD_EVALUATION_SCHEMA_V2</span>
                        <span class="text-outline font-label-badge text-label-badge">•</span>
                        <span class="font-label-badge text-label-badge text-outline">SMK TI GARUDA TEKNIKA</span>
                    </div>
                    <h1 class="font-headline-xl text-headline-xl font-bold tracking-tight text-on-surface">Rekap Nilai & Evaluasi Pembelajaran TIK</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-3xl">
                        Evaluasi Hasil Belajar Siswa Berdasarkan Progres Materi, Nilai Kuis (<code class="font-code-inline text-code-inline text-primary bg-surface-container-low px-1 py-0.5 rounded">nilai_kuis</code>), dan Skor Debug Lab (<code class="font-code-inline text-code-inline text-primary bg-surface-container-low px-1 py-0.5 rounded">nilai_lab</code>).
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-space-sm">
                    <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface font-title-sm text-title-sm shadow-sm transition-all" type="button">
                        <span class="material-symbols-outlined text-[18px] text-primary">download</span>
                        <span>Ekspor Rekap (Excel/PDF)</span>
                    </button>
                    <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded-xl bg-primary hover:bg-primary-container text-on-primary font-title-sm text-title-sm shadow-md transition-all" type="button">
                        <span class="material-symbols-outlined text-[18px]">send</span>
                        <span>Kirim Raport ke Akun Siswa</span>
                    </button>
                </div>
            </div>

            <!-- Main ERD Table Data: Rekap Nilai Siswa -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse" id="evaluationTable">
                        <thead>
                            <tr class="bg-surface-container-low text-on-surface-variant font-label-badge text-label-badge uppercase tracking-wider">
                                <th class="py-space-md px-space-lg">id_siswa</th>
                                <th class="py-space-md px-space-md">nama_siswa</th>
                                <th class="py-space-md px-space-md">learning_path</th>
                                <th class="py-space-md px-space-md">progress_materi</th>
                                <th class="py-space-md px-space-md text-right">nilai_kuis</th>
                                <th class="py-space-md px-space-md text-right">nilai_lab</th>
                                <th class="py-space-md px-space-md text-center">total_error_kode</th>
                                <th class="py-space-md px-space-md">status_kelulusan</th>
                                <th class="py-space-md px-space-lg text-right">Aksi Evaluasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-0 text-on-surface font-body-md text-body-md" id="tableBody">
                            @foreach($progressSiswa as $progress)
                            <tr class="hover:bg-surface-container-low/60 transition-colors group">
                                <td class="py-space-md px-space-lg font-code-inline text-code-inline font-bold text-primary">
                                    SIS-{{ str_pad($progress->user_id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="py-space-md px-space-md">
                                    <div class="flex flex-col">
                                        <span class="font-title-sm text-title-sm font-semibold text-on-surface">{{ $progress->user->nama ?? 'Siswa' }}</span>
                                        <span class="font-label-badge text-label-badge text-outline">Kelas X RPL</span>
                                    </div>
                                </td>
                                <td class="py-space-md px-space-md">
                                    <span class="px-space-xs py-1 rounded bg-surface-container text-on-surface-variant font-body-sm text-body-sm">
                                        {{ $progress->materi->kategori ?? 'Web Dasar' }}
                                    </span>
                                </td>
                                <td class="py-space-md px-space-md">
                                    <div class="flex items-center gap-space-xs">
                                        <div class="w-24 bg-surface-container-high h-2 rounded-full overflow-hidden">
                                            <div class="bg-tertiary h-full rounded-full" style="width: 100%"></div>
                                        </div>
                                        <span class="font-label-badge text-label-badge font-bold text-tertiary">100% Selesai</span>
                                    </div>
                                </td>
                                <td class="py-space-md px-space-md text-right font-code-inline text-code-inline font-semibold">
                                    {{ $progress->nilai_kuis ?? '-' }}
                                </td>
                                <td class="py-space-md px-space-md text-right font-code-inline text-code-inline font-bold text-tertiary">
                                    {{ $progress->nilai_lab ?? '-' }}
                                </td>
                                <td class="py-space-md px-space-md text-center">
                                    <span class="inline-flex items-center justify-center px-space-xs py-0.5 rounded-full bg-surface-container font-code-inline text-code-inline text-on-surface">
                                        0 kali
                                    </span>
                                </td>
                                <td class="py-space-md px-space-md">
                                    <span class="inline-flex items-center gap-1 px-space-xs py-1 rounded-full bg-tertiary/10 text-tertiary font-label-badge text-label-badge uppercase font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                        Lulus
                                    </span>
                                </td>
                                <td class="py-space-md px-space-lg text-right">
                                    <button class="inline-flex items-center gap-space-2xs px-space-sm py-1.5 rounded-xl bg-surface-container-low hover:bg-primary hover:text-on-primary text-on-surface-variant text-body-sm font-medium transition-all shadow-sm" type="button">
                                        <span class="material-symbols-outlined text-[16px]">history_edu</span>
                                        <span>Buka Detail</span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pengaturan View -->
        <div id="view-pengaturan" class="view-section hidden">
            <div class="max-w-2xl mx-auto flex flex-col gap-space-lg">

                {{-- ── Header ── --}}
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
                                <span class="font-title-sm text-title-sm font-bold text-on-surface" id="display-name">{{ $guru->name }}</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $guru->email }}</span>
                                <span class="font-label-badge text-label-badge text-outline uppercase">{{ $guru->role === 'teacher' ? 'Guru Pengajar' : 'Lab Admin' }}</span>
                            </div>
                        </div>

                        {{-- Grid field --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-badge text-label-badge uppercase text-outline">Nama Lengkap <span class="text-error">*</span></label>
                                <input id="pg-name" name="name" type="text" required
                                    value="{{ $guru->name }}"
                                    class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary"/>
                            </div>
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-badge text-label-badge uppercase text-outline">NIP <span class="text-error">*</span></label>
                                <input id="pg-nip" name="nip" type="text" required
                                    value="{{ $guru->nip }}"
                                    class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-code-inline text-code-inline text-on-surface focus:outline-none focus:border-primary"/>
                            </div>
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-badge text-label-badge uppercase text-outline">Nama Sekolah</label>
                                <input id="pg-sekolah" name="sekolah" type="text"
                                    value="{{ $guru->sekolah }}"
                                    class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-primary"/>
                            </div>
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-badge text-label-badge uppercase text-outline">Mata Pelajaran</label>
                                <input id="pg-mapel" name="mata_pelajaran" type="text"
                                    value="{{ $guru->mata_pelajaran ?? 'Teknologi Informasi & Komunikasi' }}"
                                    class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-primary"/>
                            </div>
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-badge text-label-badge uppercase text-outline">No. HP</label>
                                <input id="pg-nohp" name="no_hp" type="text"
                                    value="{{ $guru->no_hp }}"
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
                            <input id="pg-tahun" name="tahun_ajaran" type="text"
                                value="{{ $guru->tahun_ajaran ?? '2024/2025' }}"
                                placeholder="2024/2025"
                                form="form-profil"
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

                {{-- ── CARD: Ganti Password ── --}}
                <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
                    <div class="bg-surface-container-low px-space-lg py-space-md border-b border-outline-variant/20 flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-tertiary text-[20px]">lock</span>
                        <h3 class="font-title-sm text-title-sm font-bold text-on-surface">Ganti Password</h3>
                    </div>
                    <form id="form-password" onsubmit="gantiPassword(event)" class="p-space-lg flex flex-col gap-space-md">
                        <div class="flex flex-col gap-space-2xs">
                            <label class="font-label-badge text-label-badge uppercase text-outline">Password Lama <span class="text-error">*</span></label>
                            <div class="relative">
                                <input id="pw-lama" type="password" required placeholder="Masukkan password saat ini"
                                    class="w-full h-10 pl-space-sm pr-10 rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-tertiary"/>
                                <button type="button" onclick="togglePw('pw-lama','eye-lama')"
                                    class="absolute right-3 top-2.5 text-outline hover:text-on-surface transition-colors">
                                    <span class="material-symbols-outlined text-[18px]" id="eye-lama">visibility</span>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-badge text-label-badge uppercase text-outline">Password Baru <span class="text-error">*</span></label>
                                <div class="relative">
                                    <input id="pw-baru" type="password" required placeholder="Min. 8 karakter"
                                        class="w-full h-10 pl-space-sm pr-10 rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-tertiary"/>
                                    <button type="button" onclick="togglePw('pw-baru','eye-baru')"
                                        class="absolute right-3 top-2.5 text-outline hover:text-on-surface transition-colors">
                                        <span class="material-symbols-outlined text-[18px]" id="eye-baru">visibility</span>
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-badge text-label-badge uppercase text-outline">Konfirmasi Password <span class="text-error">*</span></label>
                                <div class="relative">
                                    <input id="pw-konfirm" type="password" required placeholder="Ulangi password baru"
                                        class="w-full h-10 pl-space-sm pr-10 rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-tertiary"/>
                                    <button type="button" onclick="togglePw('pw-konfirm','eye-konfirm')"
                                        class="absolute right-3 top-2.5 text-outline hover:text-on-surface transition-colors">
                                        <span class="material-symbols-outlined text-[18px]" id="eye-konfirm">visibility</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end pt-space-xs border-t border-outline-variant/20">
                            <button type="submit" id="btn-ganti-pw"
                                class="flex items-center gap-space-xs px-space-xl py-space-sm rounded-xl bg-tertiary text-on-tertiary font-title-sm text-title-sm font-semibold hover:opacity-90 transition-opacity shadow-sm active:scale-95">
                                <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                                Ubah Password
                            </button>
                        </div>
                    </form>
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
    </main>
</div>

<!-- ===================== MODAL: TAMBAH/EDIT MATERI ===================== -->
<div class="fixed inset-0 z-[100] bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-space-md" id="materi-modal">
    <div class="bg-surface-container-lowest rounded-2xl max-w-xl w-full p-space-lg shadow-xl flex flex-col gap-space-md">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-space-xs">
                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">dataset</span>
                </div>
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface font-bold" id="modal-title">+ Tambah Materi Belajar Baru</h3>
                    <span class="font-body-sm text-body-sm text-outline">Entitas: `materi_belajar`</span>
                </div>
            </div>
            <button class="w-8 h-8 rounded-full bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface-variant transition-colors" onclick="toggleModal(false)" type="button">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <form class="flex flex-col gap-space-md mt-space-2xs" id="materi-form" onsubmit="handleMateriSubmit(event)">
            <input type="hidden" id="input-materi-db-id" value=""/>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">ID Materi (PK) <span class="text-error">*</span></label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm" id="input-id-materi" placeholder="Contoh: MAT-JS-04" required type="text"/>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Level Materi <span class="text-error">*</span></label>
                    <select class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm cursor-pointer" id="input-level-materi">
                        <option value="Pemula">Pemula (Fase E - Kelas X)</option>
                        <option value="Menengah">Menengah (Fase F - Kelas XI)</option>
                        <option value="Lanjutan">Lanjutan (Fase F - Kelas XII)</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Judul Materi Belajar <span class="text-error">*</span></label>
                <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface shadow-sm" id="input-judul-materi" placeholder="Contoh: JavaScript Lanjutan: DOM Manipulation & Event Listener" required type="text"/>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Kategori Modul <span class="text-error">*</span></label>
                    <select class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm cursor-pointer" id="input-kategori">
                        <option value="HTML Dasar">HTML Dasar</option>
                        <option value="CSS Dasar">CSS Dasar</option>
                        <option value="JS Dasar">JavaScript Dasar</option>
                        <option value="Web Responsif">Web Responsif (Flex & Grid)</option>
                    </select>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Estimasi Waktu (Menit) <span class="text-error">*</span></label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm" id="input-estimasi-waktu" max="240" min="10" required type="number" value="45"/>
                </div>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Deskripsi Singkat <span class="text-error">*</span></label>
                <textarea class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm resize-none" id="input-deskripsi" rows="2" placeholder="Deskripsi singkat materi ini..." required></textarea>
            </div>

            <div class="p-space-sm rounded-xl bg-surface-container flex items-center justify-between">
                <div class="flex items-center gap-space-xs text-on-surface-variant font-body-sm text-body-sm">
                    <span class="material-symbols-outlined text-[18px] text-primary">person</span>
                    <span>Guru Pengampu:</span>
                </div>
                <span class="font-code-inline text-code-inline font-bold text-on-surface">{{ $guru->name ?? 'Guru' }}</span>
            </div>

            {{-- ── ATTACHMENT ZONE ── --}}
            <div class="flex flex-col gap-space-xs" id="attachment-zone-wrapper">
                <label class="font-label-badge text-label-badge uppercase text-outline">Lampiran Materi (PDF / Gambar)</label>

                {{-- Drop zone --}}
                <div
                    id="materi-drop-zone"
                    class="relative flex flex-col items-center justify-center gap-space-xs rounded-xl border-2 border-dashed border-outline-variant/50 bg-surface-container-low hover:border-primary hover:bg-primary/5 transition-all cursor-pointer p-space-lg text-center"
                    onclick="document.getElementById('materi-file-input').click()"
                    ondragover="event.preventDefault(); this.classList.add('border-primary','bg-primary/5')"
                    ondragleave="this.classList.remove('border-primary','bg-primary/5')"
                    ondrop="handleMateriDrop(event)"
                >
                    <span class="material-symbols-outlined text-outline text-[32px]">cloud_upload</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Drag & drop file di sini, atau <span class="text-primary font-semibold">klik untuk pilih</span></span>
                    <span class="font-label-badge text-label-badge text-outline">PDF, JPG, PNG, DOCX · Maks 20 MB per file</span>
                    <input type="file" id="materi-file-input" class="hidden" multiple accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx,.ppt,.pptx" onchange="handleMateriFileSelect(this.files)"/>
                </div>

                {{-- Preview list file yang dipilih (sebelum upload) --}}
                <div id="materi-file-preview" class="hidden flex-col gap-space-xs mt-space-xs"></div>

                {{-- Attachments yang sudah tersimpan (mode edit) --}}
                <div id="materi-saved-attachments" class="hidden flex-col gap-space-xs"></div>
            </div>

            <div class="flex items-center justify-end gap-space-sm pt-space-sm border-t border-surface-container">
                <button class="px-space-md py-space-sm rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-body-sm text-body-sm font-medium transition-colors" onclick="toggleModal(false)" type="button">Batal</button>
                <button class="px-space-lg py-space-sm rounded-xl bg-primary hover:bg-primary-container text-on-primary font-body-sm text-body-sm font-semibold transition-all shadow-sm active:scale-95" type="submit" id="btn-simpan-materi">Simpan Materi</button>
            </div>
        </form>
    </div>
</div>

<!-- ===================== MODAL: TAMBAH LAB PRAKTIK ===================== -->
<div class="fixed inset-0 z-[100] bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-space-md" id="lab-modal">
    <div class="bg-surface-container-lowest rounded-2xl max-w-2xl w-full p-space-lg shadow-xl flex flex-col gap-space-md max-h-[90vh] overflow-y-auto">
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
            <button class="w-8 h-8 rounded-full bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface-variant transition-colors" onclick="toggleLabModal(false)" type="button">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <form class="flex flex-col gap-space-md mt-space-2xs" id="lab-form" onsubmit="handleLabSubmit(event)">
            <input type="hidden" id="lab-materi-id" value=""/>
            <input type="hidden" id="lab-db-id" value=""/>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">ID Lab (PK) <span class="text-error">*</span></label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm" id="lab-id-lab" placeholder="Contoh: LAB-CSS-02" required type="text"/>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Tingkat Kesulitan <span class="text-error">*</span></label>
                    <select class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm cursor-pointer" id="lab-kesulitan">
                        <option value="mudah">Mudah</option>
                        <option value="sedang">Sedang</option>
                        <option value="sulit">Sulit</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Deskripsi Kasus Bug <span class="text-error">*</span></label>
                <textarea class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm resize-none" id="lab-deskripsi" rows="2" required placeholder="Deskripsikan bug yang harus diperbaiki siswa..."></textarea>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Kode Soal Awal (dengan bug) <span class="text-error">*</span></label>
                <textarea class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm resize-none" id="lab-kode-awal" rows="4" required placeholder="Tulis kode yang mengandung bug..."></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Bug Target <span class="text-error">*</span></label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm" id="lab-bug-target" required placeholder="Baris/kode yang mengandung bug" type="text"/>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Poin Maksimal <span class="text-error">*</span></label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm" id="lab-poin-max" min="10" max="200" type="number" value="100"/>
                </div>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">Solusi Fix (kode yang benar) <span class="text-error">*</span></label>
                <textarea class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm resize-none" id="lab-solusi" rows="3" required placeholder="Kode yang sudah diperbaiki..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-space-sm pt-space-sm border-t border-surface-container">
                <button class="px-space-md py-space-sm rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-body-sm text-body-sm font-medium transition-colors" onclick="toggleLabModal(false)" type="button">Batal</button>
                <button class="px-space-lg py-space-sm rounded-xl bg-tertiary hover:opacity-90 text-on-tertiary font-body-sm text-body-sm font-semibold transition-all shadow-sm active:scale-95" type="submit" id="btn-simpan-lab">Simpan Lab</button>
            </div>
        </form>
    </div>
</div>

<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

    function apiHeaders() {
        return { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF };
    }

    // ─── DROPDOWN KELOLA KUIS (sidebar) ──────────────────────────────────────
    function toggleKuisDropdown() {
        const dropdown = document.getElementById('kuis-nav-dropdown');
        const chevron  = document.getElementById('kuis-nav-chevron');
        const btn      = document.getElementById('btn-kuis-dropdown');
        const isOpen   = dropdown.classList.contains('flex');

        if (isOpen) {
            dropdown.classList.replace('flex','hidden');
            chevron.style.transform = '';
            btn.classList.remove('bg-surface-container-high','text-on-surface');
        } else {
            dropdown.classList.replace('hidden','flex');
            chevron.style.transform = 'rotate(180deg)';
            btn.classList.add('bg-surface-container-high','text-on-surface');
        }
    }

    // ─── DROPDOWN KELOLA MATERI (tetap ada untuk backward compat) ────────────
    function toggleMateriDropdown() {}
    function toggleMateriSub() {}

    // ─── TAB NAVIGATION ───────────────────────────────────────────────────────
    function switchTab(tabName) {
        document.querySelectorAll('[data-tab]').forEach(t => {
            t.classList.remove('bg-primary-container', 'text-on-primary-container', 'font-semibold');
            t.classList.add('text-on-surface-variant', 'hover:bg-surface-container-high', 'hover:text-on-surface');
        });

        const activeTab = document.querySelector(`[data-tab="${tabName}"]`);
        if (activeTab) {
            activeTab.classList.remove('text-on-surface-variant', 'hover:bg-surface-container-high', 'hover:text-on-surface');
            activeTab.classList.add('bg-primary-container', 'text-on-primary-container', 'font-semibold');
        }

        document.querySelectorAll('.view-section').forEach(v => v.classList.add('hidden'));

        const viewId = tabName === 'kelola-materi' ? 'view-kelola-materi' : `view-${tabName}`;
        document.getElementById(viewId)?.classList.remove('hidden');

        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.pushState({}, '', url);
    }

    document.querySelectorAll('[data-tab]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            switchTab(this.getAttribute('data-tab'));
        });
    });

    const tabParam = new URLSearchParams(window.location.search).get('tab');
    switchTab(tabParam || 'dashboard');

    // ─── TOAST NOTIFICATION ───────────────────────────────────────────────────
    function showToast(message, type = 'success') {
        const existing = document.getElementById('toast');
        if (existing) existing.remove();

        const colors = type === 'success'
            ? 'bg-tertiary-container text-on-tertiary-container'
            : 'bg-error-container text-on-error-container';

        const icon = type === 'success' ? 'check_circle' : 'error';

        const toast = document.createElement('div');
        toast.id = 'toast';
        toast.className = `fixed bottom-6 right-6 z-[200] flex items-center gap-2 px-4 py-3 rounded-xl shadow-lg font-body-sm text-body-sm font-medium ${colors} transition-all`;
        toast.innerHTML = `<span class="material-symbols-outlined text-[18px]">${icon}</span>${message}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // ─── MODAL MATERI ─────────────────────────────────────────────────────────
    function toggleModal(open) {
        const modal = document.getElementById('materi-modal');
        if (!modal) return;
        if (open) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('modal-title').innerText = '+ Tambah Materi Belajar Baru';
            document.getElementById('input-materi-db-id').value = '';
            document.getElementById('materi-form').reset();
            _materiPendingFiles = [];
            renderMateriFilePreview();
            const saved = document.getElementById('materi-saved-attachments');
            if (saved) { saved.innerHTML = ''; saved.classList.add('hidden'); }
        }
    }

    function openEditorModal(dbId, idMateri, title, category, level, time, deskripsi) {
        document.getElementById('modal-title').innerText = 'Edit Materi: ' + idMateri;
        document.getElementById('input-materi-db-id').value = dbId;
        document.getElementById('input-id-materi').value = idMateri;
        document.getElementById('input-judul-materi').value = title;
        document.getElementById('input-kategori').value = category;
        document.getElementById('input-level-materi').value = level;
        document.getElementById('input-estimasi-waktu').value = time;
        document.getElementById('input-deskripsi').value = deskripsi;
        // Reset pending files
        _materiPendingFiles = [];
        renderMateriFilePreview();
        // Load saved attachments
        fetch(`/api/attachment/materi/${dbId}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
            .then(r => r.json())
            .then(d => { if (d.success) renderSavedAttachments(d.data, dbId); });
        toggleModal(true);
    }

    // ─── DUPLICATE CHECK HELPERS ──────────────────────────────────────────────
    let _debounceTimer = null;
    function debounceCheck(fn, ms = 500) {
        clearTimeout(_debounceTimer);
        _debounceTimer = setTimeout(fn, ms);
    }

    function setFieldState(inputEl, state, msg = '') {
        // state: 'ok' | 'error' | 'loading' | ''
        let hint = inputEl.parentElement.querySelector('.dup-hint');
        if (!hint) {
            hint = document.createElement('span');
            hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs';
            inputEl.parentElement.appendChild(hint);
        }
        inputEl.classList.remove('ring-2','ring-error','ring-tertiary');
        hint.textContent = msg;
        if (state === 'error') {
            inputEl.classList.add('ring-2','ring-error');
            hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs text-error';
        } else if (state === 'ok') {
            inputEl.classList.add('ring-2','ring-tertiary');
            hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs text-tertiary';
        } else {
            hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs text-outline';
        }
    }

    function checkMateriDuplicate(field, value, excludeId, inputEl) {
        if (!value) { setFieldState(inputEl, '', ''); return; }
        setFieldState(inputEl, 'loading', 'Memeriksa...');
        const params = new URLSearchParams({ field, value });
        if (excludeId) params.append('exclude_id', excludeId);
        fetch(`/api/kelola-materi/check?${params}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
            .then(r => r.json())
            .then(d => {
                if (d.duplicate) setFieldState(inputEl, 'error', field === 'id_materi' ? '✕ ID sudah digunakan' : '✕ Judul sudah ada');
                else setFieldState(inputEl, 'ok', '✓ Tersedia');
            })
            .catch(() => setFieldState(inputEl, '', ''));
    }

    function checkSoalDuplicate(value, excludeId, inputEl) {
        if (!value) { setFieldState(inputEl, '', ''); return; }
        setFieldState(inputEl, 'loading', 'Memeriksa...');
        const params = new URLSearchParams({ id_soal: value });
        if (excludeId) params.append('exclude_id', excludeId);
        fetch(`/api/kuis/check-id?${params}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
            .then(r => r.json())
            .then(d => {
                if (d.duplicate) setFieldState(inputEl, 'error', '✕ ID soal sudah digunakan');
                else setFieldState(inputEl, 'ok', '✓ Tersedia');
            })
            .catch(() => setFieldState(inputEl, '', ''));
    }

    function handleMateriSubmit(e) {
        e.preventDefault();
        const dbId   = document.getElementById('input-materi-db-id').value;
        const isEdit = dbId !== '';

        // Blok submit kalau ada field yang masih error
        const hasError = ['input-id-materi','input-judul-materi'].some(id => {
            const el = document.getElementById(id);
            return el && el.classList.contains('ring-error');
        });
        if (hasError) { showToast('Perbaiki duplikasi terlebih dahulu', 'error'); return; }

        const body = {
            id_materi:      document.getElementById('input-id-materi').value,
            judul:          document.getElementById('input-judul-materi').value,
            kategori:       document.getElementById('input-kategori').value,
            level:          document.getElementById('input-level-materi').value,
            estimasi_waktu: document.getElementById('input-estimasi-waktu').value,
            deskripsi:      document.getElementById('input-deskripsi').value,
        };

        const url    = isEdit ? `/api/kelola-materi/${dbId}` : '/api/kelola-materi';
        const method = isEdit ? 'PUT' : 'POST';

        fetch(url, { method, headers: apiHeaders(), body: JSON.stringify(body) })
            .then(r => r.json())
            .then(async data => {
                if (data.success) {
                    // Upload attachment jika ada file pending
                    const savedId = data.data?.id ?? document.getElementById('input-materi-db-id').value;
                    if (savedId && _materiPendingFiles.length) {
                        await uploadMateriAttachments(savedId);
                    }
                    showToast(data.message || 'Materi berhasil disimpan');
                    toggleModal(false);
                    setTimeout(() => location.reload(), 800);
                } else {
                    const errors = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Gagal menyimpan');
                    showToast(errors, 'error');
                }
            })
            .catch(err => showToast('Error: ' + err.message, 'error'));
    }

    // ─── ATTACHMENT MATERI ────────────────────────────────────────────────────
    let _materiPendingFiles = []; // file yang dipilih, belum diupload

    function handleMateriDrop(e) {
        e.preventDefault();
        document.getElementById('materi-drop-zone').classList.remove('border-primary','bg-primary/5');
        handleMateriFileSelect(e.dataTransfer.files);
    }

    function handleMateriFileSelect(files) {
        Array.from(files).forEach(f => _materiPendingFiles.push(f));
        renderMateriFilePreview();
    }

    function renderMateriFilePreview() {
        const container = document.getElementById('materi-file-preview');
        if (!_materiPendingFiles.length) { container.classList.add('hidden'); return; }
        container.classList.remove('hidden');
        container.classList.add('flex');
        container.innerHTML = _materiPendingFiles.map((f, i) => `
            <div class="flex items-center gap-space-sm px-space-sm py-space-xs rounded-xl bg-surface-container border border-outline-variant/20">
                <span class="material-symbols-outlined text-primary text-[18px]">${f.type.startsWith('image/') ? 'image' : 'picture_as_pdf'}</span>
                <span class="font-body-sm text-body-sm text-on-surface flex-1 truncate">${f.name}</span>
                <span class="font-label-badge text-label-badge text-outline">${(f.size/1024/1024).toFixed(1)} MB</span>
                <button type="button" onclick="removeMateriFile(${i})"
                    class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors">
                    <span class="material-symbols-outlined text-[14px]">close</span>
                </button>
            </div>`).join('');
    }

    function removeMateriFile(idx) {
        _materiPendingFiles.splice(idx, 1);
        renderMateriFilePreview();
    }

    function renderSavedAttachments(attachments, materiId) {
        const container = document.getElementById('materi-saved-attachments');
        if (!attachments.length) { container.classList.add('hidden'); return; }
        container.classList.remove('hidden');
        container.classList.add('flex');
        container.innerHTML = `
            <span class="font-label-badge text-label-badge uppercase text-outline mb-space-2xs">File tersimpan</span>
            ${attachments.map(a => `
            <div class="flex items-center gap-space-sm px-space-sm py-space-xs rounded-xl bg-surface-container border border-outline-variant/20" id="saved-att-${a.id}">
                <span class="material-symbols-outlined text-[18px] ${a.is_pdf ? 'text-error' : 'text-primary'}">${a.icon}</span>
                <a href="${a.url}" target="_blank" class="font-body-sm text-body-sm text-primary hover:underline flex-1 truncate">${a.nama_file}</a>
                <span class="font-label-badge text-label-badge text-outline">${a.ukuran_readable}</span>
                <button type="button" onclick="deleteAttachment(${a.id}, 'saved-att-${a.id}')"
                    class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors">
                    <span class="material-symbols-outlined text-[14px]">delete</span>
                </button>
            </div>`).join('')}`;
    }

    async function uploadMateriAttachments(materiId) {
        if (!_materiPendingFiles.length) return;
        const fd = new FormData();
        _materiPendingFiles.forEach(f => fd.append('files[]', f));
        fd.append('_token', CSRF);
        try {
            await fetch(`/api/attachment/materi/${materiId}`, { method: 'POST', body: fd });
        } catch(e) { /* non-critical */ }
        _materiPendingFiles = [];
        renderMateriFilePreview();
    }

    function deleteAttachment(id, elId) {
        if (!confirm('Hapus file ini?')) return;
        fetch(`/api/attachment/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                document.getElementById(elId)?.remove();
                showToast('File dihapus');
            }
        });
    }

    function deleteMateri(dbId) {
        if (!confirm('Hapus materi ini? Semua kuis dan lab terkait akan ikut terhapus.')) return;

        fetch(`/api/kelola-materi/${dbId}`, { method: 'DELETE', headers: apiHeaders() })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast('Materi berhasil dihapus');
                    setTimeout(() => location.reload(), 800);
                } else {
                    showToast(data.message || 'Gagal menghapus', 'error');
                }
            })
            .catch(err => showToast('Error: ' + err.message, 'error'));
    }
    // ─── MODAL LAB PRAKTIK ────────────────────────────────────────────────────
    function toggleLabModal(open, materiId = null) {
        const modal = document.getElementById('lab-modal');
        if (!modal) return;
        if (open) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            if (materiId) document.getElementById('lab-materi-id').value = materiId;
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('lab-db-id').value = '';
            document.getElementById('lab-modal-title').innerText = 'Tambah Lab Praktik';
            document.getElementById('lab-form').reset();
        }
    }

    function openEditLabModal(lab) {
        document.getElementById('lab-modal-title').innerText  = 'Edit Lab: ' + lab.id_lab;
        document.getElementById('lab-db-id').value            = lab.id;
        document.getElementById('lab-materi-id').value        = lab.materi_id;
        document.getElementById('lab-id-lab').value           = lab.id_lab;
        document.getElementById('lab-kesulitan').value        = lab.tingkat_kesulitan;
        document.getElementById('lab-deskripsi').value        = lab.deskripsi_kasus;
        document.getElementById('lab-kode-awal').value        = lab.kode_soal_awal;
        document.getElementById('lab-bug-target').value       = lab.bug_target;
        document.getElementById('lab-poin-max').value         = lab.poin_max;
        document.getElementById('lab-solusi').value           = lab.solusi_fix;
        toggleLabModal(true);
    }

    function handleLabSubmit(e) {
        e.preventDefault();
        const dbId   = document.getElementById('lab-db-id').value;
        const isEdit = dbId !== '';

        const body = {
            materi_id:          document.getElementById('lab-materi-id').value,
            id_lab:             document.getElementById('lab-id-lab').value,
            tingkat_kesulitan:  document.getElementById('lab-kesulitan').value,
            deskripsi_kasus:    document.getElementById('lab-deskripsi').value,
            kode_soal_awal:     document.getElementById('lab-kode-awal').value,
            bug_target:         document.getElementById('lab-bug-target').value,
            poin_max:           document.getElementById('lab-poin-max').value,
            solusi_fix:         document.getElementById('lab-solusi').value,
        };

        const url    = isEdit ? `/api/lab/${dbId}` : '/api/lab';
        const method = isEdit ? 'PUT' : 'POST';

        fetch(url, { method, headers: apiHeaders(), body: JSON.stringify(body) })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Lab berhasil disimpan');
                    toggleLabModal(false);
                    setTimeout(() => location.reload(), 800);
                } else {
                    const errors = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Gagal menyimpan');
                    showToast(errors, 'error');
                }
            })
            .catch(err => showToast('Error: ' + err.message, 'error'));
    }

    function deleteLab(dbId) {
        if (!confirm('Hapus lab praktik ini?')) return;

        fetch(`/api/lab/${dbId}`, { method: 'DELETE', headers: apiHeaders() })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast('Lab berhasil dihapus');
                    setTimeout(() => location.reload(), 800);
                } else {
                    showToast(data.message || 'Gagal menghapus', 'error');
                }
            })
            .catch(err => showToast('Error: ' + err.message, 'error'));
    }

    // Stub — fitur kuis sudah dipindah ke halaman /kuis/{materi}
    function toggleOpsiJawaban() {}

    // Init opsi jawaban visibility
    toggleOpsiJawaban();

    // ─── PENGATURAN ───────────────────────────────────────────────────────────
    function previewFoto(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const wrapper = document.getElementById('foto-wrapper');
            const icon    = document.getElementById('foto-icon');
            // Hapus icon, tambah/update img
            if (icon) icon.remove();
            let img = document.getElementById('foto-preview');
            if (!img) {
                img = document.createElement('img');
                img.id        = 'foto-preview';
                img.className = 'w-full h-full object-cover';
                wrapper.appendChild(img);
            }
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function simpanProfil(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-simpan-profil');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">sync</span> Menyimpan...';

        const fd = new FormData();
        fd.append('_token', CSRF);
        fd.append('name',           document.getElementById('pg-name').value);
        fd.append('nip',            document.getElementById('pg-nip').value);
        fd.append('sekolah',        document.getElementById('pg-sekolah').value);
        fd.append('mata_pelajaran', document.getElementById('pg-mapel').value);
        fd.append('no_hp',          document.getElementById('pg-nohp').value);
        fd.append('tahun_ajaran',   document.getElementById('pg-tahun').value);
        fd.append('semester',       document.getElementById('pg-semester').value);
        const fotoInput = document.getElementById('input-foto');
        if (fotoInput.files[0]) fd.append('foto', fotoInput.files[0]);

        fetch('/pengaturan/profil', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast('Profil berhasil disimpan');
                    // Update nama di header
                    document.getElementById('display-name').textContent = data.name;
                    document.querySelectorAll('.font-title-sm.text-on-surface.font-semibold').forEach(el => {
                        if (el.closest('header')) el.textContent = data.name;
                    });
                } else {
                    const err = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Gagal');
                    showToast(err, 'error');
                }
            })
            .catch(err => showToast('Error: ' + err.message, 'error'))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">save</span> Simpan Profil';
            });
    }

    function gantiPassword(e) {
        e.preventDefault();
        const lama    = document.getElementById('pw-lama').value;
        const baru    = document.getElementById('pw-baru').value;
        const konfirm = document.getElementById('pw-konfirm').value;

        if (baru !== konfirm) { showToast('Konfirmasi password tidak cocok', 'error'); return; }
        if (baru.length < 8)  { showToast('Password baru minimal 8 karakter', 'error'); return; }

        const btn = document.getElementById('btn-ganti-pw');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">sync</span> Mengubah...';

        fetch('/pengaturan/password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ current_password: lama, password: baru, password_confirmation: konfirm }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Password berhasil diubah');
                document.getElementById('form-password').reset();
            } else {
                showToast(data.message || 'Gagal mengubah password', 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">lock_reset</span> Ubah Password';
        });
    }

    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }

    // ─── EVENT LISTENERS: real-time duplicate check ───────────────────────────
    document.getElementById('input-id-materi')?.addEventListener('input', function() {
        const excludeId = document.getElementById('input-materi-db-id').value;
        debounceCheck(() => checkMateriDuplicate('id_materi', this.value.trim(), excludeId, this));
    });
    document.getElementById('input-judul-materi')?.addEventListener('input', function() {
        const excludeId = document.getElementById('input-materi-db-id').value;
        debounceCheck(() => checkMateriDuplicate('judul', this.value.trim(), excludeId, this));
    });
</script>

</body>
</html>
