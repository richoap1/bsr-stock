<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permintaan;
use App\Models\RiwayatPengambilan;
use App\Models\User;
use App\Models\Alat;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel transaksi
        Permintaan::truncate();
        RiwayatPengambilan::truncate();

        // Ambil user yang sudah ada dari UserSeeder
        $superadmin = User::where('role', 'superadmin')->first();
        $admin = User::where('role', 'admin')->first();
        
        // Buat beberapa data PERMINTAAN
        // Contoh Permintaan Barang Baru
        Permintaan::create([
            'user_id' => $admin->id,
            'tipe_permintaan' => 'barang',
            'deskripsi' => 'Kabel UTP Belden 1 Roll',
            'jumlah' => 2,
            'harga_barang' => 1500000,
            'keterangan' => 'Untuk instalasi jaringan di lantai 2.',
            'tanggal_permintaan' => Carbon::now()->subDays(10),
            'status' => 'approved'
        ]);

        // Contoh Permintaan Uang
        Permintaan::create([
            'user_id' => $admin->id,
            'tipe_permintaan' => 'uang',
            'deskripsi' => 'Biaya Transportasi Proyek A',
            'nominal_uang' => 500000,
            'mata_uang' => 'IDR',
            'tanggal_permintaan' => Carbon::now()->subDays(2),
            'status' => 'waiting'
        ]);

        // Contoh Permintaan Barang lain
        Permintaan::create([
            'user_id' => $superadmin->id,
            'tipe_permintaan' => 'barang',
            'deskripsi' => 'Mouse Wireless Logitech',
            'jumlah' => 3,
            'tanggal_permintaan' => Carbon::now()->subDays(5),
            'status' => 'rejected'
        ]);


        // Buat beberapa data RIWAYAT PENGAMBILAN
        $alatUntukDiambil1 = Alat::where('nama_alat', 'Safety Helmet MSA')->first();
        if ($alatUntukDiambil1) {
            $jumlahAmbil = 5;
            $alatUntukDiambil1->decrement('jumlah', $jumlahAmbil); // Kurangi stok
            RiwayatPengambilan::create([
                'user_id' => $admin->id,
                'alat_id' => $alatUntukDiambil1->id,
                'jumlah_diambil' => $jumlahAmbil,
                'tanggal_pengambilan' => Carbon::now()->subDays(3)
            ]);
        }
        
        $alatUntukDiambil2 = Alat::where('nama_alat', 'Digital Multimeter Fluke 115')->first();
        if ($alatUntukDiambil2) {
            $jumlahAmbil = 1;
            $alatUntukDiambil2->decrement('jumlah', $jumlahAmbil); // Kurangi stok
            RiwayatPengambilan::create([
                'user_id' => $superadmin->id,
                'alat_id' => $alatUntukDiambil2->id,
                'jumlah_diambil' => $jumlahAmbil,
                'tanggal_pengambilan' => Carbon::now()->subDays(1)
            ]);
        }
    }
}