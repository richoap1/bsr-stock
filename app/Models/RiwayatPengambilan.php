<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPengambilan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'alat_id',
        'jumlah_diambil',
        'keterangan',
        'tanggal_pengambilan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_pengambilan' => 'datetime',
    ];

    /**
     * Mendefinisikan relasi bahwa RiwayatPengambilan ini MILIK SATU User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi bahwa RiwayatPengambilan ini MILIK SATU Alat.
     */
    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class);
    }
}