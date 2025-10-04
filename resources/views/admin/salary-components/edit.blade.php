<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Komponen Gaji</title>
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
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        .form-input, .form-select {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            font-size: 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-input:focus, .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            outline: none;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.5rem;
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
        .btn-primary {
            background-color: #1f2937;
            color: white;
        }
        .btn-primary:hover {
            background-color: #374151;
        }
        .back-link {
            display: block;
            margin-bottom: 1.5rem;
            color: #4f46e5;
            text-decoration: none;
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
        <h2>{{ __('Ubah Komponen Gaji: ' . $component->nama_komponen) }}</h2>
    </div>
</header>

<div class="container">
    <div class="card">

        <a href="{{ route('salary-components.index') }}" class="back-link">← Kembali ke Daftar Komponen Gaji</a>
        
        <form method="POST" action="{{ route('salary-components.update', $component) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_komponen" class="form-label">Nama Komponen</label>
                <input id="nama_komponen" name="nama_komponen" type="text" class="form-input" value="{{ old('nama_komponen', $component->nama_komponen) }}" required autofocus />
                @error('nama_komponen')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori" class="form-label">Kategori</label>
                <select id="kategori" name="kategori" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('kategori', $component->kategori) == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @error('kategori')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jabatan" class="form-label">Jabatan (Siapa yang Berhak Menerima)</label>
                <select id="jabatan" name="jabatan" class="form-select" required>
                    <option value="">Pilih Jabatan</option>
                    @foreach($positions as $position)
                        <option value="{{ $position }}" {{ old('jabatan', $component->jabatan) == $position ? 'selected' : '' }}>{{ $position }}</option>
                    @endforeach
                </select>
                @error('jabatan')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nominal" class="form-label">Nominal (Rp.)</label>
                <input id="nominal" name="nominal" type="number" step="0.01" class="form-input" value="{{ old('nominal', $component->nominal) }}" required />
                @error('nominal')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="satuan" class="form-label">Satuan</label>
                <select id="satuan" name="satuan" class="form-select" required>
                    <option value="">Pilih Satuan</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit }}" {{ old('satuan', $component->satuan) == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                    @endforeach
                </select>
                @error('satuan')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>


            <div style="padding-top: 1rem;">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>