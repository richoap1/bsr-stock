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
        Schema::table('riwayat_pengambilans', function (Blueprint $table) {
            // Tambahkan kolom keterangan setelah jumlah_diambil
            $table->text('keterangan')->nullable()->after('jumlah_diambil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pengambilans', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};