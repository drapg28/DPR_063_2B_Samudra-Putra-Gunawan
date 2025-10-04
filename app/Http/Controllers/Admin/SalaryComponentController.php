<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KomponenGaji;

class SalaryComponentController extends Controller
{
    public function __construct() { 
        $this->middleware('role:Admin'); 
    }

    /**
     * Display a listing of the resource (Lihat Komponen Gaji - Read & Search).
     */
    public function index(Request $request)
    {
        $query = KomponenGaji::query();

        if ($search = $request->input('search')) {
            $query->where('nama_komponen', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('satuan', 'like', "%{$search}%")
                  ->orWhere('id_komponen_gaji', $search)
                  ->orWhere('nominal', 'like', "%{$search}%");
        }

        $components = $query->latest('id_komponen_gaji')->paginate(10);
        
        return view('admin.salary-components.index', compact('components'));
    }

    /**
     * Show the form for creating a new resource (Tampilkan form Tambah Data).
     */
    public function create()
    {
        // Data ENUM untuk dropdown
        $categories = ['Gaji Pokok', 'Tunjangan Melekat', 'Tunjangan Lain'];
        $positions = ['Ketua', 'Wakil Ketua', 'Anggota', 'Semua'];
        $units = ['Bulan', 'Hari', 'Periode'];

        return view('admin.salary-components.create', compact('categories', 'positions', 'units'));
    }

    /**
     * Store a newly created resource in storage (Simpan Komponen Gaji Baru - Create).
     */
    public function store(Request $request)
    {
        // Validasi dengan rule [cite: 103]
        $request->validate([
            'nama_komponen' => 'required|string|max:100',
            'kategori' => 'required|in:Gaji Pokok,Tunjangan Melekat,Tunjangan Lain',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota,Semua',
            'nominal' => 'required|numeric|min:0',
            'satuan' => 'required|in:Bulan,Hari,Periode',
        ]);

        KomponenGaji::create($request->all());

        return redirect()->route('salary-components.index')->with('success', 'Komponen Gaji "' . $request->nama_komponen . '" berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource (Tampilkan form Ubah Data).
     */
    public function edit($id_komponen_gaji)
    {
        $component = KomponenGaji::findOrFail($id_komponen_gaji);
        $categories = ['Gaji Pokok', 'Tunjangan Melekat', 'Tunjangan Lain'];
        $positions = ['Ketua', 'Wakil Ketua', 'Anggota', 'Semua'];
        $units = ['Bulan', 'Hari', 'Periode'];

        return view('admin.salary-components.edit', compact('component', 'categories', 'positions', 'units'));
    }

    /**
     * Update the specified resource in storage (Simpan perubahan data - Update).
     */
    public function update(Request $request, $id_komponen_gaji)
    {
        $component = KomponenGaji::findOrFail($id_komponen_gaji);

        // Validasi dengan rule [cite: 103]
        $request->validate([
            'nama_komponen' => 'required|string|max:100',
            'kategori' => 'required|in:Gaji Pokok,Tunjangan Melekat,Tunjangan Lain',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota,Semua',
            'nominal' => 'required|numeric|min:0',
            'satuan' => 'required|in:Bulan,Hari,Periode',
        ]);
        
        $component->update($request->all());

        return redirect()->route('salary-components.index')->with('success', 'Komponen Gaji "' . $component->nama_komponen . '" berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (Hapus Data - Delete).
     */
    public function destroy($id_komponen_gaji)
    {
        $component = KomponenGaji::findOrFail($id_komponen_gaji);
        $component_name = $component->nama_komponen; 
        
        $component->delete();
        
        return redirect()->route('salary-components.index')->with('success', 'Komponen Gaji "' . $component_name . '" berhasil dihapus.');
    }
}