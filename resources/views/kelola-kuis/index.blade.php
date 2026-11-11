<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        @layer base { html, body { margin: 0; padding: 0; } body { overscroll-behavior: none; } }
        ::-webkit-scrollbar { display: none; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('layouts.partials.tailwind-config')
    <title>Kelola Kuis — DebugTIK</title>
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface">

{{-- ── Sidebar ── --}}
<aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest z-50 flex flex-col shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="flex flex-col flex-1 overflow-hidden">
        <div class="h-16 px-space-lg flex items-center flex-shrink-0">
            <div class="flex flex-col leading-none ml-space-xs">
                <span class="font-headline-md text-headline-md font-bold tracking-tight text-on-surface">Debug<span class="text-primary">TIK</span></span>
                <span class="font-label-badge text-label-badge text-outline tracking-wider uppercase mt-space-2xs">Portal Guru</span>
            </div>
        </div>
        <nav class="flex flex-col gap-space-2xs px-space-md mt-space-sm flex-shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
                <span class="font-body-md text-body-md">Dasbor Utama</span>
            </a>
            <a href="{{ url('/dashboard?tab=kelola-materi') }}" class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">library_books</span>
                <span class="font-body-md text-body-md">Kelola Materi Belajar</span>
            </a>
            <div class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl bg-secondary/10 text-secondary font-semibold">
                <span class="material-symbols-outlined text-[20px]">quiz</span>
                <span class="font-body-md text-body-md">Kelola Kuis</span>
            </div>
            <a href="{{ url('/dashboard?tab=rekap') }}" class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">assessment</span>
                <span class="font-body-md text-body-md">Rekap Nilai</span>
            </a>
            <a href="{{ url('/dashboard?tab=pengaturan') }}" class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                <span class="font-body-md text-body-md">Pengaturan</span>
            </a>
        </nav>

        {{-- List kuis di sidebar --}}
        @if($kuisList->isNotEmpty())
        <div class="mt-space-md px-space-md flex-1 overflow-y-auto">
            <span class="font-label-badge text-label-badge uppercase text-outline px-space-sm">Kuis Saya</span>
            <div class="flex flex-col gap-space-2xs mt-space-xs">
                @foreach($kuisList as $k)
                <a href="{{ route('kuis.page', $k->id) }}"
                   class="flex items-center gap-space-xs px-space-sm py-space-xs rounded-lg text-on-surface-variant hover:bg-secondary/10 hover:text-secondary transition-colors">
                    <span class="material-symbols-outlined text-[14px] flex-shrink-0">quiz</span>
                    <span class="font-body-sm text-body-sm truncate flex-1">{{ $k->nama_kuis ?? $k->id_kuis }}</span>
                    @if($k->isPublished())
                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary flex-shrink-0"></span>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    {{-- Status engine dihapus --}}
</aside>

{{-- ── Konten Utama ── --}}
<div class="pl-72 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="h-16 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] px-space-xl flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-secondary text-[22px]">quiz</span>
            <div>
                <h1 class="font-title-sm text-title-sm font-bold text-on-surface">Kelola Kuis</h1>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Buat dan kelola kuis secara mandiri</p>
            </div>
        </div>
        <div class="flex items-center gap-space-sm">
            <button onclick="toggleFormBuatKuis()"
                class="flex items-center gap-space-xs px-space-md py-space-sm rounded-xl bg-secondary text-on-secondary font-body-sm text-body-sm font-semibold hover:opacity-90 shadow-sm transition-all active:scale-95">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Buat Kuis Baru
            </button>
            <span class="font-title-sm text-title-sm font-semibold text-on-surface">{{ $guru->name }}</span>
            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center overflow-hidden">
                @if($guru->foto_profil)
                    <img src="{{ Storage::disk('public')->url($guru->foto_profil) }}" class="w-full h-full object-cover"/>
                @else
                    <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                @endif
            </div>
        </div>
    </header>

    <main class="flex-1 px-space-xl py-space-lg flex flex-col gap-space-lg">

        {{-- Flash success --}}
        @if(session('success'))
        <div class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl bg-tertiary/10 border border-tertiary/20 text-tertiary font-body-sm text-body-sm font-semibold">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            {{ session('success') }}
        </div>
        @endif

        {{-- ── FORM BUAT KUIS BARU ── --}}
        <div id="form-buat-kuis" class="hidden bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden border-2 border-secondary/20">
            <div class="px-space-lg py-space-md border-b border-outline-variant/20 flex items-center justify-between bg-secondary/5">
                <div class="flex items-center gap-space-xs">
                    <span class="material-symbols-outlined text-secondary text-[20px]">add_circle</span>
                    <h2 class="font-title-sm text-title-sm font-bold text-on-surface">Buat Kuis Baru</h2>
                </div>
                <button onclick="toggleFormBuatKuis()" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>

            <form action="{{ route('kelola-kuis.store') }}" method="POST" class="p-space-lg flex flex-col gap-space-md">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                    {{-- Nama Kuis --}}
                    <div class="flex flex-col gap-space-2xs">
                        <label class="font-label-badge text-label-badge uppercase text-outline">Nama Kuis <span class="text-error">*</span></label>
                        <input name="nama_kuis" type="text" required
                            placeholder="Contoh: Ulangan Harian HTML"
                            value="{{ old('nama_kuis') }}"
                            class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary"/>
                        @error('nama_kuis')<p class="font-body-sm text-body-sm text-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- ID Kuis --}}
                    <div class="flex flex-col gap-space-2xs">
                        <label class="font-label-badge text-label-badge uppercase text-outline">ID Kuis (unik) <span class="text-error">*</span></label>
                        <input name="id_kuis" type="text" required
                            placeholder="Contoh: KUIS-HTML-2024"
                            value="{{ old('id_kuis') }}"
                            class="h-10 px-space-sm rounded-xl bg-surface-container-low border border-outline-variant/30 font-code-inline text-code-inline text-on-surface focus:outline-none focus:border-secondary"/>
                        @error('id_kuis')<p class="font-body-sm text-body-sm text-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex flex-col gap-space-2xs">
                    {{-- KKM --}}
                    <label class="font-label-badge text-label-badge uppercase text-outline">KKM (%) <span class="text-error">*</span></label>
                    <div class="flex items-center gap-space-sm h-10">
                        <input name="kkm" type="range" min="0" max="100" value="{{ old('kkm', 70) }}"
                            class="flex-1 accent-secondary cursor-pointer"
                            oninput="document.getElementById('kkm-val').textContent = this.value + '%'"/>
                        <span id="kkm-val" class="w-12 text-right font-code-inline text-code-inline font-bold text-secondary">{{ old('kkm', 70) }}%</span>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="flex flex-col gap-space-2xs">
                    <label class="font-label-badge text-label-badge uppercase text-outline">Deskripsi <span class="text-outline font-normal">(opsional)</span></label>
                    <textarea name="deskripsi" rows="2"
                        placeholder="Keterangan singkat tentang kuis ini..."
                        class="w-full px-space-sm py-space-xs rounded-xl bg-surface-container-low border border-outline-variant/30 font-body-sm text-body-sm text-on-surface focus:outline-none resize-none">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="flex justify-end gap-space-sm pt-space-xs border-t border-outline-variant/20">
                    <button type="button" onclick="toggleFormBuatKuis()"
                        class="px-space-md py-space-sm rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-body-sm text-body-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex items-center gap-space-xs px-space-xl py-space-sm rounded-xl bg-secondary text-on-secondary font-body-sm text-body-sm font-semibold hover:opacity-90 shadow-sm transition-all active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        Buat & Mulai Tambah Soal
                    </button>
                </div>
            </form>
        </div>

        {{-- ── Stats ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md">
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                <span class="font-label-badge text-label-badge uppercase text-outline">Total Kuis</span>
                <div class="flex items-baseline gap-space-xs mt-space-xs">
                    <span class="font-headline-lg text-headline-lg font-bold text-on-surface">{{ $stats['total_kuis'] }}</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                <span class="font-label-badge text-label-badge uppercase text-outline">Total Soal</span>
                <div class="flex items-baseline gap-space-xs mt-space-xs">
                    <span class="font-headline-lg text-headline-lg font-bold text-secondary">{{ $stats['total_soal'] }}</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                <span class="font-label-badge text-label-badge uppercase text-outline">Published</span>
                <div class="flex items-baseline gap-space-xs mt-space-xs">
                    <span class="font-headline-lg text-headline-lg font-bold text-tertiary">{{ $stats['total_published'] }}</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                <span class="font-label-badge text-label-badge uppercase text-outline">Draft</span>
                <div class="flex items-baseline gap-space-xs mt-space-xs">
                    <span class="font-headline-lg text-headline-lg font-bold text-outline">{{ $stats['total_draft'] }}</span>
                </div>
            </div>
        </div>

        {{-- ── Daftar Kuis ── --}}
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
            <div class="px-space-lg py-space-md border-b border-outline-variant/20">
                <h2 class="font-headline-md text-headline-md font-bold text-on-surface">Daftar Kuis</h2>
            </div>

            @if($kuisList->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 gap-space-md text-center">
                <div class="w-16 h-16 rounded-2xl bg-surface-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-outline text-[32px]">quiz</span>
                </div>
                <div>
                    <p class="font-title-sm text-title-sm font-semibold text-on-surface">Belum ada kuis</p>
                    <p class="font-body-sm text-body-sm text-outline mt-space-2xs">Klik "Buat Kuis Baru" untuk mulai membuat kuis pertama.</p>
                </div>
                <button onclick="toggleFormBuatKuis()"
                    class="flex items-center gap-space-xs px-space-lg py-space-sm rounded-xl bg-secondary text-on-secondary font-body-sm text-body-sm font-semibold hover:opacity-90 shadow-sm transition-all">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    Buat Kuis Pertama
                </button>
            </div>
            @else
            <div class="divide-y divide-outline-variant/10">
                @foreach($kuisList as $kuis)
                @php
                    $jumlahSoal  = $kuis->soal->count();
                    $isPublished = $kuis->isPublished();
                    $isDraft     = $kuis->isDraft();
                @endphp
                <a href="{{ route('kuis.page', $kuis->id) }}"
                   class="group flex items-center gap-space-md px-space-lg py-space-md hover:bg-surface-container-low transition-colors">

                    {{-- Ikon --}}
                    <div class="w-12 h-12 rounded-2xl bg-secondary/10 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-secondary text-[22px]">quiz</span>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-space-xs flex-wrap mb-space-2xs">
                            {{-- Status --}}
                            @if($isPublished)
                                <span class="flex items-center gap-1 px-space-xs py-0.5 rounded-full bg-tertiary/10">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                    <span class="font-label-badge text-label-badge text-tertiary font-bold">Published</span>
                                </span>
                            @elseif($isDraft)
                                <span class="flex items-center gap-1 px-space-xs py-0.5 rounded-full bg-outline/10">
                                    <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                                    <span class="font-label-badge text-label-badge text-outline">Draft</span>
                                </span>
                            @endif
                            {{-- Terhubung ke materi --}}
                            @if($kuis->materi)
                                <span class="px-space-xs py-0.5 rounded-full bg-primary/10 text-primary font-label-badge text-label-badge">
                                    {{ $kuis->materi->judul }}
                                </span>
                            @endif
                        </div>
                        <h3 class="font-title-sm text-title-sm font-semibold text-on-surface">
                            {{ $kuis->nama_kuis ?? $kuis->id_kuis }}
                        </h3>
                        @if($kuis->deskripsi)
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs line-clamp-1">{{ $kuis->deskripsi }}</p>
                        @endif
                        <div class="flex items-center gap-space-md mt-space-xs">
                            <span class="font-code-inline text-code-inline text-outline">{{ $kuis->id_kuis }}</span>
                            <span class="flex items-center gap-space-2xs {{ $jumlahSoal > 0 ? 'text-secondary' : 'text-outline' }}">
                                <span class="material-symbols-outlined text-[14px]">quiz</span>
                                <span class="font-label-badge text-label-badge">{{ $jumlahSoal }} soal</span>
                            </span>
                            <span class="font-label-badge text-label-badge text-outline">
                                KKM {{ $kuis->kkm }}%
                            </span>
                        </div>
                    </div>

                    {{-- Panah --}}
                    <div class="flex items-center gap-space-sm flex-shrink-0">
                        <span class="font-body-sm text-body-sm text-secondary opacity-0 group-hover:opacity-100 transition-opacity">Kelola Soal</span>
                        <span class="material-symbols-outlined text-outline text-[20px] group-hover:text-secondary transition-colors">chevron_right</span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>

    </main>
</div>

<script>
function toggleFormBuatKuis() {
    const form = document.getElementById('form-buat-kuis');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Auto-buka form jika ada error validasi
@if($errors->any())
document.addEventListener('DOMContentLoaded', () => toggleFormBuatKuis());
@endif
</script>

</body>
</html>
