{{--
    Modal: Lihat File Lampiran Materi
    Dipanggil via JS: lihatFileLampiran(materiId, judulMateri)
--}}
<div id="file-viewer-modal" class="fixed inset-0 z-[100] bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-space-md">
    <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full shadow-xl flex flex-col max-h-[80vh]">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-shrink-0 px-space-lg pt-space-lg pb-space-md border-b border-outline-variant/20">
            <div class="flex items-center gap-space-xs">
                <div class="w-9 h-9 rounded-xl bg-secondary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary text-[20px]">folder_open</span>
                </div>
                <div>
                    <h3 class="font-title-sm text-title-sm font-bold text-on-surface">File Lampiran</h3>
                    <p class="font-body-sm text-body-sm text-outline" id="file-viewer-judul">—</p>
                </div>
            </div>
            <button onclick="tutupFileViewer()"
                class="w-8 h-8 rounded-full bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        {{-- Konten file list --}}
        <div id="file-viewer-body" class="flex-1 overflow-y-auto px-space-lg py-space-md flex flex-col gap-space-xs">
            {{-- Diisi oleh JS --}}
            <div id="file-viewer-loading" class="flex items-center justify-center py-10 gap-space-sm text-outline">
                <span class="material-symbols-outlined text-[20px] animate-spin">sync</span>
                <span class="font-body-sm text-body-sm">Memuat file...</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex-shrink-0 px-space-lg py-space-md border-t border-outline-variant/20 flex justify-end">
            <button onclick="tutupFileViewer()"
                class="px-space-md py-space-sm rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-body-sm text-body-sm transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>
