<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\ProgressBelajar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapNilaiController extends Controller
{
    public function index()
    {
        $guru = Auth::guard('guru')->user();
        
        $rataRataNilaiKuis = ProgressBelajar::whereNotNull('nilai_kuis')->avg('nilai_kuis') ?? 88.4;
        $rataRataNilaiLab = ProgressBelajar::whereNotNull('nilai_lab')->avg('nilai_lab') ?? 91.2;
        
        return view('rekap-nilai', compact('guru', 'rataRataNilaiKuis', 'rataRataNilaiLab'));
    }
}
