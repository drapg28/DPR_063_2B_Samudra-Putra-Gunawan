<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pengguna extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
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
    ];

    // HAPUS setPasswordAttribute - ini bikin password di-hash 2x!
    // public function setPasswordAttribute($value) { ... }
    
    public function getAuthIdentifierName()
    {
        return 'id_pengguna';
    }

    public function getNamaLengkapAttribute()
    {
        return $this->nama_depan . ' ' . $this->nama_belakang;
    }
}