<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alat;

class PermintaanController extends Controller
{
    /**
     * Menampilkan riwayat permintaan untuk user yang sedang login.
     */
    public function index()
    {
        $permintaans = Permintaan::where('user_id', Auth::id())
                                 ->latest()
                                 ->paginate(10);
        return view('permintaan.index', compact('permintaans'));
    }

    /**
     * Menampilkan form untuk membuat permintaan baru.
     */
    public function create()
    {
        $alats = Alat::orderBy('nama_alat')->get();
        return view('permintaan.create', compact('alats'));
    }

    /**
     * Menyimpan permintaan baru.
     */
    public function store(Request $request)
    {
        // Validasi dasar
        $validated = $request->validate([
            'tipe_permintaan' => 'required|in:barang,uang',
            'tanggal_permintaan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Validasi kondisional berdasarkan tipe permintaan
        if ($request->tipe_permintaan == 'barang') {
            $validated = array_merge($validated, $request->validate([
                'deskripsi' => 'required|string|max:255', // <-- Validasi deskripsi kembali
                'jumlah' => 'required|integer|min:1',
                'harga_barang' => 'nullable|numeric',
            ]));
        } else { // tipe_permintaan == 'uang'
            $validated = array_merge($validated, $request->validate([
                'deskripsi' => 'required|string|max:255',
                'nominal_uang' => 'required|numeric|min:0',
                'mata_uang' => 'required|string|max:10',
            ]));
        }

        $data = array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'waiting',
        ]);

        Permintaan::create($data);

        return redirect()->route('permintaan.index')
                        ->with('success', 'Permintaan berhasil diajukan.');
    }

    /**
     * Menghapus permintaan (hanya bisa dilakukan oleh pemilik permintaan).
     */
    public function destroy(Permintaan $permintaan)
    {
        // Pastikan hanya pemilik yang bisa menghapus
        if ($permintaan->user_id !== Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        $permintaan->delete();

        return redirect()->route('permintaan.index')
                         ->with('success', 'Permintaan berhasil dihapus.');
    }


    // --- FUNGSI KHUSUS SUPER ADMIN ---

    /**
     * Menampilkan semua permintaan untuk approval Super Admin.
     */
    public function adminIndex(Request $request)
    {
        $query = Permintaan::with('user');

        // Logika Pencarian Teks
        if ($request->filled('search_permintaan')) {
            $search = $request->search_permintaan;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Logika Filter Tanggal & Status
        if ($request->filled('filter_tanggal')) {
            $query->whereDate('tanggal_permintaan', $request->filter_tanggal);
        }
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        // Logika Pengurutan
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');
        
        if (in_array($sortBy, ['deskripsi', 'tipe_permintaan', 'status', 'tanggal_permintaan'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $permintaans = $query->paginate(10)->withQueryString();

        return view('admin.permintaan.index', compact('permintaans', 'sortBy', 'sortDirection'));
    }

    /**
     * Menyetujui sebuah permintaan.
     */
    public function approve(Permintaan $permintaan)
    {
        $permintaan->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Permintaan disetujui.');
    }

    /**
     * Menolak sebuah permintaan.
     */
    public function reject(Permintaan $permintaan)
    {
        $permintaan->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Permintaan ditolak.');
    }
}