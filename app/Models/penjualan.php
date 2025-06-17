<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    
    protected $primaryKey = 'id_transaksi'; // Diubah ke id_transaksi
    protected $dates = ['tgl_transaksi', 'created_at', 'updated_at'];
    public $timestamps = false;
        protected $casts = [
        'created_at' => 'datetime',
        'tgl_transaksi' => 'date',
    ];

    protected $fillable = [
        'id_pelanggan',
        'tgl_transaksi',
        'total_transaksi',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function detilPenjualan(): HasMany
    {
        return $this->hasMany(DetilPenjualan::class, 'id_transaksi');
    }
}