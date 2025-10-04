<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnggotaDPR;

class AnggotaDPRController extends Controller
{
    // Menggunakan middleware 'role:Admin'
    public function __construct() { 
        $this->middleware('role:Admin'); 
    }

    /**
     * Display a listing of the resource (Lihat Data Anggota - Read & Search).
     */
    public function index(Request $request)
    {
        $query = AnggotaDPR::query();

        // Challenge: Search Multiple Column
        if ($search = $request->input('search')) {
            $query->where('nama_depan', 'like', "%{$search}%")
                  ->orWhere('nama_belakang', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('id_anggota', $search);
        }

        // Ambil data terbaru dengan pagination
        $anggota = $query->latest('id_anggota')->paginate(10);
        
        return view('admin.anggota.index', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource (Tampilkan form Tambah Data).
     */
    public function create()
    {
        return view('admin.anggota.create');
    }

    /**
     * Store a newly created resource in storage (Simpan Data Anggota Baru - Create).
     */
    public function store(Request $request)
    {
        // Validasi sesuai skema SQL
        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'nullable|string|max:100',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota',
            'status_pernikahan' => 'required|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'jumlah_anak' => 'required|integer|min:0',
        ]);

        AnggotaDPR::create($request->all());

        return redirect()->route('anggota.index')->with('success', 'Data Anggota ' . $request->nama_depan . ' berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource (Tampilkan form Ubah Data).
     * Menggunakan Route Model Binding untuk AnggotaDPR $anggota.
     */
    public function edit(AnggotaDPR $anggota)
    {
        return view('admin.anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage (Simpan perubahan data - Update).
     */
    public function update(Request $request, AnggotaDPR $anggota)
    {
        // Validasi
        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'nullable|string|max:100',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota',
            'status_pernikahan' => 'required|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'jumlah_anak' => 'required|integer|min:0',
        ]);
        
        $anggota->update($request->all());

        return redirect()->route('anggota.index')->with('success', 'Data Anggota ' . $anggota->nama_lengkap . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (Hapus Data - Delete).
     */
    public function destroy(AnggotaDPR $anggota)
    {
        $anggota_name = $anggota->nama_lengkap; 
        
        // PENTING: Karena tidak menggunakan migrasi, kita asumsikan database
        // sudah diatur untuk CASCADE ON DELETE di tabel `penggajian`.
        // Jika tidak, hapus data penggajian terkait harus dilakukan manual sebelum
        // AnggotaDPR::delete() untuk menghindari error foreign key.
        
        $anggota->delete();
        
        return redirect()->route('anggota.index')->with('success', 'Data Anggota ' . $anggota_name . ' berhasil dihapus.');
    }
}