<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Http\Requests\StoreAlatRequest;
use App\Http\Requests\UpdateAlatRequest;
use Illuminate\Http\Request;


class AlatController extends Controller
{
    /**
     * Menampilkan daftar semua alat dengan search dan sort.
     */
    /**
 * Menampilkan daftar semua alat dengan search dan sort.
 */
    public function index(Request $request)
    {
        $query = Alat::query();

        // 1. Logika Pencarian
        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        // 2. Logika Pengurutan (Di sini variabel dibuat)
        $sortBy = $request->query('sort_by', 'created_at'); // Default sort by tanggal dibuat
        $sortDirection = $request->query('sort_direction', 'desc'); // Default descending

        // Pastikan hanya kolom yang aman yang bisa di-sort
        if (in_array($sortBy, ['nama_alat', 'jumlah', 'tgl_datang_alat', 'tgl_kalibrasi_terakhir'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        // 3. Pagination dengan membawa parameter query
        $alats = $query->paginate(10)->withQueryString();

        // 4. Kirim semua variabel yang dibutuhkan ke view (INI KUNCINYA)
        return view('admin.alat.index', compact('alats', 'sortBy', 'sortDirection'));
    }

    public function create()
    {
        return view('admin.alat.create', ['alat' => new Alat()]);
    }

    public function store(StoreAlatRequest $request)
    {
        Alat::create($request->validated());
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    /**
     * INI METHOD YANG PALING PENTING UNTUK DIPERIKSA
     * Pastikan parameternya adalah (Alat $alat)
     */
    public function edit(Alat $alat)
    {
        // Laravel akan otomatis mencari data Alat berdasarkan ID dari URL
        // dan mengirimkannya ke view sebagai variabel $alat
        return view('admin.alat.edit', compact('alat'));
    }

    public function update(UpdateAlatRequest $request, Alat $alat)
    {
        //function untuk edit alat yang sudah di inputkan
        $alat->update($request->validated());
        return redirect()->route('admin.alat.index')->with('success', 'Data alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        //function untuk menghapus alat
        $alat->delete();
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}