<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penggajian {{ $anggota->nama_lengkap }}</title>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        /* CSS Umum */
        .navbar { background-color: #ffffff; padding: 1rem 2rem; border-bottom: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .navbar-content { display: flex; justify-content: space-between; align-items: center; max-width: 1280px; margin: 0 auto; }
        .navbar-brand { font-weight: bold; color: #dc2626; text-decoration: none; font-size: 1.1rem; }
        .navbar-links a { margin-left: 1rem; text-decoration: none; color: #4b5563; font-size: 0.9rem; }
        .header { background-color: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 1.5rem 2rem; }
        .header-content { max-width: 1280px; margin: 0 auto; padding-bottom: 10px; border-bottom: 2px solid #3b82f6; }
        h2 { font-size: 1.6rem; font-weight: 700; color: #374151; margin: 0; }
        /* Detail Styles */
        .container { max-width: 1000px; margin: 0 auto; padding: 2rem; }
        .card { background-color: #ffffff; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); padding: 1.5rem; margin-bottom: 1.5rem; }
        .back-link { display: block; margin-bottom: 1.5rem; color: #4f46e5; text-decoration: none; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 1.5rem; }
        .detail-item { padding: 8px 0; border-bottom: 1px dashed #e5e7eb; }
        .detail-item strong { display: inline-block; width: 150px; color: #6b7280; font-weight: 500; font-size: 0.875rem; }
        .thp-box { background-color: #3b82f6; color: white; padding: 1.5rem; border-radius: 0.5rem; text-align: center; }
        .thp-box h3 { margin: 0 0 5px 0; font-size: 1.2rem; }
        .thp-value { font-size: 2.5rem; font-weight: 700; }
        h3.section-title { font-size: 1.2rem; font-weight: 600; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #d1d5db; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem 1.0rem; text-align: left; border-bottom: 1px solid #e5e7eb; font-size: 0.875rem; color: #4b5563; }
        th { background-color: #f9fafb; font-weight: 600; color: #4b5563; text-transform: uppercase; }
    </style>
</head>
<body>

@auth
    <nav class="navbar">
        <div class="navbar-content">
            {{-- KOREKSI 1: Logo link ke Public Dashboard --}}
            <a href="{{ route('public.dashboard') }}" class="navbar-brand">TRANSPARANSI GAJI DPR</a>
            <div class="navbar-links">
                {{-- KOREKSI 2: Link Dashboard ke Public Dashboard --}}
                <a href="{{ route('public.dashboard') }}">Dashboard</a>
                <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="color: #dc2626; background: none; border: none; cursor: pointer; padding: 0 0 0 1rem; font-size: 0.9rem;">Log Out</button>
                </form>
            </div>
        </div>
    </nav>
@endauth

<header class="header">
    <div class="header-content">
        <h2>{{ __('Detail Penggajian Anggota: ' . $anggota->nama_lengkap) }}</h2>
    </div>
</header>

<div class="container">
    <a href="{{ route('public.payrolls.index') }}" class="back-link">← Kembali ke Daftar Penggajian</a>

    <div class="card">
        <div class="detail-grid">
            <div>
                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem;">Data Anggota</h3>
                <div class="detail-item"><strong>ID Anggota:</strong> {{ $anggota->id_anggota }}</div>
                <div class="detail-item"><strong>Nama Lengkap:</strong> {{ $anggota->nama_lengkap }}</div>
                <div class="detail-item"><strong>Jabatan:</strong> {{ $anggota->jabatan }}</div>
            </div>
            <div>
                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem;">Status Keluarga</h3>
                <div class="detail-item"><strong>Status Nikah:</strong> {{ $anggota->status_pernikahan }}</div>
                <div class="detail-item"><strong>Jumlah Anak:</strong> {{ $anggota->jumlah_anak }}</div>
                <div class="detail-item" style="color: #6b7280;">*Tunjangan anak maksimal dihitung untuk 2 anak.</div>
            </div>
        </div>
        
        <div class="thp-box">
            <h3>TOTAL TAKE HOME PAY (THP) BULANAN</h3>
            <div class="thp-value">
                Rp. {{ number_format($thp_bulanan, 0, ',', '.') }}
            </div>
            <p style="font-size: 0.9rem; margin-top: 10px;">(Tidak termasuk tunjangan satuan Periode: Rp. {{ number_format($total_gaji_periode, 0, ',', '.') }})</p>
        </div>
    </div>
    
    <div class="card">
        <h3 class="section-title">Komponen Gaji yang Diperoleh ({{ count($component_details) }} item)</h3>
        
        <table>
            <thead>
                <tr>
                    <th>Komponen Gaji</th>
                    <th>Satuan</th>
                    <th>Nominal Dasar</th>
                    <th>Nominal Terhitung</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($component_details as $item)
                    <tr>
                        <td>{{ $item->nama_komponen }} ({{ $item->kategori }})</td>
                        <td>{{ $item->satuan }}</td>
                        <td>Rp. {{ number_format($item->nominal_dasar, 0, ',', '.') }}</td>
                        <td style="font-weight: 600;">
                            Rp. {{ number_format($item->nominal_terhitung, 0, ',', '.') }}
                            @if ($item->nominal_terhitung != $item->nominal_dasar)
                                <span style="font-weight: 400; font-size: 0.75rem; color: #059669;">(Disesuaikan)</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada komponen gaji tercatat untuk anggota ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>
</html>