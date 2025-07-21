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
            // 1. Tambah kolom baru untuk membedakan tipe
            $table->enum('tipe_permintaan', ['barang', 'uang'])->default('barang')->after('user_id');

            // 2. Ganti nama 'nama_barang' menjadi 'deskripsi' agar lebih umum
            $table->renameColumn('nama_barang', 'deskripsi');

            // 3. Tambah kolom baru untuk permintaan uang
            $table->decimal('nominal_uang', 15, 2)->nullable()->after('deskripsi');
            $table->string('mata_uang', 10)->nullable()->after('nominal_uang');

            // 4. Buat kolom lama menjadi opsional (nullable) karena hanya untuk tipe 'barang'
            $table->integer('jumlah')->nullable()->change();
            $table->decimal('harga_barang', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropColumn('tipe_permintaan');
            $table->renameColumn('deskripsi', 'nama_barang');
            $table->dropColumn('nominal_uang');
            $table->dropColumn('mata_uang');
            $table->integer('jumlah')->nullable(false)->change();
            $table->decimal('harga_barang', 15, 2)->nullable(false)->change();
        });
    }
};