{{--
    Tab: Rekap Nilai & Evaluasi
    Variabel: $progressSiswa
--}}
<div id="view-rekap" class="view-section hidden">

    {{-- Header + tombol aksi --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-sm mb-space-lg">
        <div class="flex flex-col gap-space-2xs">
            <div class="flex items-center gap-space-xs">
                <span class="px-space-xs py-0.5 rounded-full bg-surface-container text-primary font-label-badge text-label-badge">ERD_EVALUATION_SCHEMA_V2</span>
                <span class="text-outline font-label-badge text-label-badge">•</span>
                <span class="font-label-badge text-label-badge text-outline">SMK TI GARUDA TEKNIKA</span>
            </div>
            <h1 class="font-headline-xl text-headline-xl font-bold tracking-tight text-on-surface">Rekap Nilai & Evaluasi Pembelajaran TIK</h1>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-3xl">
                Evaluasi Hasil Belajar Siswa Berdasarkan Progres Materi, Nilai Kuis
                (<code class="font-code-inline text-code-inline text-primary bg-surface-container-low px-1 py-0.5 rounded">nilai_kuis</code>),
                dan Skor Debug Lab
                (<code class="font-code-inline text-code-inline text-primary bg-surface-container-low px-1 py-0.5 rounded">nilai_lab</code>).
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-space-sm">
            <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface font-title-sm text-title-sm shadow-sm transition-all"
                    type="button">
                <span class="material-symbols-outlined text-[18px] text-primary">download</span>
                Ekspor Rekap (Excel/PDF)
            </button>
            <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded-xl bg-primary hover:bg-primary-container text-on-primary font-title-sm text-title-sm shadow-md transition-all"
                    type="button">
                <span class="material-symbols-outlined text-[18px]">send</span>
                Kirim Raport ke Akun Siswa
            </button>
        </div>
    </div>

    {{-- Tabel rekap --}}
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
                                    <div class="bg-tertiary h-full rounded-full" style="width:100%"></div>
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
                            <button class="inline-flex items-center gap-space-2xs px-space-sm py-1.5 rounded-xl bg-surface-container-low hover:bg-primary hover:text-on-primary text-on-surface-variant text-body-sm font-medium transition-all shadow-sm"
                                    type="button">
                                <span class="material-symbols-outlined text-[16px]">history_edu</span>
                                Buka Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
