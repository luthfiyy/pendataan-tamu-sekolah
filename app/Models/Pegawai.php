<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'id_user', 'nip', 'no_telp', 'ptk'
    ];

    // Define the relationship to User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function kedatanganTamu(): HasMany
    {
        return $this->hasMany(KedatanganTamu::class, 'id_pegawai', 'id');
    }

}
