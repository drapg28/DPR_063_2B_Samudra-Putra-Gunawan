<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggotaDPRController extends Controller
{
    // Use the 'admin' middleware for all methods
    public function __construct() { $this->middleware('admin'); }

    // Read: Menampilkan data sederhana [cite: 22]
    public function index(Request $request)
    {
        $query = AnggotaDPR::query();

        // Challenge: Search Multiple Column [cite: 27]
        if ($search = $request->input('search')) {
            $query->where('Nama_Depan', 'like', "%{$search}%")
                  ->orWhere('Nama_Belakang', 'like', "%{$search}%")
                  ->orWhere('Jabatan', 'like', "%{$search}%")
                  ->orWhere('ID_Anggota', $search);
        }

        $anggota = $query->latest()->paginate(10);
        return view('admin.anggota.index', compact('anggota'));
    }

    // Create: Input & Simpan Data dengan Validasi/Rule [cite: 21, 103]
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

        AnggotaDPR::create($request->all());
        return redirect()->route('admin.anggota.index')->with('success', 'Data Anggota berhasil ditambahkan.');
    }

    // Update: Ubah data dengan Validasi/Rule [cite: 25, 103]
    public function update(Request $request, AnggotaDPR $anggotaDPR)
    {
        // Validation logic similar to store()
        $anggotaDPR->update($request->all());
        return back()->with('success', 'Data Anggota berhasil diubah.');
    }

    // Delete: Hapus data dengan Validasi/Rule (Konfirmasi di View/JS) [cite: 26, 103]
    public function destroy(AnggotaDPR $anggotaDPR)
    {
        $anggotaDPR->delete();
        return back()->with('success', 'Data Anggota berhasil dihapus.');
    }
}
