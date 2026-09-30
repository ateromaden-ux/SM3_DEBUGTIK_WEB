<!-- Student Progress Table Section -->
<div class="xl:col-span-7">
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-surface-container-low px-space-lg py-space-md flex items-center justify-between border-b border-outline-variant/20">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[24px]">assignment_ind</span>
                <h2 class="font-headline-md text-headline-md font-bold text-on-surface">Progres Siswa Terkini</h2>
            </div>
            <button class="text-primary font-body-sm text-body-sm font-semibold hover:underline">Lihat Semua</button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-low/50 text-on-surface-variant font-body-sm text-body-sm font-medium">
                        <th class="text-left px-space-lg py-space-sm">Nama Siswa</th>
                        <th class="text-left px-space-sm py-space-sm">Kelas</th>
                        <th class="text-left px-space-sm py-space-sm">Materi Terakhir</th>
                        <th class="text-left px-space-sm py-space-sm">Progress</th>
                        <th class="text-left px-space-sm py-space-sm">Status</th>
                        <th class="text-right px-space-lg py-space-sm">Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @foreach($progressSiswa as $progress)
                        <tr class="hover:bg-surface-container-low/30 transition-colors">
                            <td class="px-space-lg py-space-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr($progress->user->name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-body-md text-body-md font-semibold text-on-surface">{{ $progress->user->name }}</span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $progress->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-space-sm py-space-sm">
                                <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $progress->user->kelas ?? 'X RPL' }}</span>
                            </td>
                            <td class="px-space-sm py-space-sm">
                                <span class="font-body-sm text-body-sm text-on-surface">{{ $progress->materi->judul }}</span>
                            </td>
                            <td class="px-space-sm py-space-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 bg-surface-container-low rounded-full overflow-hidden">
                                        <div class="h-full bg-primary rounded-full" style="width: {{ $progress->persentase_selesai }}%"></div>
                                    </div>
                                    <span class="font-code-inline text-code-inline text-on-surface-variant">{{ $progress->persentase_selesai }}%</span>
                                </div>
                            </td>
                            <td class="px-space-sm py-space-sm">
                                @if($progress->status_selesai)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-tertiary-container text-on-tertiary-container font-body-sm text-body-sm font-medium">
                                        <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-surface-container-high text-on-surface font-body-sm text-body-sm font-medium">
                                        <span class="material-symbols-outlined text-[14px]">pending</span>
                                        Progres
                                    </span>
                                @endif
                            </td>
                            <td class="px-space-lg py-space-sm text-right">
                                <span class="font-headline-md text-headline-md font-bold text-primary">{{ $progress->nilai_akhir ?? '-' }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
