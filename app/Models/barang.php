<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'harga_barang',
        'stock',
    ];

    protected $primaryKey = 'id_barang';

    // Nonaktifkan timestamps
    public $timestamps = false;

    protected $table = 'barang';
}