<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DebugTIK - Login</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@500&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @include('layouts.partials.tailwind-config')
</head>

<body class="bg-white font-body-md text-on-surface min-h-screen antialiased">
<div class="w-full min-h-screen grid grid-cols-1 lg:grid-cols-12">

    <!-- Kolom kiri: branding -->
    <section class="hidden lg:flex lg:col-span-7 bg-gradient-to-br from-sky-50 via-blue-50/60 to-indigo-50/40 p-14 xl:p-16 flex-col justify-between border-r border-slate-200/80">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-lg shadow-slate-900/10">
                <span class="material-symbols-outlined text-2xl text-sky-400">terminal</span>
            </div>
            <div>
                <span class="font-headline-lg text-2xl font-bold tracking-tight text-slate-900">Debug<span class="text-primary font-extrabold">TIK</span></span>
                <p class="text-xs text-slate-500 font-medium">Portal Guru & Administrator Lab TIK</p>
            </div>
        </div>

        <div class="max-w-xl">
            <h1 class="font-headline-xl text-4xl xl:text-5xl font-bold text-slate-900 leading-tight tracking-tight mb-4">
                Platform Pembelajaran & Praktik Debugging TIK
            </h1>
            <p class="text-base text-slate-600 leading-relaxed">
                Kelola materi, kuis, dan lab debugging, serta pantau progres siswa dalam satu tempat.
            </p>
        </div>

        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="material-symbols-outlined text-sm text-emerald-600">verified</span>
            <span>Standar Capaian Kurikulum TIK 2026</span>
        </div>
    </section>

    <!-- Kolom kanan: form -->
    <section class="lg:col-span-5 bg-white p-8 lg:p-12 xl:p-16 flex flex-col justify-between min-h-screen">

        <!-- Logo mobile -->
        <div class="w-full flex items-center gap-2 lg:hidden pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center">
                <span class="material-symbols-outlined text-base text-sky-400">terminal</span>
            </div>
            <span class="font-headline-lg text-lg font-bold text-slate-900">Debug<span class="text-primary">TIK</span></span>
        </div>

        <div class="w-full max-w-md my-auto py-4">
            <div class="mb-6">
                <h2 class="text-2xl font-bold font-headline-lg text-slate-900 mb-1.5">Masuk Portal Guru</h2>
                <p class="text-sm text-slate-500">Gunakan email dan kata sandi akun guru kamu.</p>
            </div>

            <form class="space-y-4" method="POST" action="{{ route('login') }}" id="login-form" novalidate>
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs uppercase tracking-wider text-slate-600 font-semibold mb-1.5">Email Guru</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg">mail</span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username" inputmode="email"
                               placeholder="nama.guru@sekolah.sch.id"
                               class="w-full pl-11 pr-4 py-2.5 rounded-lg border {{ $errors->has('email') ? 'border-red-500' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-primary focus:ring-2 focus:ring-sky-100 placeholder:text-slate-400 outline-none transition-all">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs uppercase tracking-wider text-slate-600 font-semibold mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg">lock</span>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="w-full pl-11 pr-11 py-2.5 rounded-lg border {{ $errors->has('password') ? 'border-red-500' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-primary focus:ring-2 focus:ring-sky-100 outline-none transition-all">
                        <button type="button" id="toggle-pw" aria-label="Tampilkan kata sandi"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors p-0.5">
                            <span class="material-symbols-outlined text-lg" id="toggle-pw-icon">visibility</span>
                        </button>
                    </div>
                    <p id="caps-warning" class="hidden mt-1 text-xs text-red-600">Caps Lock sedang aktif.</p>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ingat saya -->
                <label class="flex items-center gap-2.5 cursor-pointer select-none pt-1">
                    <input type="checkbox" name="remember" checked class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/20">
                    <span class="text-xs text-slate-600">Ingat sesi di perangkat ini</span>
                </label>

                <button type="submit" id="submit-btn"
                        class="w-full mt-2 py-3 px-5 rounded-lg bg-primary hover:bg-[#007bb9] text-white text-sm font-semibold shadow-md shadow-sky-900/10 transition-all flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-lg">login</span>
                    <span id="btn-text">Masuk</span>
                </button>
            </form>

            <p class="mt-6 text-center text-xs text-slate-500">Belum punya akun? Hubungi admin sekolah.</p>
        </div>

        <div class="w-full max-w-md pt-6 border-t border-slate-100 text-xs text-slate-400">
            © 2026 DebugTIK Indonesia.
        </div>
    </section>
</div>

<script>
    const pw = document.getElementById('password');
    const icon = document.getElementById('toggle-pw-icon');

    document.getElementById('toggle-pw').addEventListener('click', () => {
        const hidden = pw.type === 'password';
        pw.type = hidden ? 'text' : 'password';
        icon.textContent = hidden ? 'visibility_off' : 'visibility';
    });

    pw.addEventListener('keyup', e => {
        document.getElementById('caps-warning')
            .classList.toggle('hidden', !e.getModifierState('CapsLock'));
    });

    document.getElementById('login-form').addEventListener('submit', function () {
        const b = document.getElementById('submit-btn');
        b.disabled = true;
        document.getElementById('btn-text').textContent = 'Memproses...';
    });

    @if($errors->has('password')) pw.focus(); @endif
</script>
</body>
</html>