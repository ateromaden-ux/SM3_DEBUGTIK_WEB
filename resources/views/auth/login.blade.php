<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DebugTIK - Masuk & Registrasi Akun</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "tertiary": "#006947",
                        "error": "#ba1a1a",
                        "surface-dim": "#cbdbf5",
                        "on-error": "#ffffff",
                        "secondary-container": "#39b8fd",
                        "on-secondary-container": "#004666",
                        "outline": "#707881",
                        "surface-bright": "#f8f9ff",
                        "background": "#f8f9ff",
                        "surface-container-highest": "#d3e4fe",
                        "surface-container-lowest": "#ffffff",
                        "surface-variant": "#d3e4fe",
                        "primary-fixed": "#cce5ff",
                        "on-background": "#0b1c30",
                        "tertiary-fixed": "#6ffbbe",
                        "primary-container": "#007bb9",
                        "primary": "#006194",
                        "tertiary-container": "#00855b",
                        "on-primary-container": "#fdfcff",
                        "secondary": "#006591",
                        "on-tertiary": "#ffffff",
                        "inverse-surface": "#213145",
                        "on-surface-variant": "#3f4850",
                        "surface": "#f8f9ff",
                        "surface-container-low": "#eff4ff",
                        "on-secondary": "#ffffff",
                        "on-primary": "#ffffff",
                        "on-surface": "#0b1c30",
                        "surface-container-high": "#dce9ff",
                        "surface-container": "#e5eeff"
                    },
                    fontFamily: {
                        "body-lg": ["Geist", "sans-serif"],
                        "code-inline": ["JetBrains Mono", "monospace"],
                        "headline-lg": ["Space Grotesk", "sans-serif"],
                        "code-editor": ["JetBrains Mono", "monospace"],
                        "display-hero": ["Space Grotesk", "sans-serif"],
                        "label-badge": ["JetBrains Mono", "monospace"],
                        "headline-xl": ["Space Grotesk", "sans-serif"],
                        "body-md": ["Geist", "sans-serif"],
                        "headline-md": ["Space Grotesk", "sans-serif"],
                        "body-sm": ["Geist", "sans-serif"],
                        "title-sm": ["Geist", "sans-serif"]
                    }
                }
            }
        };
    </script>
    <style>
        @layer base {
            html, body {
                margin: 0;
                padding: 0;
                min-height: 100vh;
            }
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 9999px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
        }
    </style>
</head>
<body class="bg-slate-50 font-body-md text-on-surface min-h-screen antialiased selection:bg-sky-100 selection:text-sky-900">
    <div class="w-full min-h-screen grid grid-cols-1 lg:grid-cols-12 overflow-x-hidden">
        <!-- Kolom Kiri (Brand & Showcase TIK, span 7 kolom / 58% lebar desktop) -->
        <section class="lg:col-span-7 bg-gradient-to-br from-sky-50 via-blue-50/60 to-indigo-50/40 p-8 lg:p-14 xl:p-16 flex flex-col justify-between border-r border-slate-200/80 relative overflow-hidden">
            <!-- Decorative Tech Glows -->
            <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-sky-200/35 blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 bottom-16 w-80 h-80 rounded-full bg-indigo-200/30 blur-3xl pointer-events-none"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#e2e8f01a_1px,transparent_1px),linear-gradient(to_bottom,#e2e8f01a_1px,transparent_1px)] bg-[size:28px_28px] pointer-events-none"></div>
            
            <div class="relative z-10">
                <!-- Brand Header & Badge -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-lg shadow-slate-900/10 ring-2 ring-slate-800/10">
                            <span class="material-symbols-outlined text-2xl text-sky-400">terminal</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-headline-lg text-2xl font-bold tracking-tight text-slate-900">Debug<span class="text-primary font-extrabold">TIK</span></span>
                                <span class="px-2.5 py-0.5 rounded-full bg-sky-100/90 text-primary font-label-badge text-xs uppercase font-semibold border border-sky-200/70">v2.6 Live</span>
                            </div>
                            <p class="font-body-sm text-xs text-slate-500 font-medium">Konsol Pengampu Komputasi • Hak Akses ERD Guru & Administrator</p>
                        </div>
                    </div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/80 border border-slate-200/80 backdrop-blur-sm shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-semibold text-slate-700 tracking-wide">Portal Guru & Administrator Lab Komputasi TIK</span>
                    </div>
                </div>

                <!-- Hero Headline & Copy -->
                <div class="max-w-2xl mb-10">
                    <h1 class="font-headline-xl text-3xl xl:text-4xl font-bold text-slate-900 leading-tight tracking-tight mb-4">
                        Platform Pembelajaran & Praktik Debugging TIK Terpadu
                    </h1>
                    <p class="font-body-md text-base text-slate-600 leading-relaxed">
                        Kuasai analisis algoritma, pemecahan galat program, dan perancangan skema data secara interaktif dan terarah untuk kurikulum komputasi modern.
                    </p>
                </div>

                <!-- Showcase Cards 3 Grid/Stack -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 xl:gap-5 mb-10">
                    <!-- Card 1: Lab Interaktif & Syntax Fix -->
                    <div class="p-5 rounded-xl bg-white/90 border border-slate-200/90 shadow-sm backdrop-blur-sm hover:border-sky-300 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-xl">bug_report</span>
                            </div>
                            <h3 class="font-title-sm text-sm font-bold text-slate-900 mb-1">Lab Interaktif Real-time</h3>
                            <p class="font-body-sm text-xs text-slate-600 mb-3">Lacak call stack & eksekusi loop JS secara instan dengan panduan perbaikan sintaks.</p>
                        </div>
                        <div class="rounded-lg bg-slate-900 p-2.5 font-code-inline text-[11px] text-slate-300 border border-slate-800">
                            <div class="flex items-center justify-between text-[10px] text-slate-400 mb-1 pb-1 border-b border-slate-800">
                                <span class="">counter.js</span>
                                <span class="text-rose-400 font-medium">SyntaxError: line 4</span>
                            </div>
                            <span class="text-slate-400 font-mono">1</span> <span class="text-sky-300">for</span> (<span class="text-amber-300">let</span> i = <span class="text-emerald-300">0</span>; i &lt;= len; i++) {<br>
                            <span class="text-slate-400 font-mono">2</span> &nbsp;&nbsp;renderNode(items[i]);<br>
                            <span class="text-emerald-400 font-mono text-[10px]">✓ Fix: index bound safety</span>
                        </div>
                    </div>

                    <!-- Card 2: Katalog Kasus Riil & ERD -->
                    <div class="p-5 rounded-xl bg-white/90 border border-slate-200/90 shadow-sm backdrop-blur-sm hover:border-sky-300 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-xl">account_tree</span>
                            </div>
                            <h3 class="font-title-sm text-sm font-bold text-slate-900 mb-1">Katalog Kasus Riil & ERD</h3>
                            <p class="font-body-sm text-xs text-slate-600 mb-3">Relasi basis data nyata berstruktur relasional dengan query debugging.</p>
                        </div>
                        <div class="rounded-lg bg-indigo-50/70 p-2.5 border border-indigo-100/90 flex flex-wrap gap-1.5 font-label-badge text-[10px]">
                            <span class="px-2 py-0.5 rounded bg-primary text-white font-semibold shadow-xs">GURU (Instruktur)</span>
                            <span class="px-2 py-0.5 rounded bg-white text-indigo-900 border border-indigo-200 font-semibold">1:N MATERI_BELAJAR</span>
                            <span class="px-2 py-0.5 rounded bg-white text-indigo-900 border border-indigo-200 font-semibold">SISWA (1:N)</span>
                            <span class="px-2 py-0.5 rounded bg-indigo-600 text-white font-semibold">PROGRESS_BELAJAR</span>
                        </div>
                    </div>

                    <!-- Card 3: Pelacakan Progres Terpadu -->
                    <div class="p-5 rounded-xl bg-white/90 border border-slate-200/90 shadow-sm backdrop-blur-sm hover:border-sky-300 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-xl">insights</span>
                            </div>
                            <h3 class="font-title-sm text-sm font-bold text-slate-900 mb-1">Pelacakan Progres Terpadu</h3>
                            <p class="font-body-sm text-xs text-slate-600 mb-3">Metrik capaian kompetensi berpikir komputasional Kurikulum Merdeka 2026.</p>
                        </div>
                        <div class="space-y-1.5 pt-1">
                            <div class="flex justify-between text-[11px] font-semibold text-slate-700">
                                <span class="">Algoritma & Pemrograman</span>
                                <span class="text-emerald-700">84%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-full rounded-full" style="width: 84%"></div>
                            </div>
                            <span class="text-[10px] text-slate-500 block">Status: Siap Asesmen Sumatif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Kiri -->
            <div class="relative z-10 pt-6 border-t border-slate-200/70 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-500">
                <div class="flex items-center gap-2.5 font-code-inline bg-white/70 px-3 py-1.5 rounded-md border border-slate-200/80">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-slate-800 font-semibold">Kernel Debugger Active</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-primary font-bold">PORT: 8080</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm text-emerald-600">verified</span>
                    <span class="">Standar Capaian Kurikulum TIK 2026</span>
                </div>
            </div>
        </section>

        <!-- Kolom Kanan (Formulir Autentikasi Bersih & Simpel, span 5 kolom / 42% lebar desktop) -->
        <section class="lg:col-span-5 bg-white p-8 lg:p-12 xl:p-16 flex flex-col justify-between items-center min-h-screen">
            <!-- Spacer Top / Branding Mobile Only -->
            <div class="w-full flex items-center justify-between lg:hidden mb-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center">
                        <span class="material-symbols-outlined text-base text-sky-400">terminal</span>
                    </div>
                    <span class="font-headline-lg text-lg font-bold text-slate-900">Debug<span class="text-primary">TIK</span></span>
                </div>
                <span class="text-xs px-2 py-0.5 rounded bg-sky-100 text-primary font-semibold">v2.6</span>
            </div>

            <!-- Main Form Container -->
            <div class="w-full max-w-md my-auto py-4">
                <!-- Tab Toggle Simpel & Elegan -->
                <div class="p-1 bg-slate-100 rounded-xl mb-6 flex border border-slate-200/70">
                    <a class="flex-1 py-2 rounded-lg text-sm font-semibold bg-white text-primary shadow-sm flex items-center justify-center gap-2" href="#" id="tab-login" onclick="setMode('login'); return false;">
                        <span class="material-symbols-outlined text-base">verified_user</span>
                        <span class="">Autentikasi Guru & Admin</span>
                    </a>
                    <a class="flex-1 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900 flex items-center justify-center gap-2 transition-colors" href="#" id="tab-register" onclick="setMode('register'); return false;">
                        <span class="material-symbols-outlined text-base">assignment_ind</span>
                        <span class="">Aktivasi NIP Baru</span>
                    </a>
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-bold font-headline-lg text-slate-900 mb-1.5" id="form-heading">Masuk Portal Guru & Admin</h2>
                    <p class="text-sm text-slate-500" id="form-subheading">Otentikasi khusus Guru Pengampu & Pengelola Lab untuk administrasi praktikum komputasi.</p>
                </div>

                <!-- Segmented Role Selector -->
                <div class="mb-5">
                    <label class="block font-label-badge text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">
                        Peran Pengampu TIK (Eksklusif)
                    </label>
                    <div class="flex">
                        <label class="relative flex items-center gap-3 p-3 rounded-xl border border-primary bg-sky-50/70 text-primary cursor-default w-full">
                            <input checked class="peer sr-only" name="userRole" type="radio" value="teacher">
                            <span class="material-symbols-outlined text-xl text-primary">supervised_user_circle</span>
                            <div>
                                <span class="text-sm font-semibold text-primary block leading-tight">Guru / Pengajar</span>
                                <span class="text-[10px] text-slate-500 font-normal">Pengampu Kurikulum</span>
                            </div>
                            <span class="ml-auto w-4 h-4 rounded-full border-2 border-primary bg-primary flex items-center justify-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Form Autentikasi -->
                <form class="space-y-4" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Extra Field Register (Hidden by default) -->
                    <div class="hidden space-y-4" id="register-extra-fields">
                        <div>
                            <label class="block font-label-badge text-xs uppercase tracking-wider text-slate-600 font-semibold mb-1.5">
                                Nama Lengkap Siswa / Guru
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-3 text-slate-400 text-lg">badge</span>
                                <input class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:border-primary focus:ring-2 focus:ring-sky-100 placeholder:text-slate-400 outline-none transition-all" name="name" placeholder="e.g. Raden Arya Pratama" type="text">
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-badge text-xs uppercase tracking-wider text-slate-600 font-semibold mb-1.5">
                                NISN / NIP / Kode Lembaga
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-3 text-slate-400 text-lg">pin</span>
                                <input class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:border-primary focus:ring-2 focus:ring-sky-100 placeholder:text-slate-400 outline-none transition-all" name="nip" placeholder="10 digit nomor identitas resmi" type="text">
                            </div>
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label class="block font-label-badge text-xs uppercase tracking-wider text-slate-600 font-semibold mb-1.5">
                            NIP / Email Kedinasan Guru (@sekolah.sch.id / @belajar.id)
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-3 text-slate-400 text-lg">badge</span>
                            <input class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:border-primary focus:ring-2 focus:ring-sky-100 placeholder:text-slate-400 outline-none transition-all @error('email') border-red-500 @enderror" name="email" placeholder="nama.guru@sekolah.sch.id / nip.guru@kemdikbud.go.id" required="" type="text" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block font-label-badge text-xs uppercase tracking-wider text-slate-600 font-semibold">
                                Kata Sandi
                            </label>
                            <a class="text-xs font-semibold text-primary hover:text-sky-700 hover:underline transition-colors" href="#" id="forgot-password-link">
                                Lupa kata sandi?
                            </a>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-3 text-slate-400 text-lg">lock</span>
                            <input class="w-full pl-11 pr-11 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:border-primary focus:ring-2 focus:ring-sky-100 placeholder:text-slate-400 outline-none transition-all @error('password') border-red-500 @enderror" id="password-input" name="password" placeholder="Minimal 8 karakter" required="" type="password">
                            <button aria-label="Toggle password visibility" class="absolute right-3.5 top-2.5 text-slate-400 hover:text-slate-700 transition-colors p-0.5" onclick="togglePasswordVisibility(); return false;" type="button">
                                <span class="material-symbols-outlined text-lg" id="password-toggle-icon">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Checkbox Ingat Sesi -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input checked="" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/20" name="remember" type="checkbox">
                            <span class="text-xs text-slate-600" id="label-remember">Ingat sesi di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Info ERD -->
                    <div class="p-3 rounded-lg bg-sky-50/70 border border-sky-200/70 text-xs text-slate-600 flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-base text-primary mt-0.5">database</span>
                        <div class="space-y-1 leading-snug">
                            <p class="font-semibold text-slate-800 font-code-inline text-[11px]">ERD Entity: <span class="text-primary font-bold">GURU</span> (id_guru, email, password_hash)</p>
                            <p class="text-[11px] text-slate-500">Mengotorisasi pengelolaan tabel <code class="font-code-inline text-slate-700 bg-white px-1 py-0.5 rounded border border-slate-200">MATERI_BELAJAR</code> dan penugasan <code class="font-code-inline text-slate-700 bg-white px-1 py-0.5 rounded border border-slate-200">PROGRESS_BELAJAR</code> siswa.</p>
                        </div>
                    </div>

                    <button class="w-full mt-2 py-3 px-5 rounded-lg bg-primary hover:bg-[#007bb9] active:bg-[#004b73] text-white font-title-sm text-sm font-semibold shadow-md shadow-sky-900/10 transition-all flex items-center justify-center gap-2" id="submit-btn" type="submit">
                        <span class="material-symbols-outlined text-lg" id="btn-icon">login</span>
                        <span id="btn-text" class="">Masuk ke Portal Guru & Admin</span>
                    </button>

                    <!-- Divider -->
                    <div class="relative flex py-2 items-center">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span class="flex-shrink mx-3 text-slate-400 font-label-badge text-[11px] uppercase tracking-wider">Atau lanjutkan dengan</span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>

                    <!-- Tombol SSO Google / Belajar.id -->
                    <button class="w-full py-2.5 px-4 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-title-sm text-sm font-medium transition-all flex items-center justify-center gap-3 shadow-xs" type="button">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"></path>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"></path>
                        </svg>
                        <span class="">Akun Belajar.id / Google Workspace</span>
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-slate-500">
                    <span id="footer-switch-text" class="">Belum terdaftar sebagai Guru Pengampu?</span>
                    <a class="ml-1 text-primary font-semibold hover:underline" href="#" id="footer-switch-btn" onclick="toggleSwitchMode(); return false;">
                        Hubungi Operator / Admin Sekolah
                    </a>
                </div>
            </div>

            <!-- Footer Bawah Hak Cipta & Link Bantuan -->
            <div class="w-full max-w-md pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-400">
                <span class="">© 2026 DebugTIK Indonesia.</span>
                <div class="flex items-center gap-3">
                    <a class="hover:text-slate-600 transition-colors" href="#">Pusat Bantuan Lab</a>
                    <span class="">•</span>
                    <a class="hover:text-slate-600 transition-colors" href="#">Privasi</a>
                </div>
            </div>
        </section>
    </div>

    <!-- Interaksi Script -->
    <script>
        let currentMode = 'login';

        function setMode(mode) {
            currentMode = mode;
            const isLogin = mode === 'login';
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');
            const extraFields = document.getElementById('register-extra-fields');
            const forgotLink = document.getElementById('forgot-password-link');
            const btnText = document.getElementById('btn-text');
            const btnIcon = document.getElementById('btn-icon');
            const labelRemember = document.getElementById('label-remember');
            const heading = document.getElementById('form-heading');
            const subheading = document.getElementById('form-subheading');
            const switchText = document.getElementById('footer-switch-text');
            const switchBtn = document.getElementById('footer-switch-btn');

            if (isLogin) {
                tabLogin.className = 'flex-1 py-2 rounded-lg text-sm font-semibold bg-white text-primary shadow-sm flex items-center justify-center gap-2';
                tabRegister.className = 'flex-1 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900 flex items-center justify-center gap-2 transition-colors';
                extraFields.classList.add('hidden');
                forgotLink.classList.remove('hidden');
                btnText.textContent = 'Masuk ke Portal Guru & Admin';
                btnIcon.textContent = 'login';
                labelRemember.textContent = 'Ingat sesi di perangkat ini';
                heading.textContent = 'Masuk Portal Guru & Admin';
                subheading.textContent = 'Otentikasi khusus Guru Pengampu & Pengelola Lab untuk administrasi praktikum komputasi.';
                switchText.textContent = 'Belum terdaftar sebagai Guru Pengampu?';
                switchBtn.textContent = 'Hubungi Operator / Admin Sekolah';
            } else {
                tabRegister.className = 'flex-1 py-2 rounded-lg text-sm font-semibold bg-white text-primary shadow-sm flex items-center justify-center gap-2';
                tabLogin.className = 'flex-1 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900 flex items-center justify-center gap-2 transition-colors';
                extraFields.classList.remove('hidden');
                forgotLink.classList.add('hidden');
                btnText.textContent = 'Daftarkan Akun Baru';
                btnIcon.textContent = 'person_add';
                labelRemember.textContent = 'Saya menyetujui Ketentuan Pembelajaran & Privasi';
                heading.textContent = 'Daftar Akun DebugTIK';
                subheading.textContent = 'Mulai eksplorasi praktikum algoritma dan debugging basis data.';
                switchText.textContent = 'Sudah memiliki akun?';
                switchBtn.textContent = 'Masuk Sekarang';
            }
        }

        function toggleSwitchMode() {
            setMode(currentMode === 'login' ? 'register' : 'login');
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password-input');
            const icon = document.getElementById('password-toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
    
    @vite(['resources/js/login.js'])
</body>
</html>
