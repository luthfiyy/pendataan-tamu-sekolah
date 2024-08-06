<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ekspedisi extends Model
{
    use HasFactory;

    protected $table = 'ekspedisi';

    protected $fillable = [
        'nama_kurir',
        'ekspedisi',
    ];

    public function kedatanganTamu(): HasMany
    {
        return $this->hasMany(KedatanganEkspedisi::class, 'id_ekspedisi', 'id');
    }
}
