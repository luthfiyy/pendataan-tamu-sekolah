<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KedatanganEkspedisi extends Model
{
    use HasFactory;

    protected $table = 'kedatangan-ekspedisi';

    protected $fillable = [
        'id_ekspedisi',
        'id_pegawai',
        'id_user',
        'foto',
        'tanggal_waktu',
    ];

    public function ekspedisi(): BelongsTo
    {
        return $this->belongsTo(Ekspedisi::class, 'id_ekspedisi');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_tamu');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
