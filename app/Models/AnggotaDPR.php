<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaDPR extends Model
{
    use HasFactory;

    // EXPLICIT: Nama tabel di database
    protected $table = 'anggota';
    
    // Primary key
    protected $primaryKey = 'id_anggota';
    
    // Timestamps
    public $timestamps = true;

    // Kolom yang bisa diisi mass assignment
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'gelar_depan',
        'gelar_belakang',
        'jabatan',
        'status_pernikahan',
        'jumlah_anak',
    ];

    // Casting tipe data
    protected $casts = [
        'jumlah_anak' => 'integer',
    ];

    // Relasi ke tabel penggajian
    public function komponenGaji()
    {
        return $this->belongsToMany(
            KomponenGaji::class,
            'penggajian',
            'id_anggota',
            'id_komponen_gaji'
        );
    }

    // Accessor untuk nama lengkap dengan gelar
    public function getNamaLengkapAttribute()
    {
        $nama = '';
        
        if ($this->gelar_depan) {
            $nama .= $this->gelar_depan . ' ';
        }
        
        $nama .= $this->nama_depan . ' ' . $this->nama_belakang;
        
        if ($this->gelar_belakang) {
            $nama .= ', ' . $this->gelar_belakang;
        }
        
        return $nama;
    }
}