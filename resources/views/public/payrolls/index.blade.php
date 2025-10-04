<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penggajian DPR</title>
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
        .container { max-width: 1280px; margin: 0 auto; padding: 2rem; }
        .card { background-color: #ffffff; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); padding: 1.5rem; overflow-x: auto; }
        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .btn-blue { background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; cursor: pointer; }
        .search-form { display: flex; gap: 0.5rem; align-items: center; }
        .form-input { padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem 1.0rem; text-align: left; border-bottom: 1px solid #e5e7eb; font-size: 0.875rem; color: #4b5563; }
        th { background-color: #f9fafb; font-weight: 600; color: #4b5563; text-transform: uppercase; }
        .link-detail { color: #007bff; text-decoration: underline; margin-right: 0.75rem; font-size: 0.875rem; }
        .text-center { text-align: center; }
        /* Pagination Styles */
        .pagination-container { margin-top: 1.5rem; }
        .pagination-container .pagination-nav { display: flex; justify-content: space-between; align-items: center; width: 100%; font-size: 0.875rem; }
        .pagination-summary { color: #4b5563; }
        .pagination-links { display: flex; gap: 0.5rem; }
        .pagination-link { display: inline-block; padding: 0.5rem 0.75rem; line-height: 1.25; color: #4f46e5; background-color: #fff; border: 1px solid #dee2e6; text-decoration: none; border-radius: 0.25rem; font-size: 0.875rem; }
        .pagination-link:hover:not(.disabled) { background-color: #f3f4f6; }
        .pagination-link.disabled { color: #6c757d; pointer-events: none; background-color: #f9fafb; border-color: #e5e7eb; }
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
        <h2>{{ __('Data Penggajian Anggota DPR (Read Only)') }}</h2>
    </div>
</header>

<div class="container">
    <div class="card">

        <div class="header-section">
            <h3 style="font-size: 1rem; color: #4b5563;">Ringkasan Data Penggajian</h3>
            
            <form method="GET" action="{{ route('public.payrolls.index') }}" class="search-form">
                <input id="search" name="search" type="text" class="form-input" placeholder="Cari Nama Anggota..." value="{{ is_array(request('search')) ? '' : request('search') }}" />
                <button type="submit" class="btn-blue">Cari</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan</th>
                    <th>Total Komponen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payrolls as $item)
                    <tr>
                        <td>{{ $item->id_anggota }}</td>
                        <td>
                            <a href="{{ route('public.payrolls.show', $item->id_anggota) }}" class="link-detail">
                                {{ $item->nama_lengkap }}
                            </a>
                        </td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ $item->total_komponen }} komponen</td>
                        <td>
                            <a href="{{ route('public.payrolls.show', $item->id_anggota) }}" class="link-detail">Lihat Detail THP</a>
                            </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="color: #6b7280;">
                            Tidak ada data penggajian yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="pagination-container">
            {{ $payrolls->links('pagination::admin-simple') }}
        </div>
    </div>
</div>

</body>
</html>