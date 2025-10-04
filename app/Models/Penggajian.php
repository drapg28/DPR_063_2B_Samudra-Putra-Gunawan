<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajian';
    // Karena menggunakan composite key di skema SQL, kita non-aktifkan auto-increment
    protected $primaryKey = null; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_komponen_gaji', 
        'id_anggota',
    ];

    // Relasi ke Anggota DPR
    public function anggota()
    {
        return $this->belongsTo(AnggotaDPR::class, 'id_anggota', 'id_anggota');
    }

    // Relasi ke Komponen Gaji
    public function komponen()
    {
        return $this->belongsTo(KomponenGaji::class, 'id_komponen_gaji', 'id_komponen_gaji');
    }
}