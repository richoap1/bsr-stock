<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllHistoryExport;
use Carbon\Carbon;

class ExportController extends Controller
{
    /**
     * Menangani download semua riwayat ke file Excel.
     */
    public function exportAllHistory()
    {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $fileName = 'Laporan_Riwayat_BSR_' . $timestamp . '.xlsx';

        return Excel::download(new AllHistoryExport(), $fileName);
    }
}