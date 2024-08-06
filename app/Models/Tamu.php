<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tamu extends Model
{
    use HasFactory;
    protected $table = 'tamu';
    protected $fillable = [
        'nama', 'alamat', 'no_telp', 'email'
    ];


    public function kedatanganTamu(): HasMany
    {
        return $this->hasMany(KedatanganTamu::class, 'id_tamu', 'id');
    }
}
