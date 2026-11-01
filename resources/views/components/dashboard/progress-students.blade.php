<!-- Progres Siswa Terkini -->
<div class="xl:col-span-7">
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
        <div class="px-space-lg py-space-md flex items-center justify-between border-b border-outline-variant/20">
            <h2 class="font-headline-md text-headline-md font-bold text-on-surface">Progres Siswa Terkini</h2>
            <button type="button" onclick="switchTab('rekap')"
                    class="text-primary font-body-sm text-body-sm font-semibold hover:underline">Lihat semua</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-on-surface-variant font-body-sm text-body-sm font-medium">
                        <th class="text-left px-space-lg py-space-sm">Siswa</th>
                        <th class="text-left px-space-sm py-space-sm">Materi</th>
                        <th class="text-left px-space-sm py-space-sm">Progres</th>
                        <th class="text-right px-space-lg py-space-sm">Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @forelse($progressSiswa->take(5) as $progress)
                        <tr class="hover:bg-surface-container-low/30 transition-colors">
                            <td class="px-space-lg py-space-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr($progress->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-body-md text-body-md font-semibold text-on-surface">{{ $progress->user->name ?? 'Siswa' }}</span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $progress->user->kelas ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-space-sm py-space-sm">
                                <span class="font-body-sm text-body-sm text-on-surface">{{ $progress->materi->judul ?? '-' }}</span>
                            </td>
                            <td class="px-space-sm py-space-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 bg-surface-container-low rounded-full overflow-hidden">
                                        <div class="h-full bg-primary rounded-full" style="width: {{ min(100, max(0, $progress->persentase_selesai)) }}%"></div>
                                    </div>
                                    <span class="font-code-inline text-code-inline text-on-surface-variant">{{ $progress->persentase_selesai }}%</span>
                                </div>
                            </td>
                            <td class="px-space-lg py-space-sm text-right">
                                <span class="font-headline-md text-headline-md font-bold text-primary">{{ $progress->nilai_akhir ?? '-' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-space-lg py-space-xl text-center font-body-sm text-body-sm text-outline">
                                Belum ada aktivitas siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>