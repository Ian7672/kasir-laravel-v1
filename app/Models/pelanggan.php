<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'gender',
    ];

    protected $primaryKey = 'id_pelanggan';

    public $timestamps = false;

    protected $table = 'pelanggan';

    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'id_pelanggan');
    }
}