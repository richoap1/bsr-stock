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
        Schema::table('permintaans', function (Blueprint $table) {
            // Tambahkan kolom foreign key ke tabel alats
            // Ini akan null jika tipe permintaan adalah 'uang'
            $table->foreignId('alat_id')
                  ->nullable()
                  ->after('tipe_permintaan')
                  ->constrained('alats')
                  ->onDelete('set null'); // Jika alat dihapus, permintaan tidak ikut terhapus

            // Deskripsi sekarang bisa null, karena untuk permintaan barang, deskripsi diambil dari nama alat
            $table->string('deskripsi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['alat_id']);
            $table->dropColumn('alat_id');

            $table->string('deskripsi')->nullable(false)->change();
        });
    }
};