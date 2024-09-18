<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $primaryKey = 'nip'; // Menentukan kolom primary key
    public $incrementing = false; // Non-incrementing karena kita menggunakan string sebagai ID
    protected $keyType = 'string';

    protected $table = 'pegawai';

    protected $fillable = [
        'nip', 'id_user', 'no_telp', 'ptk'
    ];

    // Define the relationship to User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kedatanganTamu(): HasMany
    {
        return $this->hasMany(KedatanganTamu::class, 'id_pegawai', 'nip');
    }
}
