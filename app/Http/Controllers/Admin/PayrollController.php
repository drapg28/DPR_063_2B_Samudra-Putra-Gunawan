<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penggajian;
use App\Models\AnggotaDPR;
use App\Models\KomponenGaji;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function __construct() { 
        $this->middleware('role:Admin'); 
    }

    /**
     * Display a listing of the resource (Lihat Data Penggajian - Index).
     */
    public function index(Request $request)
    {
        $query = AnggotaDPR::select('anggota.*')
            ->selectRaw('COUNT(penggajian.id_komponen_gaji) as total_komponen')
            ->leftJoin('penggajian', 'anggota.id_anggota', '=', 'penggajian.id_anggota');
            
        // Pencarian
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama_depan', 'like', "%{$search}%")
                  ->orWhere('nama_belakang', 'like', "%{$search}%");
            });
        }
        
        // KOREKSI UTAMA: Mencantumkan semua kolom non-agregasi ke GROUP BY
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

        return view('admin.payrolls.index', compact('payrolls'));
    }

    /**
     * Show the form for creating a new resource (Tampilkan form Tambah Data).
     */
    public function create()
    {
        $anggotas = AnggotaDPR::all();
        $components = KomponenGaji::all();

        return view('admin.payrolls.create', compact('anggotas', 'components'));
    }

    /**
     * Store a newly created resource in storage (Simpan Data Penggajian Baru).
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_komponen_gaji' => 'required|array',
            'id_komponen_gaji.*' => 'exists:komponen_gaji,id_komponen_gaji',
        ], [
            'id_anggota.required' => 'Anggota DPR harus dipilih.',
            'id_komponen_gaji.required' => 'Minimal satu Komponen Gaji harus dipilih.',
        ]);

        $anggota = AnggotaDPR::findOrFail($request->id_anggota);
        $komponen_gaji_terpilih = $request->id_komponen_gaji;

        // 1. Validasi Komponen Gaji Berdasarkan Jabatan (Challenge 1)
        $komponen_tidak_sah = KomponenGaji::whereIn('id_komponen_gaji', $komponen_gaji_terpilih)
            ->where('jabatan', '!=', 'Semua')
            ->where('jabatan', '!=', $anggota->jabatan)
            ->pluck('nama_komponen');

        if ($komponen_tidak_sah->isNotEmpty()) {
            return back()->withInput()->withErrors([
                'id_komponen_gaji' => 'Komponen gaji berikut tidak sah untuk jabatan ' . $anggota->jabatan . ': ' . $komponen_tidak_sah->implode(', ')
            ]);
        }

        // 2. Validasi Duplikasi (Challenge 2)
        $existing_komponen = Penggajian::where('id_anggota', $anggota->id_anggota)
            ->whereIn('id_komponen_gaji', $komponen_gaji_terpilih)
            ->pluck('id_komponen_gaji')
            ->toArray();

        if (!empty($existing_komponen)) {
            $duplicated_names = KomponenGaji::whereIn('id_komponen_gaji', $existing_komponen)->pluck('nama_komponen')->implode(', ');
            return back()->withInput()->withErrors([
                'id_komponen_gaji' => 'Komponen gaji berikut sudah ditambahkan sebelumnya: ' . $duplicated_names
            ]);
        }
        
        // 3. Simpan data ke tabel penggajian (Pivot table)
        $data_to_insert = [];
        foreach ($komponen_gaji_terpilih as $komponen_id) {
            $data_to_insert[] = [
                'id_anggota' => $anggota->id_anggota,
                'id_komponen_gaji' => $komponen_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        Penggajian::insert($data_to_insert);

        return redirect()->route('payrolls.index')->with('success', 'Data Penggajian untuk ' . $anggota->nama_lengkap . ' berhasil ditambahkan.');
    }
    
    
    /**
     * Show the form for editing the specified resource (Tampilkan form Ubah Data).
     */
    public function edit($id_anggota) {
        $anggota = AnggotaDPR::findOrFail($id_anggota);
        $components = KomponenGaji::all();
        $selected_components = Penggajian::where('id_anggota', $id_anggota)->pluck('id_komponen_gaji')->toArray();
        
        return view('admin.payrolls.edit', compact('anggota', 'components', 'selected_components'));
    }

    /**
     * Update the specified resource in storage (Simpan perubahan data).
     */
    public function update(Request $request, $id_anggota) {
        $request->validate([
            'id_komponen_gaji' => 'required|array',
            'id_komponen_gaji.*' => 'exists:komponen_gaji,id_komponen_gaji',
        ], [
            'id_komponen_gaji.required' => 'Minimal satu Komponen Gaji harus dipilih.',
        ]);

        $anggota = AnggotaDPR::findOrFail($id_anggota);
        $komponen_gaji_terpilih = $request->id_komponen_gaji;

        // 1. Validasi Komponen Gaji Berdasarkan Jabatan
        $komponen_tidak_sah = KomponenGaji::whereIn('id_komponen_gaji', $komponen_gaji_terpilih)
            ->where('jabatan', '!=', 'Semua')
            ->where('jabatan', '!=', $anggota->jabatan)
            ->pluck('nama_komponen');

        if ($komponen_tidak_sah->isNotEmpty()) {
            return back()->withInput()->withErrors([
                'id_komponen_gaji' => 'Komponen gaji berikut tidak sah untuk jabatan ' . $anggota->jabatan . ': ' . $komponen_tidak_sah->implode(', ')
            ]);
        }
        
        // 2. Hapus semua data lama dan insert data baru
        Penggajian::where('id_anggota', $id_anggota)->delete();
        
        $data_to_insert = [];
        foreach ($komponen_gaji_terpilih as $komponen_id) {
            $data_to_insert[] = [
                'id_anggota' => $anggota->id_anggota,
                'id_komponen_gaji' => $komponen_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        Penggajian::insert($data_to_insert);

        return redirect()->route('payrolls.index')->with('success', 'Data Penggajian untuk ' . $anggota->nama_lengkap . ' berhasil diperbarui.');
    }
    
    
}