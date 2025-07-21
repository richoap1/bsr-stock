<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\RiwayatPengambilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PengambilanController extends Controller
{
    /**
     * Menampilkan halaman "katalog" alat yang bisa diambil.
     */
    public function index()
    {
        $alats = Alat::where('jumlah', '>', 0)->latest()->get();
        return view('pengambilan.index', compact('alats'));
    }

    /**
     * Memproses pengambilan alat.
     */
    /**
     * Memproses pengambilan alat.
     */
    public function store(Request $request)
    {
        // Validasi input, termasuk keterangan baru
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah_diambil' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255', // Validasi untuk keterangan
        ]);

        try {
            DB::transaction(function () use ($request) {
                $alat = Alat::lockForUpdate()->find($request->alat_id);

                if ($alat->jumlah < $request->jumlah_diambil) {
                    throw ValidationException::withMessages([
                        'jumlah_diambil' => 'Stok tidak mencukupi. Sisa stok: ' . $alat->jumlah,
                    ]);
                }

                $alat->decrement('jumlah', $request->jumlah_diambil);

                // Catat riwayat pengambilan, termasuk keterangan
                RiwayatPengambilan::create([
                    'user_id' => auth()->id(),
                    'alat_id' => $alat->id,
                    'jumlah_diambil' => $request->jumlah_diambil,
                    'keterangan' => $request->keterangan, // <-- SIMPAN KETERANGAN
                    'tanggal_pengambilan' => now()
                ]);
            });
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('pengambilan.index')
                         ->with('success', 'Alat berhasil diambil.');
    }
}