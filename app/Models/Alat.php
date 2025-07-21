<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_alat',
        'serial_number',
        'jumlah',
        'tgl_datang_alat',
        'tgl_kalibrasi_terakhir',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tgl_datang_alat' => 'date',
        'tgl_kalibrasi_terakhir' => 'date',
    ];

    /**
     * Mendefinisikan relasi bahwa satu Alat BISA MEMILIKI BANYAK (has many) Riwayat Pengambilan.
     */
    public function riwayatPengambilans(): HasMany
    {
        return $this->hasMany(RiwayatPengambilan::class);
    }
}