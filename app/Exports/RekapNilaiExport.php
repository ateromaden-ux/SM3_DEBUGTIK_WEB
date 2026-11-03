<?php

namespace App\Exports;

use App\Models\ProgressBelajar;
use Illuminate\Support\Facades\DB;

class RekapNilaiExport
{
    public function export()
    {
        // Query data lengkap dengan joins
        $data = DB::table('progress_belajar as pb')
            ->leftJoin('users as u', 'pb.user_id', '=', 'u.id')
            ->leftJoin('materi_belajar as mb', 'pb.materi_id', '=', 'mb.id')
            ->leftJoin('kuis_settings as ks', 'pb.kuis_settings_id', '=', 'ks.id')
            ->select(
                'u.name as nama_siswa',
                'u.email',
                'mb.judul_materi',
                'mb.id_materi',
                'ks.nama_kuis',
                'pb.nilai_kuis',
                'pb.nilai_lab',
                'pb.nilai_akhir',
                'pb.status',
                'pb.persentase_selesai',
                'pb.mulai_belajar',
                'pb.selesai_belajar',
                'pb.created_at'
            )
            ->where('u.role', 'student')
            ->orderBy('u.name')
            ->orderBy('mb.id_materi')
            ->get();

        // Set headers untuk download CSV
        $filename = 'Rekap_Nilai_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Output ke buffer
        $output = fopen('php://output', 'w');

        // BOM untuk UTF-8 (agar Excel bisa baca karakter Indonesia)
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Header kolom
        fputcsv($output, [
            'Nama Siswa',
            'Email',
            'ID Materi',
            'Judul Materi',
            'Nama Kuis',
            'Nilai Kuis',
            'Nilai Lab',
            'Nilai Akhir',
            'Status',
            'Persentase Selesai (%)',
            'Mulai Belajar',
            'Selesai Belajar',
            'Tanggal Input'
        ]);

        // Data rows
        foreach ($data as $row) {
            fputcsv($output, [
                $row->nama_siswa ?? '-',
                $row->email ?? '-',
                $row->id_materi ?? '-',
                $row->judul_materi ?? '-',
                $row->nama_kuis ?? '-',
                $row->nilai_kuis ?? '-',
                $row->nilai_lab ?? '-',
                $row->nilai_akhir ?? '-',
                $row->status ?? '-',
                $row->persentase_selesai ?? '0',
                $row->mulai_belajar ? date('Y-m-d H:i', strtotime($row->mulai_belajar)) : '-',
                $row->selesai_belajar ? date('Y-m-d H:i', strtotime($row->selesai_belajar)) : '-',
                $row->created_at ? date('Y-m-d H:i', strtotime($row->created_at)) : '-'
            ]);
        }

        fclose($output);
        exit;
    }
}
