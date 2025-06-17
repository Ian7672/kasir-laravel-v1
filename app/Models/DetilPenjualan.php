<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetilPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detil_penjualan';
    protected $primaryKey = 'id_detil'; // Sesuaikan dengan PK tabel Anda
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'jml_barang',
        'harga_satuan'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}