<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\MateriBelajar;
use App\Models\ProgressBelajar;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        // Buat data guru dummy
        $gurus = [
            [
                'nip' => '19750315199803001',
                'name' => 'Ibu Siti Nurhaliza',
                'email' => 'siti.nurhaliza@sekolah.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'sekolah' => 'SMA Negeri 1 Jakarta',
                'active' => true,
            ],
            [
                'nip' => '19680421198811002',
                'name' => 'Pak Bambang Irawan',
                'email' => 'bambang.irawan@sekolah.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'sekolah' => 'SMA Negeri 1 Jakarta',
                'active' => true,
            ],
            [
                'nip' => '19800610200012001',
                'name' => 'Pak Admin Lab',
                'email' => 'admin.lab@sekolah.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'lab_admin',
                'sekolah' => 'SMA Negeri 1 Jakarta',
                'active' => true,
            ],
        ];

        foreach ($gurus as $guruData) {
            Guru::create($guruData);
        }

        // Buat users dummy untuk siswa
        $users = [
            [
                'name' => 'Raden Arya Pratama',
                'email' => 'raden.arya@belajar.id',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Sinta Dewi Lestari',
                'email' => 'sinta.dewi@belajar.id',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Doni Wijaya',
                'email' => 'doni.wijaya@belajar.id',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Buat materi belajar
        $gurus = Guru::all();
        $materiList = [
            [
                'judul' => 'Pengenalan Algoritma dan Kompleksitas',
                'deskripsi' => 'Pelajari dasar algoritma, notasi Big O, dan cara menganalisis efisiensi kode.',
                'kategori' => 'algoritma',
                'konten' => 'Algoritma adalah urutan langkah-langkah untuk menyelesaikan masalah...',
                'kode_soal' => 'function bubbleSort(arr) { for(let i=0; i<arr.length; i++) { for(let j=0; j<arr.length-1; j++) { if(arr[j] > arr[j+1]) { let temp = arr[j]; arr[j] = arr[j+1]; arr[j+1] = temp; } } } return arr; }',
                'solusi' => 'Algoritma bubble sort sudah benar, kompleksitas O(n²).',
                'tingkat_kesulitan' => 1,
                'published' => true,
            ],
            [
                'judul' => 'Debugging Loop dan Array JavaScript',
                'deskripsi' => 'Temukan dan perbaiki bug pada loop dan manipulasi array.',
                'kategori' => 'debugging',
                'konten' => 'Loop adalah struktur kontrol yang mengulang blok kode...',
                'kode_soal' => 'function countItems(items) { let count = 0; for(let i = 0; i <= items.length; i++) { count++; } return count; }',
                'solusi' => 'Bug: kondisi loop gunakan i < items.length, bukan i <= items.length. Akan causes array index out of bounds.',
                'tingkat_kesulitan' => 2,
                'published' => true,
            ],
            [
                'judul' => 'Desain ERD Relasi Basis Data',
                'deskripsi' => 'Pelajari cara membuat Entity Relationship Diagram untuk aplikasi multi-user.',
                'kategori' => 'database',
                'konten' => 'ERD menggambarkan relasi antar entitas dalam basis data...',
                'kode_soal' => null,
                'solusi' => 'GURU (1) -> (N) MATERI_BELAJAR -> (N) PROGRESS_BELAJAR (N) <- (1) SISWA',
                'tingkat_kesulitan' => 1,
                'published' => true,
            ],
            [
                'judul' => 'Pemrograman OOP dan Inheritance',
                'deskripsi' => 'Pahami konsep OOP, class, inheritance, dan polymorphism di PHP.',
                'kategori' => 'pemrograman',
                'konten' => 'OOP adalah paradigma pemrograman yang berbasis objek...',
                'kode_soal' => 'class Animal { public function sound() { return "suara"; } } class Dog extends Animal { }',
                'solusi' => 'Override method sound() di class Dog untuk mengembalikan "woof".',
                'tingkat_kesulitan' => 2,
                'published' => true,
            ],
        ];

        foreach ($materiList as $materi) {
            $guru = $gurus->random();
            MateriBelajar::create(array_merge($materi, ['guru_id' => $guru->id]));
        }

        // Buat progress belajar
        $users = User::all();
        $materis = MateriBelajar::all();

        foreach ($users as $user) {
            foreach ($materis->random(2) as $materi) {
                $persentase = rand(0, 100);
                $statusSelesai = $persentase >= 100;
                
                ProgressBelajar::create([
                    'user_id' => $user->id,
                    'materi_id' => $materi->id,
                    'status' => $statusSelesai ? 'selesai' : ['belum_mulai', 'sedang_belajar'][rand(0, 1)],
                    'status_selesai' => $statusSelesai,
                    'progress_persen' => rand(0, 100),
                    'persentase_selesai' => $persentase,
                    'skor' => rand(60, 100),
                    'nilai_kuis' => rand(70, 100),
                    'nilai_lab' => rand(65, 95),
                    'nilai_akhir' => rand(70, 100),
                    'mulai_belajar' => now()->subDays(rand(1, 30)),
                    'selesai_belajar' => $statusSelesai ? now() : null,
                    'catatan' => 'Progres siswa dalam mempelajari materi.',
                ]);
            }
        }
    }
}
