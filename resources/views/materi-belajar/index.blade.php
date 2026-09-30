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
            }
        }
    </script>
    <title>Kelola Materi Belajar - DebugTIK</title>
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
                <span class="font-body-sm text-body-sm text-on-surface-variant">Semester Ganjil 2024/2025</span>
            </div>
        </div>
        <nav class="flex flex-col gap-space-2xs px-space-md mt-space-xs" data-active-classes="bg-primary-container text-on-primary-container font-semibold rounded-xl">
            <a class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors" href="#">
                <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
                <span class="font-body-md text-body-md">Dasbor Utama</span>
            </a>
            <a aria-current="page" class="flex items-center gap-space-sm px-space-md py-space-sm transition-colors bg-primary-container text-on-primary-container font-semibold rounded-xl" href="#">
                <span class="material-symbols-outlined text-[20px]">library_books</span>
                <span class="font-body-md text-body-md">Kelola Materi Belajar</span>
            </a>
        </nav>
    </div>
</aside>

<div class="pl-72">
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
            <div class="flex items-center gap-space-sm pl-space-2xs">
                <div class="flex flex-col text-right leading-none">
                    <span class="font-title-sm text-title-sm text-on-surface font-semibold">{{ $guru->name }}</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">Guru TIK / Pengampu Lab</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                </div>
            </div>
        </div>
    </header>

    <main class="w-full pt-16 bg-surface min-h-screen px-space-lg py-space-lg">
        <div class="flex flex-col w-full">
            <!-- Header -->
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-space-lg mb-space-xl">
                <div class="flex flex-col max-w-2xl">
                    <div class="flex items-center gap-space-xs text-primary font-label-badge text-label-badge uppercase tracking-wider mb-space-2xs">
                        <span class="material-symbols-outlined text-[16px]">terminal</span>
                        <span>Katalog Kurikulum Fase E • Basis Data: `materi_belajar`</span>
                    </div>
                    <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight font-bold">
                        Kelola Materi Belajar TIK
                    </h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-space-2xs leading-relaxed">
                        Penyusunan Silabus Materi & Relasi Modul (HTML, CSS, JavaScript Dasar) — Terdistribusi otomatis ke klien aplikasi mobile siswa Kelas X TIK.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-space-sm">
                    <button class="inline-flex items-center gap-space-xs bg-primary hover:bg-primary-container text-on-primary px-space-md py-space-sm rounded-xl font-body-md text-body-md font-semibold transition-all shadow-sm active:scale-95" onclick="toggleModal(true)" type="button">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        <span>+ Tambah Materi Baru</span>
                    </button>
                    <div class="flex items-center gap-space-xs bg-surface-container-low px-space-sm py-space-xs rounded-xl text-on-surface-variant text-body-sm font-code-inline">
                        <span class="inline-block w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                        <span>DB: `materi_belajar` (SYNC LIVE)</span>
                    </div>
                </div>
            </div>

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
                            <span class="text-on-surface leading-none" style="font-size: 48px; line-height: 56px; letter-spacing: -0.03em; font-weight: 700; font-family: 'Space Grotesk';">{{ $metrics['total_modul'] }}</span>
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
                            <span class="text-on-surface leading-none" style="font-size: 48px; line-height: 56px; letter-spacing: -0.03em; font-weight: 700; font-family: 'Space Grotesk';">{{ $metrics['total_kuis'] }}</span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Soal</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">
                            Tabel Relasi <code class="font-code-inline text-code-inline text-primary bg-surface-container px-1 rounded">kuis_TIK</code>
                        </p>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-space-sm">
                        <span class="font-label-badge text-label-badge uppercase text-outline">Lab Praktik Debug</span>
                        <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">bug_report</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-space-2xs">
                            <span class="text-on-surface leading-none" style="font-size: 48px; line-height: 56px; letter-spacing: -0.03em; font-weight: 700; font-family: 'Space Grotesk';">{{ $metrics['total_lab'] }}</span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Kasus</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">
                            Tabel Relasi <code class="font-code-inline text-code-inline text-primary bg-surface-container px-1 rounded">lab_praktik</code>
                        </p>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-space-sm">
                        <span class="font-label-badge text-label-badge uppercase text-outline">Siswa Sedang Belajar</span>
                        <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-[18px]">groups</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-space-2xs">
                            <span class="text-on-surface leading-none" style="font-size: 48px; line-height: 56px; letter-spacing: -0.03em; font-weight: 700; font-family: 'Space Grotesk';">{{ $metrics['siswa_online'] }}</span>
                            <span class="font-body-sm text-body-sm text-tertiary font-semibold">Online</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">
                            Kelas X TIK 1 & X TIK 2
                        </p>
                    </div>
                </div>
            </div>

            <!-- Materi Cards Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg">
                <div class="xl:col-span-8 flex flex-col gap-space-lg">
                    @forelse($materis as $materi)
                        <article class="module-card bg-surface-container-lowest rounded-xl p-space-lg shadow-sm transition-all hover:shadow-md flex flex-col justify-between">
                            <div class="flex flex-col gap-space-sm">
                                <div class="flex flex-wrap items-center justify-between gap-space-xs">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="px-space-xs py-space-2xs rounded-lg bg-surface-container font-code-inline text-code-inline font-bold text-primary">
                                            id_materi: {{ $materi->id_materi }}
                                        </span>
                                        <span class="px-space-xs py-space-2xs rounded-lg bg-surface-container-high font-label-badge text-label-badge text-on-surface-variant font-semibold">
                                            Modul • {{ $materi->level }}
                                        </span>
                                    </div>
                                    <div class="inline-flex items-center gap-space-2xs bg-tertiary-container/10 px-space-sm py-space-2xs rounded-full">
                                        <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                        <span class="font-label-badge text-label-badge uppercase font-bold text-tertiary">Aktif & Tampil di Siswa</span>
                                    </div>
                                </div>
                                <div class="flex items-start justify-between gap-space-md mt-space-xs">
                                    <div>
                                        <h2 class="font-headline-lg text-headline-lg text-on-surface font-bold">
                                            {{ $materi->judul }}
                                        </h2>
                                        <p class="font-body-md text-body-md text-on-surface-variant mt-space-2xs">
                                            {{ Str::limit($materi->deskripsi, 100) }}
                                        </p>
                                    </div>
                                    <div class="hidden sm:flex w-12 h-12 rounded-xl bg-surface-container items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[28px] text-primary">code</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm mt-space-sm bg-surface-container-low p-space-sm rounded-xl">
                                    <div class="flex items-center justify-between px-space-sm py-space-xs bg-surface-container-lowest rounded-lg">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="material-symbols-outlined text-[18px] text-primary">format_list_bulleted</span>
                                            <span class="font-body-sm text-body-sm font-medium text-on-surface">kuis_TIK Terkait</span>
                                        </div>
                                        <span class="font-code-inline text-code-inline font-bold text-primary">{{ $materi->kuis->count() }} Soal</span>
                                    </div>
                                    <div class="flex items-center justify-between px-space-sm py-space-xs bg-surface-container-lowest rounded-lg">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="material-symbols-outlined text-[18px] text-error">bug_report</span>
                                            <span class="font-body-sm text-body-sm font-medium text-on-surface">lab_praktik Debug</span>
                                        </div>
                                        <span class="font-code-inline text-code-inline font-bold text-error">{{ $materi->labPraktik->count() }} Kasus</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-space-sm mt-space-md pt-space-md bg-surface-container-low/50 -mx-space-lg -mb-space-lg p-space-md rounded-b-xl">
                                <div class="flex items-center gap-space-xs text-outline font-body-sm text-body-sm">
                                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                                    <span>Update Terakhir: {{ $materi->updated_at->format('d M Y, H:i') }} oleh {{ $guru->name }}</span>
                                </div>
                                <div class="flex items-center gap-space-xs">
                                    <button class="inline-flex items-center gap-space-2xs px-space-sm py-space-xs rounded-lg bg-surface hover:bg-surface-container text-on-surface font-body-sm text-body-sm font-medium transition-colors shadow-sm" onclick="openEditorModal('{{ $materi->id_materi }}', '{{ $materi->judul }}', '{{ $materi->kategori }}', '{{ $materi->level }}', {{ $materi->estimasi_waktu }})" type="button">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                        <span>Edit Materi</span>
                                    </button>
                                    <button class="inline-flex items-center gap-space-2xs px-space-sm py-space-xs rounded-lg bg-surface hover:bg-surface-container text-on-surface font-body-sm text-body-sm font-medium transition-colors shadow-sm" type="button">
                                        <span class="material-symbols-outlined text-[16px] text-primary">quiz</span>
                                        <span>Kelola Kuis ({{ $materi->kuis->count() }})</span>
                                    </button>
                                    <button class="inline-flex items-center gap-space-2xs px-space-sm py-space-xs rounded-lg bg-surface hover:bg-surface-container text-on-surface font-body-sm text-body-sm font-medium transition-colors shadow-sm" type="button">
                                        <span class="material-symbols-outlined text-[16px] text-error">terminal</span>
                                        <span>Kelola Lab ({{ $materi->labPraktik->count() }})</span>
                                    </button>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="bg-surface-container-lowest rounded-xl p-space-lg text-center">
                            <span class="material-symbols-outlined text-[48px] text-on-surface-variant">folder_open</span>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-space-md">Belum ada materi. Mulai dengan klik tombol + Tambah Materi Baru</p>
                        </div>
                    @endforelse
                </div>

                <!-- Right Panel: Metrics & ERD -->
                <div class="xl:col-span-4 flex flex-col gap-space-lg">
                    <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col gap-space-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[20px]">account_tree</span>
                                <span class="font-title-sm text-title-sm text-on-surface font-semibold">Relasi Basis Data ERD</span>
                            </div>
                            <span class="px-space-xs py-space-2xs rounded bg-surface-container text-primary font-code-inline text-code-inline font-bold">
                                1 : N (One-to-Many)
                            </span>
                        </div>
                        <div class="bg-surface-container-low p-space-sm rounded-xl font-code-inline text-body-sm flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between p-space-xs bg-surface-container-lowest rounded-lg">
                                <div class="flex items-center gap-space-xs">
                                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                                    <span class="font-bold text-on-surface">guru</span>
                                    <span class="text-outline text-code-inline">(id: {{ $guru->id }})</span>
                                </div>
                                <span class="text-label-badge text-outline uppercase">Entitas Induk</span>
                            </div>
                            <div class="flex items-center pl-space-md text-outline">
                                <span class="material-symbols-outlined text-[18px]">subdirectory_arrow_right</span>
                                <span class="text-code-inline text-primary font-bold ml-1">1 : N mengelola materi_belajar</span>
                            </div>
                            <div class="flex items-center justify-between p-space-xs bg-surface-container-lowest rounded-lg ml-space-md">
                                <div class="flex items-center gap-space-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                    <span class="font-bold text-on-surface">materi_belajar</span>
                                    <span class="text-outline text-code-inline">({{ $metrics['total_modul'] }} Modul)</span>
                                </div>
                                <span class="text-label-badge text-outline">Koleksi Utama</span>
                            </div>
                            <div class="flex items-center pl-space-xl text-outline">
                                <span class="material-symbols-outlined text-[16px]">subdirectory_arrow_right</span>
                                <span class="text-code-inline text-tertiary font-medium ml-1">1 : N kuis_TIK ({{ $metrics['total_kuis'] }} Soal)</span>
                            </div>
                            <div class="flex items-center pl-space-xl text-outline">
                                <span class="material-symbols-outlined text-[16px]">subdirectory_arrow_right</span>
                                <span class="text-code-inline text-error font-medium ml-1">1 : N lab_praktik ({{ $metrics['total_lab'] }} Lab)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal Form Tambah/Edit Materi -->
<div class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-space-md" id="materi-modal">
    <div class="bg-surface-container-lowest rounded-2xl max-w-xl w-full p-space-lg shadow-xl flex flex-col gap-space-md transition-all scale-95 duration-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-space-xs">
                <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">dataset</span>
                </div>
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface font-bold" id="modal-title">
                        + Tambah Materi Belajar Baru
                    </h3>
                    <span class="font-body-sm text-body-sm text-outline">Entitas Basis Data: `materi_belajar`</span>
                </div>
            </div>
            <button class="w-8 h-8 rounded-full bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface-variant transition-colors" onclick="toggleModal(false)" type="button">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <form class="flex flex-col gap-space-md mt-space-2xs" id="materi-form" onsubmit="handleFormSubmit(event)">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">
                        ID Materi (PK) <span class="text-error">*</span>
                    </label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm" id="input-id-materi" placeholder="Contoh: MAT-JS-04" required="" type="text"/>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">
                        Level Materi <span class="text-error">*</span>
                    </label>
                    <select class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm cursor-pointer" id="input-level-materi">
                        <option value="Pemula">Pemula (Fase E - Kelas X)</option>
                        <option value="Menengah">Menengah (Fase F - Kelas XI)</option>
                        <option value="Lanjutan">Lanjutan (Fase F - Kelas XII)</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-space-2xs">
                <label class="font-label-badge text-label-badge uppercase text-outline">
                    Judul Materi Belajar <span class="text-error">*</span>
                </label>
                <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface shadow-sm" id="input-judul-materi" placeholder="Contoh: JavaScript Lanjutan: DOM Manipulation & Event Listener" required="" type="text"/>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">
                        Kategori Modul <span class="text-error">*</span>
                    </label>
                    <select class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface shadow-sm cursor-pointer" id="input-kategori">
                        <option value="HTML Dasar">HTML Dasar</option>
                        <option value="CSS Dasar">CSS Dasar</option>
                        <option value="JS Dasar">JavaScript Dasar</option>
                        <option value="Web Responsif">Web Responsif (Flex & Grid)</option>
                    </select>
                </div>
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">
                        Estimasi Waktu Belajar (Menit) <span class="text-error">*</span>
                    </label>
                    <input class="w-full h-10 px-space-sm rounded-xl bg-surface-container-low font-code-inline text-code-inline text-on-surface focus:outline-none focus:bg-surface shadow-sm" id="input-estimasi-waktu" max="240" min="10" required="" type="number" value="45"/>
                </div>
            </div>

            <div class="p-space-sm rounded-xl bg-surface-container flex items-center justify-between text-body-sm">
                <div class="flex items-center gap-space-xs text-on-surface-variant">
                    <span class="material-symbols-outlined text-[18px] text-primary">person</span>
                    <span>Guru Pengampu (id_guru FK):</span>
                </div>
                <span class="font-code-inline text-code-inline font-bold text-on-surface">{{ $guru->name }}</span>
            </div>

            <div class="flex items-center justify-end gap-space-sm mt-space-sm pt-space-sm border-t border-surface-container">
                <button class="px-space-md py-space-sm rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-body-sm text-body-sm font-medium transition-colors" onclick="toggleModal(false)" type="button">
                    Batal
                </button>
                <button class="px-space-lg py-space-sm rounded-xl bg-primary hover:bg-primary-container text-on-primary font-body-sm text-body-sm font-semibold transition-all shadow-sm active:scale-95" type="submit">
                    Simpan ke Silabus Mobile
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
            document.getElementById('materi-form').reset();
        }
    }

    function openEditorModal(id, title, category, level, time) {
        document.getElementById('modal-title').innerText = 'Edit Materi: ' + id;
        document.getElementById('input-id-materi').value = id;
        document.getElementById('input-judul-materi').value = title;
        document.getElementById('input-kategori').value = category;
        document.getElementById('input-level-materi').value = level;
        document.getElementById('input-estimasi-waktu').value = time;
        toggleModal(true);
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('input-id-materi').value;
        const judul = document.getElementById('input-judul-materi').value;
        const kategori = document.getElementById('input-kategori').value;
        const level = document.getElementById('input-level-materi').value;
        const waktu = document.getElementById('input-estimasi-waktu').value;

        // Send AJAX to backend
        fetch('/kelola-materi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                id_materi: id,
                judul: judul,
                kategori: kategori,
                level: level,
                estimasi_waktu: waktu,
                deskripsi: 'Materi ' + kategori,
                konten: '<p>Materi pembelajaran</p>',
                tingkat_kesulitan: 1
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Materi berhasil disimpan!');
                toggleModal(false);
                location.reload();
            }
        })
        .catch(err => alert('Error: ' + err.message));
    }
</script>

@csrf
</body>
</html>
