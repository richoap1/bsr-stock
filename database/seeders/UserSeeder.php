<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat jika seeder dijalankan lagi
        User::truncate();

        // Buat Super Admin
        User::create([
            'name' => 'Super Admin BSR',
            'email' => 'superadmin@bsr.co.id',
            'password' => Hash::make('bsr12345678'),
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

        // Buat Admin biasa
        User::create([
            'name' => 'Admin User BSR',
            'email' => 'admin@bsr.co.id',
            'password' => Hash::make('bsr123456'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}