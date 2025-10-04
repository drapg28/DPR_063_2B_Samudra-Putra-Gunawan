<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Komponen Gaji</title>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        
        /* Navbar Styles */
        .navbar { background-color: #ffffff; padding: 1rem 2rem; border-bottom: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .navbar-content { display: flex; justify-content: space-between; align-items: center; max-width: 1280px; margin: 0 auto; }
        .navbar-brand { font-weight: bold; color: #1f2937; text-decoration: none; font-size: 1.1rem; }
        .navbar-links a { margin-left: 1rem; text-decoration: none; color: #4b5563; font-size: 0.9rem; }
        
        /* Header Title Styles */
        .header { background-color: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 1.5rem 2rem; }
        .header-content { max-width: 1280px; margin: 0 auto; padding-bottom: 10px; border-bottom: 2px solid #dc2626; }
        h2 { font-size: 1.6rem; font-weight: 700; color: #374151; margin: 0; }

        /* Main Content Styles */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem;
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            overflow-x: auto;
        }
        .message {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
        .message-success {
            background-color: #d1fae5;
            border: 1px solid #10b981;
            color: #065f46;
        }
        .message-error {
            background-color: #fee2e2;
            border: 1px solid #ef4444;
            color: #b91c1c;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.15s ease-in-out;
        }
        .btn-red {
            background-color: #dc2626;
            color: white;
        }
        .btn-red:hover {
            background-color: #b91c1c;
        }
        .btn-blue {
            background-color: #3b82f6;
            color: white;
        }
        .btn-blue:hover {
            background-color: #2563eb;
        }
        .search-form {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        .form-input {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
            margin-top: 1rem;
        }
        th, td {
            padding: 0.75rem 1.0rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.875rem;
            color: #4b5563;
        }
        th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #4b5563;
            text-transform: uppercase;
        }
        .link-action {
            text-decoration: none;
            margin-right: 0.75rem;
            font-size: 0.875rem;
        }
        .link-edit { color: #4f46e5; }
        .link-edit:hover { color: #3730a3; }
        .link-delete {
            color: #dc2626;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .link-delete:hover { color: #b91c1c; }
        .text-center { text-align: center; }
        .inline-form { display: inline; }
        
        /* Pagination Styles */
        .pagination-container { 
            margin-top: 1.5rem; 
        }
        .pagination-container .pagination-nav {
            display: flex;
            justify-content: space-between; /* Pisahkan summary dan links */
            align-items: center;
            width: 100%;
        }
        .pagination-summary {
            color: #4b5563;
            font-size: 0.875rem;
        }
        .pagination-links {
            display: flex;
            gap: 0.5rem; /* Jarak antar tombol/link */
        }
        .pagination-link {
            display: inline-block;
            padding: 0.5rem 0.75rem;
            line-height: 1.25;
            color: #4f46e5;
            background-color: #fff;
            border: 1px solid #dee2e6;
            text-decoration: none;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
        .pagination-link:hover:not(.disabled) {
            background-color: #f3f4f6;
        }
        .pagination-link.disabled {
            color: #6c757d;
            pointer-events: none;
            background-color: #f9fafb;
            border-color: #e5e7eb;
        }

    </style>
</head>
<body>

@auth
    <nav class="navbar">
        <div class="navbar-content">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand">APLIKASI GAJI DPR</a>
            <div class="navbar-links">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
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
        <h2>{{ __('Manajemen Komponen Gaji & Tunjangan') }}</h2>
    </div>
</header>

<div class="container">
    <div class="card">

        @if (session('success'))
            <div class="message message-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="message message-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="header-section">
            <a href="{{ route('salary-components.create') }}" class="btn btn-red">
                Tambah Komponen
            </a>
            
            <form method="GET" action="{{ route('salary-components.index') }}" class="search-form">
                <input id="search" name="search" type="text" class="form-input" placeholder="Cari Nama, Kategori, Jabatan, Nominal..." value="{{ (string) request('search') }}" />
                <button type="submit" class="btn btn-blue">Cari</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Komponen</th>
                    <th>Kategori</th>
                    <th>Jabatan</th>
                    <th>Nominal</th>
                    <th>Satuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($components as $item)
                    <tr>
                        <td>{{ $item->id_komponen_gaji }}</td>
                        <td>{{ $item->nama_komponen }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ number_format((float)$item->nominal, 2, ',', '.') }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>
                            <a href="{{ route('salary-components.edit', $item->id_komponen_gaji) }}" class="link-action link-edit">Ubah</a>
                            <form action="{{ route('salary-components.destroy', $item->id_komponen_gaji) }}" method="POST" class="inline-form" onsubmit="return confirm('PERINGATAN: Menghapus komponen gaji akan menghapus semua data penggajian terkait. Apakah Anda yakin ingin menghapus komponen ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="link-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="color: #6b7280;">
                            Tidak ada data komponen gaji yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $components->links('pagination::admin-simple') }}
        </div>
        
    </div>
</div>

</body>
</html>