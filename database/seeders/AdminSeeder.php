<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin utama
        Guru::create([
            'nip' => 'ADMIN001',
            'name' => 'Super Admin Utama',
            'email' => 'admin@sekolah.sch.id',
            'password' => Hash::make('Admin123!'),
            'role' => 'lab_admin',
            'sekolah' => 'SMA Negeri 1 Jakarta',
            'active' => true,
        ]);
    }
}
