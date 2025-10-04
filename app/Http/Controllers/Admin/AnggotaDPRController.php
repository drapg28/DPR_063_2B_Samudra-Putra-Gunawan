<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// TAMBAHKAN: Import model AnggotaDPR (buat dulu jika belum ada)
// use App\Models\AnggotaDPR;

class AnggotaDPRController extends Controller
{
    // Use the 'admin' middleware for all methods
    public function __construct() { 
        $this->middleware('admin'); 
    }

    // Read: Menampilkan data sederhana
    public function index(Request $request)
    {
        // SEMENTARA: Karena model AnggotaDPR belum ada, return view kosong
        // Uncomment kode di bawah setelah model AnggotaDPR dibuat
        
        /*
        $query = AnggotaDPR::query();

        // Challenge: Search Multiple Column
        if ($search = $request->input('search')) {
            $query->where('Nama_Depan', 'like', "%{$search}%")
                  ->orWhere('Nama_Belakang', 'like', "%{$search}%")
                  ->orWhere('Jabatan', 'like', "%{$search}%")
                  ->orWhere('ID_Anggota', $search);
        }

        $anggota = $query->latest()->paginate(10);
        return view('admin.anggota.index', compact('anggota'));
        */
        
        // TEMPORARY: Return empty collection untuk testing
        $anggota = collect();
        return view('admin.dashboard'); // sementara ke dashboard
    }

    // Create: Input & Simpan Data dengan Validasi/Rule
    public function store(Request $request)
    {
        $request->validate([
            'Nama_Depan' => 'required|string|max:255',
            'Jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota',
            'Status_Pernikahan' => 'required|in:Kawin,Belum Kawin,Cerai',
            'Jumlah_Anak' => 'required|integer|min:0',
            'Gaji_Pokok' => 'required|numeric|min:0',
            'Tunjangan' => 'required|numeric|min:0',
        ]);

        // AnggotaDPR::create($request->all());
        return redirect()->route('anggota.index')->with('success', 'Data Anggota berhasil ditambahkan.');
    }

    // Update: Ubah data dengan Validasi/Rule
    public function update(Request $request, $id)
    {
        // Validation logic similar to store()
        // $anggotaDPR->update($request->all());
        return back()->with('success', 'Data Anggota berhasil diubah.');
    }

    // Delete: Hapus data dengan Validasi/Rule
    public function destroy($id)
    {
        // $anggotaDPR->delete();
        return back()->with('success', 'Data Anggota berhasil dihapus.');
    }
    
    // Method tambahan yang diperlukan untuk resource controller
    public function create()
    {
        return view('admin.dashboard'); // sementara
    }
    
    public function edit($id)
    {
        return view('admin.dashboard'); // sementara
    }
}