<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnggotaDPR;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource (Lihat Data Anggota - Read Only).
     */
    public function index(Request $request)
    {
        $query = AnggotaDPR::query();

        // Pencarian (Challenge: Search Multiple Column)
        if ($search = $request->input('search')) {
            $query->where('nama_depan', 'like', "%{$search}%")
                  ->orWhere('nama_belakang', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('id_anggota', $search);
        }

        $anggota = $query->latest('id_anggota')->paginate(10);
        
        return view('public.anggota.index', compact('anggota'));
    }
}