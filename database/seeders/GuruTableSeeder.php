<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruTableSeeder extends Seeder
{
    public function run(): void
    {
        Guru::create([
            'nip' => '198512051234567890',
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@sekolah.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'sekolah' => 'SMAN 1 Jakarta Pusat',
            'active' => true,
        ]);

        Guru::create([
            'nip' => '198703151098765432',
            'name' => 'Ahmad Hidayat',
            'email' => 'ahmad.hidayat@sekolah.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'lab_admin',
            'sekolah' => 'SMAN 1 Jakarta Pusat',
            'active' => true,
        ]);
    }
}
