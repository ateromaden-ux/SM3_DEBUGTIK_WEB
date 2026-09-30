{{--
    Komponen: Kelola Materi — ditampilkan di tab Dasbor Utama.
    Variabel: $materiList (Collection MateriBelajar)
--}}
<div class="xl:col-span-5">
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="bg-surface-container-low px-space-lg py-space-md flex items-center justify-between border-b border-outline-variant/20">
            <div class="flex items-center gap-space-xs">
                <span class="material-symbols-outlined text-secondary text-[24px]">menu_book</span>
                <h2 class="font-headline-md text-headline-md font-bold text-on-surface">Kelola Materi</h2>
            </div>
            {{-- Tambah Materi → buka modal --}}
            <button
                onclick="toggleModal(true)"
                class="flex items-center gap-space-2xs text-secondary font-body-sm text-body-sm font-semibold hover:underline transition-colors">
                <span class="material-symbols-outlined text-[16px]">add_circle</span>
                Tambah Materi
            </button>
        </div>

        {{-- List materi --}}
        <div class="divide-y divide-outline-variant/10">
            @forelse($materiList as $materi)
            @php
                $colors  = ['primary','secondary','tertiary'];
                $icons   = ['code','storage','terminal','dataset','menu_book'];
                $color   = $colors[$loop->index % 3];
                $icon    = $icons[$loop->index % 5];
                $waktu   = $materi->estimasi_waktu == 0 ? 'Tak Terbatas' : $materi->estimasi_waktu . ' menit';
                $jumlahSoal = $materi->kuis->count();
                $isPublished = $materi->kuisSettings?->isPublished();
            @endphp
            <div class="group flex items-center gap-space-sm px-space-lg py-space-md hover:bg-surface-container-low transition-colors cursor-pointer"
                 onclick="switchTab('kelola-materi')">>

                {{-- Ikon materi --}}
                <div class="w-10 h-10 rounded-xl bg-{{ $color }}/10 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-{{ $color }} text-[20px]">{{ $icon }}</span>
                </div>

                {{-- Info materi --}}
                <div class="flex flex-col flex-1 min-w-0">
                    <span class="font-body-md text-body-md font-semibold text-on-surface truncate">{{ $materi->judul }}</span>
                    @if($materi->deskripsi)
                    <span class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs line-clamp-1">{{ $materi->deskripsi }}</span>
                    @endif
                    <div class="flex items-center gap-space-sm mt-space-xs flex-wrap">
                        <span class="font-label-badge text-label-badge text-outline">{{ $materi->kategori }}</span>
                        <span class="text-outline-variant">•</span>
                        <span class="font-label-badge text-label-badge text-outline">{{ $waktu }}</span>
                        <span class="text-outline-variant">•</span>
                        <span class="font-label-badge text-label-badge {{ $jumlahSoal > 0 ? 'text-secondary' : 'text-outline' }}">
                            {{ $jumlahSoal }} soal
                        </span>
                        @if($isPublished)
                        <span class="flex items-center gap-space-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                            <span class="font-label-badge text-label-badge text-tertiary font-bold">Published</span>
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Tombol aksi --}}
                <div class="flex items-center gap-space-xs flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                    {{-- Edit --}}
                    <button
                        type="button"
                        title="Edit materi"
                        onclick="event.stopPropagation(); openEditorModal(
                            '{{ $materi->id }}',
                            '{{ addslashes($materi->id_materi) }}',
                            '{{ addslashes($materi->judul) }}',
                            '{{ $materi->kategori }}',
                            '{{ $materi->level }}',
                            {{ $materi->estimasi_waktu }},
                            '{{ addslashes($materi->deskripsi ?? '') }}'
                        )"
                        class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                    </button>
                    {{-- Kelola soal kuis --}}
                    <a
                        href="{{ route('kuis.page', $materi->id) }}"
                        title="Kelola soal kuis"
                        onclick="event.stopPropagation()"
                        class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-secondary/10 hover:text-secondary transition-colors">
                        <span class="material-symbols-outlined text-[16px]">quiz</span>
                    </a>
                    {{-- Hapus --}}
                    <button
                        type="button"
                        title="Hapus materi"
                        onclick="event.stopPropagation(); deleteMateri('{{ $materi->id }}')"
                        class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors">
                        <span class="material-symbols-outlined text-[16px]">delete</span>
                    </button>
                </div>

                {{-- Panah navigasi --}}
                <span class="material-symbols-outlined text-outline text-[18px] flex-shrink-0 group-hover:text-secondary transition-colors">chevron_right</span>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-10 gap-space-sm text-center px-space-lg">
                <span class="material-symbols-outlined text-outline text-[40px]">menu_book</span>
                <p class="font-body-sm text-body-sm text-outline">Belum ada materi.<br>Klik "Tambah Materi" untuk mulai.</p>
                <button
                    onclick="toggleModal(true)"
                    class="flex items-center gap-space-xs px-space-md py-space-sm rounded-xl bg-primary text-on-primary font-body-sm text-body-sm font-semibold hover:opacity-90 transition-opacity shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">add_circle</span>
                    Tambah Materi Pertama
                </button>
            </div>
            @endforelse
        </div>

        {{-- Footer: link ke tab kelola materi lengkap --}}
        @if($materiList->count() > 0)
        <div class="border-t border-outline-variant/10 px-space-lg py-space-sm">
            <button
                onclick="switchTab('kelola-materi')"
                class="w-full text-center font-body-sm text-body-sm text-secondary hover:underline font-semibold transition-colors py-space-xs">
                Lihat Semua Materi →
            </button>
        </div>
        @endif
    </div>
</div>
