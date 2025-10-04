<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenGaji extends Model
{
    use HasFactory;

    protected $table = 'komponen_gaji';
    protected $primaryKey = 'id_komponen_gaji';
    public $timestamps = true;

    protected $fillable = [
        'nama_komponen',
        'kategori', 
        'jabatan',  
        'nominal',
        'satuan', 
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];
    
    public function anggotaDPR()
    {
        return $this->belongsToMany(
            AnggotaDPR::class,
            'penggajian',
            'id_komponen_gaji',
            'id_anggota'
        );
    }
}