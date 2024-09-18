<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ekspedisi extends Model
{
    use HasFactory;

    protected $table = 'ekspedisi';

    protected $primaryKey = 'id_ekspedisi'; // Set primary key
    public $incrementing = false; // Non-incrementing
    protected $keyType = 'string'; // String type

    protected $fillable = [
        'id_ekspedisi',
        'nama_kurir',
        'ekspedisi',
        'no_telp',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate id_ekspedisi before saving
        static::creating(function ($model) {
            // Ambil record terakhir
            $lastRecord = self::orderBy('id_ekspedisi', 'desc')->first();
            // Ambil angka dari id terakhir dan tambahkan 1
            $lastIdNumber = $lastRecord ? (int)substr($lastRecord->id_ekspedisi, 4) : 0;
            // Generate id baru
            $model->id_ekspedisi = 'EKS_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
        });
    }

    public function kedatanganTamu(): HasMany
    {
        return $this->hasMany(KedatanganEkspedisi::class, 'id_ekspedisi', 'id');
    }
}
