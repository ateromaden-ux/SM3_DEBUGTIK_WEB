<?php

namespace App\Http\Controllers;

use App\Models\ProgressBelajar;
use Illuminate\Support\Facades\Auth;

class RekapNilaiController extends Controller
{
    public function index()
    {
        $guru = Auth::guard('guru')->user();

        $rataRataNilaiKuis = ProgressBelajar::whereNotNull('nilai_kuis')->avg('nilai_kuis') ?? 0;
        $rataRataNilaiLab = ProgressBelajar::whereNotNull('nilai_lab')->avg('nilai_lab') ?? 0;

        return view('rekap-nilai', compact('guru', 'rataRataNilaiKuis', 'rataRataNilaiLab'));
    }
}
