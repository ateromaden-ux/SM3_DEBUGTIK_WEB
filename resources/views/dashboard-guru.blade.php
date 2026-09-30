{{--
    Dashboard Guru — DebugTIK
    ─────────────────────────────────────────────────────────────────────────────
    Halaman ini hanya merangkai partial dan meload JavaScript.
    Untuk mengubah tampilan, cari di folder: resources/views/dashboard/
      ├── partials/sidebar.blade.php      ← Navigasi kiri
      ├── partials/header.blade.php       ← Header bar atas
      ├── tabs/tab-dashboard.blade.php    ← Tab Dasbor Utama
      ├── tabs/tab-kelola-materi.blade.php
      ├── tabs/tab-rekap.blade.php
      ├── tabs/tab-pengaturan.blade.php
      ├── modals/modal-materi.blade.php   ← Modal tambah/edit materi
      └── modals/modal-lab.blade.php      ← Modal tambah/edit lab
    Untuk JavaScript, lihat: public/js/pages/dashboard.js
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="shell-type" content="web_dashboard"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet"/>
    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
            body { overscroll-behavior: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child  { margin-bottom: 0 !important; }
        }
        ::-webkit-scrollbar { display: none; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('layouts.partials.tailwind-config')
    <title>Dasbor Guru - DebugTIK</title>
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface">

{{-- ── Sidebar ── --}}
@include('dashboard.partials.sidebar')

<div class="pl-72 min-w-0 overflow-hidden">

    {{-- ── Header ── --}}
    @include('dashboard.partials.header')

    {{-- ── Konten tab ── --}}
    <main class="w-full pt-16 bg-surface min-h-screen px-space-lg py-space-lg">
        @include('dashboard.tabs.tab-dashboard')
        @include('dashboard.tabs.tab-kelola-materi')
        @include('dashboard.tabs.tab-rekap')
        @include('dashboard.tabs.tab-pengaturan')
    </main>
</div>

{{-- ── Modal Materi ── --}}
@include('dashboard.modals.modal-materi')

{{-- ── Modal Lab Praktik ── --}}
@include('dashboard.modals.modal-lab')

{{-- ── JavaScript: shared utilities + logika halaman dashboard ── --}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/pages/dashboard.js') }}"></script>

</body>
</html>
