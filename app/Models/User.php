<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'user'; // Nama tabel
    protected $primaryKey = 'username'; // Primary key sekarang username
    public $incrementing = false; // Karena primary key bukan auto increment
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $timestamps = false; // Jika tidak ada kolom created_at dan updated_at

    // Kolom yang bisa diisi
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];
    

    // Kolom yang disembunyikan dari array atau json output
    protected $hidden = [
        'password', // Sembunyikan password saat query
    ];

    // Override method untuk autentikasi
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getAuthIdentifier()
    {
        return $this->username;
    }
}