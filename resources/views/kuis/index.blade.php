
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
    @include('layouts.partials.tailwind-config')
    <title>Kelola Soal Kuis — {{ $materi->judul }}</title>
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface h-screen overflow-hidden">

{{-- ── Sidebar ── --}}
@include('kuis.partials.sidebar')

{{-- ── Konten utama ── --}}
<div class="pl-72 h-screen flex flex-col min-w-0 overflow-hidden">

    {{-- Header --}}
    @include('kuis.partials.header')

    {{-- Body: panel kiri + panel kanan --}}
    <div class="flex-1 flex overflow-hidden">

        {{-- Panel Kiri: pengaturan + daftar soal --}}
        <div class="w-80 flex-shrink-0 border-r border-outline-variant/20 flex flex-col bg-surface-container-lowest overflow-hidden">
            @include('kuis.partials.panel-settings')
            @include('kuis.partials.panel-soal-list')
        </div>

        {{-- Panel Kanan: editor soal --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-surface-container-low">
            @include('kuis.partials.soal-editor')
        </div>
    </div>
</div>

{{-- Toast notification --}}
<div id="toast" class="fixed bottom-6 right-6 z-[200] hidden items-center gap-2 px-4 py-3 rounded-xl shadow-lg font-body-sm text-body-sm font-medium transition-all"></div>

{{-- Modal Simulasi (Livewire kuis-player) --}}
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

{{-- Data dari server untuk dipakai JavaScript --}}
<script>
    const CSRF       = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const MATERI_ID  = {{ $materi->id }};
    const MATERI_ID_PAGE = {{ $materi->id }};

    // Soal data di-inject server agar form load tanpa fetch ulang
    let soalData = @json($soalList->keyBy('id'));
</script>

{{-- JavaScript: shared utilities + logika halaman kuis --}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/pages/kuis-editor.js') }}"></script>

<script>
    function bukaSimulasi() {
        document.getElementById('modal-simulasi').classList.remove('hidden');
    }
    function tutupSimulasi() {
        document.getElementById('modal-simulasi').classList.add('hidden');
        window.location.reload();
    }

    // Lock controls jika kuis sudah published saat load
    @if($settings && $settings->isPublished())
    (function () {
        const ids = ['btn-soal-baru', 'btn-save-settings', 'btn-simpan', 'btn-hapus'];
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.disabled = true; }
        });
        document.querySelectorAll('.soal-item button').forEach(b => {
            b.disabled = true;
            b.classList.add('opacity-30');
        });
    })();
    @endif
</script>

</body>
</html>
