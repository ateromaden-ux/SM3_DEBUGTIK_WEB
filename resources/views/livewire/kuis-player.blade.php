<div class="min-h-screen bg-indigo-900 text-white flex flex-col items-center justify-center p-6" wire:poll.1s="timerTick">

    @if(!$showResult)
        <!-- Header -->
        <div class="w-full max-w-lg flex justify-between items-center mb-8">
            <span class="font-bold text-lg">Soal {{ $currentIndex + 1 }}/{{ count($questions) }}</span>
            <div class="bg-indigo-800 px-4 py-1 rounded-full font-mono text-xl">{{ $timer }}s</div>
        </div>

        <!-- Progress Bar -->
        <div class="w-full max-w-lg bg-indigo-800 h-2 rounded-full mb-8 overflow-hidden">
            <div class="bg-yellow-400 h-full transition-all duration-300" style="width: {{ ($timer / 15) * 100 }}%"></div>
        </div>

        <!-- Soal -->
        <div class="bg-white text-indigo-900 p-8 rounded-3xl w-full max-w-lg text-center shadow-2xl mb-8">
            <h2 class="text-2xl font-bold">{{ $questions[$currentIndex]->pertanyaan }}</h2>
        </div>

        <!-- Pilihan -->
        <div class="grid grid-cols-1 gap-4 w-full max-w-lg">
            @foreach($questions[$currentIndex]->opsi_jawaban as $o)
                <button wire:click="selectAnswer('{{ $o }}')"
                    class="p-4 rounded-xl font-bold text-left transition-all border-2 
                    {{ $isAnswered 
                        ? ($o == $questions[$currentIndex]->kunci_jawaban ? 'bg-green-500 border-green-600' : ($selected == $o ? 'bg-red-500 border-red-600' : 'bg-white/10 border-white/20')) 
                        : 'bg-white text-indigo-900 hover:scale-[1.02] border-transparent' }}">
                    {{ $o }}
                </button>
            @endforeach
        </div>

        @if($isAnswered)
            <button wire:click="next" class="mt-8 bg-yellow-400 text-indigo-900 px-10 py-3 rounded-full font-bold text-lg shadow-lg">
                {{ $currentIndex + 1 == count($questions) ? 'Lihat Hasil' : 'Lanjut' }}
            </button>
        @endif
    @else
        <!-- Hasil -->
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Kuis Selesai!</h1>
            <p class="text-xl mb-6">Skor Akhir Kamu:</p>
            <div class="text-6xl font-black text-yellow-400 mb-8">{{ $score }}</div>
            <a href="{{ route('dashboard') }}" class="bg-white text-indigo-900 px-8 py-3 rounded-full font-bold">Kembali ke Dasbor</a>
        </div>
    @endif
</div>
