<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\MateriBelajar;
use App\Models\KuisSettings;
use App\Models\ProgressBelajar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::guard('guru')->user();
        
        // Stats untuk dashboard
        $totalModul     = MateriBelajar::where('published', true)->count();
        // Penugasan aktif = kuis yang sudah published milik guru ini
        $totalPenugasan = KuisSettings::where('status', 'published')
            ->whereHas('materi', fn($q) => $q->where('guru_id', $guru->id))
            ->count();
        $totalSiswa = User::count();
        
        // Nilai stats
        $rataRataNilaiKuis = ProgressBelajar::whereNotNull('nilai_kuis')->avg('nilai_kuis') ?? 0;
        $rataRataNilaiLab = ProgressBelajar::whereNotNull('nilai_lab')->avg('nilai_lab') ?? 0;
        $totalErrorKode = 0; // TODO: add error tracking
        
        // Materi list (for manage materials section) - ALL materials for this guru
        $materiList = MateriBelajar::where('guru_id', $guru->id)
            ->orderBy('created_at', 'desc')
            ->with(['kuis', 'labPraktik', 'kuisSettings'])
            ->get();

        // Metrics
        $metrics = [
            'total_modul' => $materiList->count(),
            'total_kuis' => $materiList->sum(function($m) { return $m->kuis->count(); }),
            'total_lab' => $materiList->sum(function($m) { return $m->labPraktik->count(); }),
            'siswa_online' => 36, // TODO: track active students
        ];
        
        // Student progress (for progress table)
        $progressSiswa = ProgressBelajar::with(['user', 'materi'])
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();
        
        return view('dashboard-guru', compact(
            'guru', 
            'totalModul', 
            'totalPenugasan', 
            'rataRataNilaiKuis', 
            'rataRataNilaiLab', 
            'totalErrorKode',
            'materiList',
            'progressSiswa',
            'metrics'
        ));
    }
}
