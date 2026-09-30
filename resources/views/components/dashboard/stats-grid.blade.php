<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-space-md mb-space-lg">
    @php
        $stats = [
            [
                'icon' => 'menu_book',
                'label' => 'Total Modul',
                'value' => $totalModul,
                'bg' => '#007bb9',
                'iconBg' => 'rgba(255,255,255,0.15)',
                'iconColor' => '#ffffff',
                'textColor' => '#fdfcff',
                'subColor' => 'rgba(253,252,255,0.7)',
            ],
            [
                'icon' => 'assignment',
                'label' => 'Penugasan Aktif',
                'value' => $totalPenugasan,
                'sub'   => $totalPenugasan === 1 ? '1 kuis dipublish' : "$totalPenugasan kuis dipublish",
                'bg' => '#39b8fd',
                'iconBg' => 'rgba(255,255,255,0.15)',
                'iconColor' => '#ffffff',
                'textColor' => '#001e2f',
                'subColor' => 'rgba(0,30,47,0.65)',
            ],
            [
                'icon' => 'quiz',
                'label' => 'Rata-rata Kuis',
                'value' => number_format($rataRataNilaiKuis, 1),
                'bg' => '#00855b',
                'iconBg' => 'rgba(255,255,255,0.15)',
                'iconColor' => '#ffffff',
                'textColor' => '#f5fff6',
                'subColor' => 'rgba(245,255,246,0.7)',
            ],
            [
                'icon' => 'code',
                'label' => 'Nilai Lab Rata-rata',
                'value' => number_format($rataRataNilaiLab, 1),
                'bg' => '#dce9ff',
                'iconBg' => 'rgba(0,97,148,0.12)',
                'iconColor' => '#006194',
                'textColor' => '#0b1c30',
                'subColor' => 'rgba(11,28,48,0.6)',
            ],
            [
                'icon' => 'bug_report',
                'label' => 'Error Kode Terdeteksi',
                'value' => $totalErrorKode,
                'bg' => '#ffdad6',
                'iconBg' => 'rgba(186,26,26,0.1)',
                'iconColor' => '#ba1a1a',
                'textColor' => '#93000a',
                'subColor' => 'rgba(147,0,10,0.65)',
            ],
        ];
    @endphp

    @foreach($stats as $stat)
        <div class="rounded-2xl p-space-md shadow-sm hover:shadow-md transition-shadow"
             style="background-color: {{ $stat['bg'] }};">
            <div class="flex items-center justify-between mb-space-sm">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                     style="background-color: {{ $stat['iconBg'] }};">
                    <span class="material-symbols-outlined text-[24px]"
                          style="color: {{ $stat['iconColor'] }};">{{ $stat['icon'] }}</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="font-headline-xl text-headline-xl font-bold"
                      style="color: {{ $stat['textColor'] }};">{{ $stat['value'] }}</span>
                <span class="font-body-sm text-body-sm mt-1"
                      style="color: {{ $stat['subColor'] }};">{{ $stat['label'] }}</span>
                @if(!empty($stat['sub']))
                    <span class="font-label-badge text-label-badge mt-1"
                          style="color: {{ $stat['subColor'] }};">{{ $stat['sub'] }}</span>
                @endif
            </div>
        </div>
    @endforeach
</div>
