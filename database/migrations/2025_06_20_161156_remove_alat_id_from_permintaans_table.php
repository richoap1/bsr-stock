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
            // Hapus foreign key constraint terlebih dahulu sebelum menghapus kolomnya
            $table->dropForeign(['alat_id']);
            $table->dropColumn('alat_id');

            // Kembalikan kolom deskripsi menjadi tidak boleh null
            $table->string('deskripsi')->nullable(false)->change();
        });
    }

    // Method down() bisa dikosongkan atau diisi dengan kebalikannya
    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->foreignId('alat_id')->nullable()->after('tipe_permintaan')->constrained('alats')->onDelete('set null');
            $table->string('deskripsi')->nullable()->change();
        });
    }
};