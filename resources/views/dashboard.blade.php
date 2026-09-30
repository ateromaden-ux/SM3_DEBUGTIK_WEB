<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DebugTIK - Dashboard</title>
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
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-slate-200 flex flex-col">
            <div class="p-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                        <span class="material-symbols-outlined text-base text-sky-400">terminal</span>
                    </div>
                    <div>
                        <h2 class="font-headline-lg text-lg font-bold text-slate-900">Debug<span class="text-primary">TIK</span></h2>
                        <p class="font-body-sm text-xs text-slate-500">Dashboard Guru</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg bg-primary text-white transition-all">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg text-slate-700 hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined">book</span>
                    <span class="font-medium">Materi Belajar</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg text-slate-700 hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined">group</span>
                    <span class="font-medium">Siswa</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg text-slate-700 hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="font-medium">Analytics</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-lg text-slate-700 hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="font-medium">Pengaturan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg">
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500">Guru / Pengajar</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-headline-lg text-xl font-bold text-slate-900">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-sm text-slate-500">Portal Guru & Administrator Lab TIK</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-all">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition-all font-medium text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Card Total Materi -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Total Materi TIK</p>
                                <h3 class="text-3xl font-bold text-slate-900">{{ $totalMateri }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">book</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-4">Materi aktif untuk pembelajaran siswa</p>
                    </div>

                    <!-- Card Total Siswa -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Total Siswa Aktif</p>
                                <h3 class="text-3xl font-bold text-slate-900">{{ $totalSiswa }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">group</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-4">Siswa terdaftar dalam sistem</p>
                    </div>

                    <!-- Card Progress Status -->
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Aktivitas Pembelajaran</p>
                                <h3 class="text-3xl font-bold text-slate-900">
                                    {{ $progressStats['selesai'] ?? 0 }}
                                </h3>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">check_circle</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-4">Materi diselesaikan oleh siswa</p>
                    </div>
                </div>

                <!-- Materi Terbaru -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-headline-md text-lg font-bold text-slate-900">Materi Belajar Terbaru</h2>
                        <p class="text-sm text-slate-500">5 materi terbaru yang dipublikasikan</p>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($materiTerbaru as $materi)
                        <div class="px-6 py-4 hover:bg-slate-50 transition-all">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-slate-900 mb-1">{{ $materi->judul }}</h3>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                            {{ $materi->kategori == 'algoritma' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $materi->kategori == 'pemrograman' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $materi->kategori == 'database' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $materi->kategori == 'debugging' ? 'bg-amber-100 text-amber-800' : '' }}">
                                            {{ ucfirst($materi->kategori) }}
                                        </span>
                                        <span class="text-xs text-slate-500">Kesulitan: {{ $materi->tingkat_kesulitan }}/5</span>
                                        <span class="text-xs text-slate-500">{{ $materi->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <button class="px-4 py-2 rounded-lg bg-primary text-white text-sm font-medium hover:bg-[#007bb9] transition-all">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                        <h2 class="font-headline-md text-lg font-bold text-slate-900 mb-4">Aksi Cepat</h2>
                        <div class="space-y-3">
                            <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-primary hover:bg-sky-50 transition-all">
                                <span class="material-symbols-outlined text-primary">add</span>
                                <span class="font-medium text-slate-900">Buat Materi Baru</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-primary hover:bg-sky-50 transition-all">
                                <span class="material-symbols-outlined text-primary">assignment</span>
                                <span class="font-medium text-slate-900">Lihat Progress Siswa</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-primary hover:bg-sky-50 transition-all">
                                <span class="material-symbols-outlined text-primary">analytics</span>
                                <span class="font-medium text-slate-900">Laporan Analytics</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                        <h2 class="font-headline-md text-lg font-bold text-slate-900 mb-4">Statistik Progress</h2>
                        <div class="space-y-4">
                            @foreach(['selesai', 'sedang_belajar', 'belum_mulai'] as $status)
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-slate-700">
                                        @if($status == 'selesai') Selesai @endif
                                        @if($status == 'sedang_belajar') Sedang Belajar @endif
                                        @if($status == 'belum_mulai') Belum Mulai @endif
                                    </span>
                                    <span class="text-sm font-semibold text-primary">{{ $progressStats[$status] ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full 
                                        @if($status == 'selesai') bg-emerald-500 @endif
                                        @if($status == 'sedang_belajar') bg-yellow-500 @endif
                                        @if($status == 'belum_mulai') bg-slate-400 @endif"
                                        style="width: {{ ($progressStats[$status] ?? 0) * 10 }}%">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-auto p-6 border-t border-slate-200 bg-white">
                <div class="flex items-center justify-between text-sm text-slate-500">
                    <span>© 2026 DebugTIK Indonesia. Hak Cipta Dilindungi.</span>
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Sistem Aktif • Kernel Debugger Ready
                    </span>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>