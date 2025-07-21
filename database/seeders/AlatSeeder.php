<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alat;
use Carbon\Carbon;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel sebelum mengisi data baru
        Alat::truncate();

        $alats = [
            [
                'nama_alat' => 'Digital Multimeter Fluke 115',
                'serial_number' => 'FLUKE-115-001',
                'jumlah' => 10,
                'tgl_datang_alat' => Carbon::parse('2024-01-15'),
                'tgl_kalibrasi_terakhir' => Carbon::now()->subMonths(2), // Kalibrasi 2 bulan lalu
            ],
            [
                'nama_alat' => 'GPS Geodetik Trimble R2',
                'serial_number' => 'TRIMBLE-R2-005',
                'jumlah' => 5,
                'tgl_datang_alat' => Carbon::parse('2023-11-20'),
                'tgl_kalibrasi_terakhir' => Carbon::now()->subMonths(8), // Kalibrasi 8 bulan lalu (expired)
            ],
            [
                'nama_alat' => 'Safety Helmet MSA',
                'serial_number' => null, // Contoh alat tanpa S/N
                'jumlah' => 50,
                'tgl_datang_alat' => Carbon::parse('2024-03-10'),
                'tgl_kalibrasi_terakhir' => null, // Tidak perlu kalibrasi
            ],
            [
                'nama_alat' => 'Theodolite Digital Topcon',
                'serial_number' => 'TOPCON-DT209-012',
                'jumlah' => 3,
                'tgl_datang_alat' => Carbon::parse('2024-02-01'),
                'tgl_kalibrasi_terakhir' => Carbon::now()->subMonths(1), // Kalibrasi bulan lalu
            ],
             [
                'nama_alat' => 'Tabung Oksigen 1 m3',
                'serial_number' => 'TO-1M3',
                'jumlah' => 25,
                'tgl_datang_alat' => Carbon::parse('2023-01-01'),
                'tgl_kalibrasi_terakhir' => null,
            ],
        ];

        foreach ($alats as $alat) {
            Alat::create($alat);
        }
    }
}