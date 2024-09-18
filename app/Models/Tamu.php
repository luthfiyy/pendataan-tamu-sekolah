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

    protected $primaryKey = 'id_tamu'; // Set primary key
    public $incrementing = false; // Non-incrementing
    protected $keyType = 'string'; // String type
    protected $fillable = [
        'id_tamu',
        'nama',
        'alamat',
        'no_telp',
        'email'
    ];


    protected static function boot()
    {
        parent::boot();

        // Generate id_ekspedisi before saving
        static::creating(function ($model) {
            // Ambil record terakhir
            $lastRecord = self::orderBy('id_tamu', 'desc')->first();
            // Ambil angka dari id terakhir dan tambahkan 1
            $lastIdNumber = $lastRecord ? (int)substr($lastRecord->id_tamu, 4) : 0;
            // Generate id baru
            $model->id_tamu = 'TM_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
        });
    }

    public function kedatanganTamu(): HasMany
    {
        return $this->hasMany(KedatanganTamu::class, 'id_tamu', 'id_tamu');
    }
}
