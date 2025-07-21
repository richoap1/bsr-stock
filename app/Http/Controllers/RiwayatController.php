<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\RiwayatPengambilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Menampilkan SEMUA riwayat transaksi (Untuk Super Admin) dengan search & sort.
     */
    public function index(Request $request)
    {
        // =======================================================
        // == LOGIKA UNTUK TABEL 1: RIWAYAT PENGAMBILAN ALAT ==
        // =======================================================
        $pengambilanQuery = RiwayatPengambilan::with(['user', 'alat']);

        // Logika Pencarian untuk Pengambilan Alat
        if ($request->filled('search_pengambilan')) {
            $search = $request->search_pengambilan;
            $pengambilanQuery->where(function ($q) use ($search) {
                $q->whereHas('alat', function ($q2) use ($search) {
                      $q2->where('nama_alat', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($q3) use ($search) {
                      $q3->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Logika Pengurutan untuk Pengambilan Alat
        $sortByPengambilan = $request->query('sort_by_pengambilan', 'tanggal_pengambilan');
        $sortDirectionPengambilan = $request->query('sort_direction_pengambilan', 'desc');
        if (in_array($sortByPengambilan, ['jumlah_diambil', 'tanggal_pengambilan'])) {
            $pengambilanQuery->orderBy($sortByPengambilan, $sortDirectionPengambilan);
        }
        
        $riwayatPengambilan = $pengambilanQuery->paginate(10, ['*'], 'pengambilan_page')->withQueryString();


        // =======================================================
        // == LOGIKA UNTUK TABEL 2: RIWAYAT PERMINTAAN ==
        // =======================================================
        $permintaanQuery = Permintaan::with('user');

        // Logika Pencarian untuk Permintaan
        if ($request->filled('search_permintaan')) {
            $search = $request->search_permintaan;
            $permintaanQuery->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Logika Filter Tanggal & Status untuk Permintaan
        if ($request->filled('filter_tanggal')) {
            $permintaanQuery->whereDate('tanggal_permintaan', $request->filter_tanggal);
        }
        if ($request->filled('filter_status')) {
            $permintaanQuery->where('status', $request->filter_status);
        }

        // Logika Pengurutan untuk Permintaan
        $sortByPermintaan = $request->query('sort_by_permintaan', 'tanggal_permintaan');
        $sortDirectionPermintaan = $request->query('sort_direction_permintaan', 'desc');
        if (in_array($sortByPermintaan, ['deskripsi', 'tipe_permintaan', 'status', 'tanggal_permintaan'])) {
            $permintaanQuery->orderBy($sortByPermintaan, $sortDirectionPermintaan);
        }

        $riwayatPermintaan = $permintaanQuery->paginate(10, ['*'], 'permintaan_page')->withQueryString();
                                       
        return view('riwayat.index', compact(
            'riwayatPengambilan', 'sortByPengambilan', 'sortDirectionPengambilan',
            'riwayatPermintaan', 'sortByPermintaan', 'sortDirectionPermintaan'
        ));
    }

    /**
     * Menampilkan riwayat transaksi HANYA untuk user yang sedang login.
     */
    public function userHistory(Request $request)
    {
        // Logika di sini sama persis dengan index(), hanya ditambahkan ->where('user_id', ...)
        $userId = Auth::id();
        
        $pengambilanQuery = RiwayatPengambilan::with(['user', 'alat'])->where('user_id', $userId);
        if ($request->filled('search_pengambilan')) {
            $search = $request->search_pengambilan;
            $pengambilanQuery->whereHas('alat', function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%");
            });
        }
        $sortByPengambilan = $request->query('sort_by_pengambilan', 'tanggal_pengambilan');
        $sortDirectionPengambilan = $request->query('sort_direction_pengambilan', 'desc');
        if (in_array($sortByPengambilan, ['jumlah_diambil', 'tanggal_pengambilan'])) {
            $pengambilanQuery->orderBy($sortByPengambilan, $sortDirectionPengambilan);
        }
        $riwayatPengambilan = $pengambilanQuery->paginate(10, ['*'], 'pengambilan_page')->withQueryString();

        
        $permintaanQuery = Permintaan::with('user')->where('user_id', $userId);
        if ($request->filled('search_permintaan')) {
            $search = $request->search_permintaan;
            $permintaanQuery->where('deskripsi', 'like', "%{$search}%");
        }
        if ($request->filled('filter_tanggal')) {
            $permintaanQuery->whereDate('tanggal_permintaan', $request->filter_tanggal);
        }
        if ($request->filled('filter_status')) {
            $permintaanQuery->where('status', $request->filter_status);
        }
        $sortByPermintaan = $request->query('sort_by_permintaan', 'tanggal_permintaan');
        $sortDirectionPermintaan = $request->query('sort_direction_permintaan', 'desc');
        if (in_array($sortByPermintaan, ['deskripsi', 'tipe_permintaan', 'status', 'tanggal_permintaan'])) {
            $permintaanQuery->orderBy($sortByPermintaan, $sortDirectionPermintaan);
        }
        $riwayatPermintaan = $permintaanQuery->paginate(10, ['*'], 'permintaan_page')->withQueryString();
        
        return view('riwayat.index', compact(
            'riwayatPengambilan', 'sortByPengambilan', 'sortDirectionPengambilan',
            'riwayatPermintaan', 'sortByPermintaan', 'sortDirectionPermintaan'
        ));
    }
}