<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// TAMBAHKAN USE STATEMENT INI
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Matikan pengecekan foreign key
        Schema::disableForeignKeyConstraints();

        // Panggil seeder dengan urutan yang benar
        $this->call([
            UserSeeder::class,
            AlatSeeder::class,
            TransaksiSeeder::class,
        ]);

        // Nyalakan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();
    }
}