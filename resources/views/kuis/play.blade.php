<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Kuis - {{ $materi->judul ?? 'Kuis' }}</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @include('layouts.partials.tailwind-config')
</head>
<body class="bg-surface font-body-md text-on-surface antialiased">

<div class="min-h-screen flex items-center justify-center p-space-md"
     x-data="kuisPlayer(@json($materi->kuis ?? []))">

    {{-- Loading state --}}
    <div x-show="loading" class="text-center">
        <div class="w-12 h-12 rounded-full border-4 border-primary/20 border-t-primary animate-spin mx-auto mb-space-md"></div>
        <p class="text-on-surface-variant">Mempersiapkan kuis...</p>
    </div>

    {{-- Quiz state --}}
    <template x-if="!loading && !finished">
        <div class="w-full max-w-2xl">
            {{-- Header: Progress & Timer --}}
            <div class="flex items-center justify-between mb-space-lg">
                <div>
                    <p class="text-body-sm text-on-surface-variant">Soal <span x-text="currentIndex + 1"></span> dari <span x-text="questions.length"></span></p>
                    <div class="w-48 h-2 rounded-full bg-surface-container mt-space-xs overflow-hidden">
                        <div class="h-full bg-primary transition-all duration-300" 
                             :style="`width: ${(currentIndex + 1) / questions.length * 100}%`"></div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-label-badge text-label-badge text-primary font-bold" x-text="`${timer}s`"></p>
                    <p class="text-body-sm text-on-surface-variant text-xs mt-space-2xs">Sisa waktu</p>
                </div>
            </div>

            {{-- Question card --}}
            <div class="bg-surface-container-lowest rounded-2xl p-space-lg mb-space-lg shadow-sm">
                <h2 class="font-headline-md text-headline-md text-on-surface font-bold mb-space-md" 
                    x-text="questions[currentIndex]?.pertanyaan || 'Pertanyaan'"></h2>
                
                {{-- Answer options --}}
                <div class="flex flex-col gap-space-sm">
                    <template x-for="(option, idx) in questions[currentIndex]?.opsi_jawaban || []" :key="idx">
                        <button @click="selectAnswer(option)"
                                :disabled="isAnswered"
                                class="p-space-md rounded-xl border-2 font-body-sm text-body-sm text-left transition-all"
                                :class="isAnswered
                                    ? (option === questions[currentIndex].kunci_jawaban 
                                        ? 'bg-tertiary/10 border-tertiary text-tertiary font-semibold' 
                                        : (selected === option 
                                            ? 'bg-error/10 border-error text-error font-semibold' 
                                            : 'bg-surface-container border-outline/30 text-on-surface-variant cursor-default'))
                                    : 'bg-surface-container border-outline/30 text-on-surface hover:border-primary hover:bg-primary/5 cursor-pointer'"
                                x-text="option">
                        </button>
                    </template>
                </div>

                {{-- Explanation (shown after answer) --}}
                <template x-if="isAnswered && questions[currentIndex]?.penjelasan_opsi">
                    <div class="mt-space-md p-space-md rounded-lg bg-surface-container-low border border-outline/20">
                        <p class="font-label-badge text-label-badge text-outline uppercase mb-space-xs">Penjelasan</p>
                        <p class="text-body-sm text-on-surface"
                           x-text="questions[currentIndex].penjelasan_opsi[selected] || 'Lihat pembahasan di materi.'"></p>
                    </div>
                </template>
            </div>

            {{-- Action button --}}
            <div class="flex gap-space-md">
                <button @click="previousQuestion()"
                        :disabled="currentIndex === 0 || !isAnswered"
                        class="flex-1 h-10 rounded-xl font-body-md text-body-md font-semibold transition-all"
                        :class="(currentIndex === 0 || !isAnswered)
                            ? 'bg-surface-container text-on-surface-variant cursor-default'
                            : 'bg-surface-container text-on-surface hover:bg-surface-container-high'">
                    Sebelumnya
                </button>
                
                <button @click="isAnswered ? nextQuestion() : ''"
                        :disabled="!isAnswered"
                        class="flex-1 h-10 rounded-xl font-body-md text-body-md font-semibold transition-all"
                        :class="!isAnswered
                            ? 'bg-outline/20 text-on-surface-variant cursor-default'
                            : 'bg-primary text-on-primary hover:bg-primary/90'">
                    <span x-show="currentIndex + 1 < questions.length">Lanjut</span>
                    <span x-show="currentIndex + 1 === questions.length">Lihat Hasil</span>
                </button>
            </div>
        </div>
    </template>

    {{-- Results state --}}
    <template x-if="!loading && finished">
        <div class="w-full max-w-md text-center">
            <div class="mb-space-lg">
                <div class="w-24 h-24 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-space-md">
                    <span class="material-symbols-outlined text-[48px] text-primary">check_circle</span>
                </div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold mb-space-sm">Kuis Selesai!</h1>
                <p class="text-body-md text-on-surface-variant">Waktu: <span x-text="totalTime"></span> detik</p>
            </div>

            <div class="bg-surface-container-lowest rounded-2xl p-space-lg mb-space-lg">
                <p class="text-body-sm text-on-surface-variant mb-space-xs">Skor Akhir Kamu</p>
                <p class="font-headline-xl text-headline-xl text-primary font-bold" x-text="`${score}%`"></p>
                <p class="text-body-sm text-on-surface-variant mt-space-xs">Jawaban benar: <span x-text="correctAnswers"></span> dari <span x-text="questions.length"></span></p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="inline-block px-space-lg h-10 rounded-xl bg-primary text-on-primary font-body-md text-body-md font-semibold hover:bg-primary/90 transition-all">
                Kembali ke Dasbor
            </a>
        </div>
    </template>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('kuisPlayer', (questions) => ({
        questions: questions || [],
        currentIndex: 0,
        selected: null,
        isAnswered: false,
        finished: false,
        loading: questions.length === 0,
        timer: 0,
        totalTime: 0,
        score: 0,
        correctAnswers: 0,
        answers: [],
        timerInterval: null,

        init() {
            // Deduplicate opsi_jawaban for each question
            this.questions = this.questions.map(q => ({
                ...q,
                opsi_jawaban: q.opsi_jawaban ? [...new Set(q.opsi_jawaban)] : []
            }));
            
            if (this.questions.length > 0) {
                this.startTimer();
            }
        },

        startTimer() {
            const questionTime = this.questions[this.currentIndex]?.waktu || 60;
            this.timer = questionTime;
            
            if (this.timerInterval) clearInterval(this.timerInterval);
            
            this.timerInterval = setInterval(() => {
                this.totalTime++;
                this.timer--;
                
                if (this.timer <= 0) {
                    this.nextQuestion();
                }
            }, 1000);
        },

        selectAnswer(option) {
            if (this.isAnswered) return;
            
            this.selected = option;
            this.isAnswered = true;
            
            const question = this.questions[this.currentIndex];
            const isCorrect = Array.isArray(question.kunci_jawaban)
                ? question.kunci_jawaban.includes(option)
                : question.kunci_jawaban === option;
            
            if (isCorrect) this.correctAnswers++;
            
            this.answers.push({
                questionIndex: this.currentIndex,
                selected: option,
                correct: isCorrect,
                points: question.poin || 0
            });
        },

        previousQuestion() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
                const prev = this.answers.find(a => a.questionIndex === this.currentIndex);
                this.selected = prev?.selected || null;
                this.isAnswered = !!prev;
                this.startTimer();
            }
        },

        nextQuestion() {
            if (this.currentIndex < this.questions.length - 1) {
                this.currentIndex++;
                this.selected = null;
                this.isAnswered = false;
                this.startTimer();
            } else {
                this.finishQuiz();
            }
        },

        finishQuiz() {
            clearInterval(this.timerInterval);
            this.score = Math.round((this.correctAnswers / this.questions.length) * 100);
            this.finished = true;
        }
    }));
});
</script>

</body>
</html>
