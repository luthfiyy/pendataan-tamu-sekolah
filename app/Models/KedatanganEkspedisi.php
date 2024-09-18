<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KedatanganEkspedisi extends Model
{
    use HasFactory;

    protected $table = 'kedatangan_ekspedisi';
    protected $primaryKey = 'id_kedatanganEkspedisi'; // Set primary key
    public $incrementing = false; // Non-incrementing
    protected $keyType = 'string'; // String type

    protected $fillable = [
        'id_ekspedisi',
        'id_pegawai',
        'id_user',
        'foto',
        'tanggal_waktu',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil record terakhir
            $lastRecord = self::orderBy('id_kedatanganEkspedisi', 'desc')->first();
            // Ambil angka dari id terakhir dan tambahkan 1
            $lastIdNumber = $lastRecord ? (int)substr($lastRecord->id_kedatanganEkspedisi, 4) : 0;
            // Generate id baru
            $model->id_kedatanganEkspedisi = 'KDE_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
        });
    }

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
