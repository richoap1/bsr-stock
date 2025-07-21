<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            // Mengubah nama kolom agar lebih jelas fungsinya
            $table->renameColumn('tgl_berlaku_kalibrasi', 'tgl_kalibrasi_terakhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            // Untuk bisa rollback migrasi
            $table->renameColumn('tgl_kalibrasi_terakhir', 'tgl_berlaku_kalibrasi');
        });
    }
};