<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnggotaDPR;
use App\Models\KomponenGaji;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource (Lihat Data Penggajian - Read Only).
     */
    public function index(Request $request)
    {
        // Logika Grouping dan Join Tabel dari Controller Admin
        $query = AnggotaDPR::select('anggota.*')
            ->selectRaw('COUNT(penggajian.id_komponen_gaji) as total_komponen')
            ->leftJoin('penggajian', 'anggota.id_anggota', '=', 'penggajian.id_anggota');
            
        // Pencarian (disesuaikan dengan GROUP BY)
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama_depan', 'like', "%{$search}%")
                  ->orWhere('nama_belakang', 'like', "%{$search}%");
            });
        }
        
        // Perbaikan GROUP BY
        $query->groupBy(
            'anggota.id_anggota',
            'anggota.nama_depan',
            'anggota.nama_belakang',
            'anggota.gelar_depan',
            'anggota.gelar_belakang',
            'anggota.jabatan',
            'anggota.status_pernikahan',
            'anggota.jumlah_anak',
            'anggota.created_at',
            'anggota.updated_at'
        );
            
        $payrolls = $query->orderBy('anggota.id_anggota')->paginate(10); 

        return view('public.payrolls.index', compact('payrolls'));
    }

    /**
     * Display the specified resource (Lihat Detail Data Penggajian & Hitung THP).
     */
    public function show($id_anggota)
    {
        $anggota = AnggotaDPR::findOrFail($id_anggota);
        $related_components = $anggota->komponenGaji()->get();
        
        $total_gaji_bulan = 0;
        $total_gaji_periode = 0;
        $component_details = [];
        
        foreach ($related_components as $component) {
            $nominal = (float) $component->nominal;
            $calculated_value = 0;
            
            // Logika THP
            if ($component->nama_komponen == 'Tunjangan Istri/Suami') { 
                $calculated_value = ($anggota->status_pernikahan == 'Kawin') ? $nominal : 0;
            } elseif ($component->nama_komponen == 'Tunjangan Anak') { 
                $jumlah_anak_dihitung = min(2, $anggota->jumlah_anak); 
                $calculated_value = $nominal * $jumlah_anak_dihitung;
            } else {
                $calculated_value = $nominal;
            }
            
            $component_details[] = (object)[
                'nama_komponen' => $component->nama_komponen,
                'kategori' => $component->kategori,
                'satuan' => $component->satuan,
                'nominal_dasar' => $nominal, 
                'nominal_terhitung' => $calculated_value,
            ];

            if ($component->satuan == 'Bulan') {
                $total_gaji_bulan += $calculated_value;
            } elseif ($component->satuan == 'Periode') {
                $total_gaji_periode += $calculated_value;
            }
        }

        $thp_bulanan = $total_gaji_bulan;

        return view('public.payrolls.show', compact(
            'anggota',
            'component_details',
            'thp_bulanan',
            'total_gaji_periode'
        ));
    }
}