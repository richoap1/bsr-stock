<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permintaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipe_permintaan',
        'deskripsi',
        'nominal_uang',
        'mata_uang',
        'jumlah',
        'harga_barang',
        'tanggal_permintaan',
        'status',
        'keterangan',
    ];

    // ... (property $casts tetap sama) ...
    protected $casts = [
        'tanggal_permintaan' => 'date',
        'harga_barang' => 'decimal:2',
        'nominal_uang' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}