<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pengguna extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // Nama tabel sesuai database
    protected $table = 'pengguna';
    
    // Primary key
    protected $primaryKey = 'id_pengguna';
    
    // Aktifkan timestamps karena database memiliki created_at/updated_at
    public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'email',
        'nama_depan',
        'nama_belakang',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    // Override untuk Laravel Auth
    public function getAuthIdentifierName()
    {
        return 'id_pengguna';
    }
}