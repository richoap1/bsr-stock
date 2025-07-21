<?php

namespace App\Exports;

use App\Models\Permintaan;
use App\Models\RiwayatPengambilan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllHistoryExport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        // Sheet 1: Riwayat Pengambilan Alat
        $sheets[] = new class implements FromCollection, WithHeadings, WithTitle, WithStyles
        {
            public function collection(): Collection
            {
                return RiwayatPengambilan::with(['user', 'alat'])->get()->map(function ($item) {
                    return [
                        'Nama Alat' => $item->alat->nama_alat ?? 'N/A',
                        'Keterangan' => $item->keterangan,
                        'Jumlah Diambil' => $item->jumlah_diambil,
                        'Diambil Oleh' => $item->user->name ?? 'N/A',
                        'Waktu' => $item->tanggal_pengambilan->format('Y-m-d H:i:s'),
                    ];
                });
            }

            public function headings(): array
            {
                return ['Nama Alat', 'Keterangan', 'Jumlah Diambil', 'Diambil Oleh', 'Waktu'];
            }

            public function title(): string
            {
                return 'Riwayat Pengambilan Alat';
            }

            // METHOD BARU UNTUK STYLING
            public function styles(Worksheet $sheet)
            {
                // Menebalkan baris header (baris pertama)
                $sheet->getStyle('1')->getFont()->setBold(true);
                // Menambahkan border ke semua cell yang berisi data
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        };

        // Sheet 2: Riwayat Permintaan
        $sheets[] = new class implements FromCollection, WithHeadings, WithTitle, WithStyles
        {
            public function collection(): Collection
            {
                return Permintaan::with('user')->get()->map(function ($item) {
                    $detail = ($item->tipe_permintaan == 'barang')
                        ? 'Jumlah: ' . $item->jumlah . ' Pcs'
                        : $item->mata_uang . ' ' . number_format((float) $item->nominal_uang, 0, ',', '.');

                    return [
                        'Pemohon' => $item->user->name ?? 'N/A',
                        'Deskripsi Permintaan' => $item->deskripsi,
                        'Keterangan Tambahan' => $item->keterangan,
                        'Detail Kuantitas' => $detail,
                        'Tipe' => ucfirst($item->tipe_permintaan),
                        'Tanggal Permintaan' => $item->tanggal_permintaan->format('Y-m-d'),
                        'Status' => ucfirst($item->status),
                    ];
                });
            }

            public function headings(): array
            {
                return ['Pemohon', 'Deskripsi Permintaan', 'Keterangan Tambahan', 'Detail Kuantitas', 'Tipe', 'Tanggal Permintaan', 'Status'];
            }

            public function title(): string
            {
                return 'Riwayat Permintaan';
            }
            
            // METHOD BARU UNTUK STYLING
            public function styles(Worksheet $sheet)
            {
                // Menebalkan baris header (baris pertama)
                $sheet->getStyle('1')->getFont()->setBold(true);
                // Menambahkan border ke semua cell yang berisi data
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        };

        return $sheets;
    }
}