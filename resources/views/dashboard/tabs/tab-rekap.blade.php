{{--
    Tab: Rekap Nilai
    Variabel: $progressSiswa
--}}
<div id="view-rekap" class="view-section hidden">

    <div class="mb-space-lg">
        <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface">Rekap Nilai</h1>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-2xs">
            Progres dan nilai siswa per materi.
        </p>
    </div>

    <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-on-surface-variant font-body-sm text-body-sm font-medium border-b border-outline-variant/20">
                        <th class="py-space-md px-space-lg">Siswa</th>
                        <th class="py-space-md px-space-md">Materi</th>
                        <th class="py-space-md px-space-md">Progres</th>
                        <th class="py-space-md px-space-md text-right">Kuis</th>
                        <th class="py-space-md px-space-md text-right">Lab</th>
                        <th class="py-space-md px-space-lg">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10 text-on-surface font-body-md text-body-md">
                    @forelse($progressSiswa as $progress)
                    <tr class="hover:bg-surface-container-low/60 transition-colors">
                        <td class="py-space-md px-space-lg">
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $progress->user->name ?? 'Siswa' }}</span>
                                <span class="font-body-sm text-body-sm text-outline">
                                    {{ $progress->user->kelas ?? '-' }} · SIS-{{ str_pad($progress->user_id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </td>
                        <td class="py-space-md px-space-md font-body-sm text-body-sm text-on-surface-variant">
                            {{ $progress->materi->judul ?? '-' }}
                        </td>
                        <td class="py-space-md px-space-md">
                            <div class="flex items-center gap-space-xs">
                                <div class="w-24 bg-surface-container-high h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full rounded-full" style="width: {{ min(100, max(0, $progress->persentase_selesai)) }}%"></div>
                                </div>
                                <span class="font-code-inline text-code-inline text-on-surface-variant">{{ $progress->persentase_selesai }}%</span>
                            </div>
                        </td>
                        <td class="py-space-md px-space-md text-right font-code-inline text-code-inline">
                            {{ $progress->nilai_kuis ?? '-' }}
                        </td>
                        <td class="py-space-md px-space-md text-right font-code-inline text-code-inline">
                            {{ $progress->nilai_lab ?? '-' }}
                        </td>
                        <td class="py-space-md px-space-lg">
                            @if($progress->status_selesai)
                                <span class="inline-flex items-center gap-1 px-space-xs py-1 rounded-full bg-tertiary/10 text-tertiary font-label-badge text-label-badge font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> Lulus
                                </span>
                            @elseif($progress->status === 'selesai')
                                <span class="inline-flex items-center gap-1 px-space-xs py-1 rounded-full bg-error-container text-error font-label-badge text-label-badge font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Belum lulus
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-space-xs py-1 rounded-full bg-surface-container-high text-on-surface-variant font-label-badge text-label-badge font-bold">
                                    Berjalan
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-space-xl px-space-lg text-center font-body-sm text-body-sm text-outline">
                            Belum ada data nilai siswa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>