<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KuisTik;
use App\Models\MateriBelajar;

class KuisPlayer extends Component
{
    public $materi;
    public $questions;
    public $currentIndex = 0;
    public $score = 0;
    public $timer = 15;
    public $isAnswered = false;
    public $selected = null;
    public $showResult = false;

    public function mount(MateriBelajar $materi)
    {
        $this->materi = $materi;
        // Ambil soal dan acak (shuffle) agar pengalaman seperti game
        $this->questions = KuisTik::where('materi_id', $materi->id)->get()->shuffle();
    }

    public function timerTick()
    {
        if ($this->showResult || $this->isAnswered) return;

        if ($this->timer > 0) {
            $this->timer--;
        } else {
            $this->selectAnswer(null); // Waktu habis, anggap salah
        }
    }

    public function selectAnswer($opsi)
    {
        if ($this->isAnswered) return;

        $this->isAnswered = true;
        $this->selected = $opsi;
        
        $currentQuestion = $this->questions[$this->currentIndex];

        // Cek jawaban
        if ($opsi !== null && $opsi === $currentQuestion->kunci_jawaban) {
            $this->score += ($currentQuestion->poin + ($this->timer * 2)); // Poin bonus kecepatan
        }
    }

    public function next()
    {
        if ($this->currentIndex < count($this->questions) - 1) {
            $this->currentIndex++;
            $this->isAnswered = false;
            $this->selected = null;
            $this->timer = 15;
        } else {
            $this->showResult = true;
        }
    }

    public function render()
    {
        return view('livewire.kuis-player');
    }
}
