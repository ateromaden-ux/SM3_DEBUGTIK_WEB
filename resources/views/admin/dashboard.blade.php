<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - DebugTIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen">

    <!-- Top Navbar -->
    <header class="border-b border-slate-800 bg-slate-950/50 backdrop-blur px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center font-bold text-xl text-white shadow-lg shadow-indigo-500/30">
                SA
            </div>
            <div>
                <h1 class="font-bold text-lg leading-tight">Control Panel</h1>
                <p class="text-xs text-slate-400">Super Admin Workspace</p>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-lg bg-slate-800 hover:bg-red-500/10 hover:text-red-400 text-slate-300 text-sm font-medium transition">
                Logout
            </button>
        </form>
    </header>

    <main class="max-w-6xl mx-auto p-8 space-y-8">

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Banner Info -->
        <div class="p-6 rounded-2xl bg-gradient-to-r from-indigo-950 to-slate-900 border border-indigo-500/20">
            <h2 class="text-xl font-bold text-white mb-1">Kelola Akun Guru</h2>
            <p class="text-sm text-slate-400">Tambahkan akun baru untuk guru agar bisa masuk ke Dashboard Pengelola Kuis & Materi.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Tambah Guru -->
            <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 h-fit space-y-4">
                <h3 class="font-bold text-lg text-white">Buat Akun Guru Baru</h3>
                <form action="{{ route('admin.guru.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Contoh: Budi Santoso, S.Kom" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sm text-white focus:outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Alamat Email</label>
                        <input type="email" name="email" required placeholder="guru@sekolah.sch.id" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sm text-white focus:outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Kata Sandi</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sm text-white focus:outline-none focus:border-indigo-500 pr-10">
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <script>
                        function togglePassword() {
                            const x = document.getElementById("password");
                            x.type = (x.type === "password") ? "text" : "password";
                        }
                    </script>
                    <button type="submit" class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 font-semibold text-sm text-white transition shadow-lg shadow-indigo-600/30">
                        Buat Akun Guru
                    </button>
                </form>
            </div>

            <!-- List Guru yang Ada -->
            <div class="lg:col-span-2 bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-lg text-white">Daftar Akun Guru Aktif</h3>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-slate-800 text-slate-300 font-medium">{{ $gurus->count() }} Guru</span>
                </div>

                <div class="divide-y divide-slate-800/60">
                    @forelse($gurus as $guru)
                        <div class="py-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-slate-800 text-indigo-400 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($guru->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-white">{{ $guru->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $guru->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 font-medium">Aktif</span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-500 text-sm">
                            Belum ada akun guru yang dibuat.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </main>

</body>
</html>
