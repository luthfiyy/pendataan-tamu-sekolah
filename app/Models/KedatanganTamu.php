<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KedatanganTamu extends Model
{
    use HasFactory;
    protected $table = 'kedatangan-tamu';
    protected $fillable = [
        'id_pegawai', 'id_tamu', 'id_user', 'qr_code', 'tujuan', 'instansi', 'waktu_perjanjian','foto', 'waktu_kedatangan', 'status'
    ];

    public function tamu(): BelongsTo
    {
        return $this->belongsTo(Tamu::class, 'id_tamu');
    }

    /**
     * Get the Pegawai associated with the model.
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    /**
     * Get the User associated with the model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
