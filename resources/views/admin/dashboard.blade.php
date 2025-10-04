<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - Gaji DPR</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8f9fa;
            color: #2d3748;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background: #ffffff;
            padding: 1.25rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a202c;
            letter-spacing: -0.02em;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 500;
            color: #2d3748;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #718096;
        }

        .btn-logout {
            background: #2d3748;
            color: white;
            padding: 0.5rem 1.25rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #1a202c;
            transform: translateY(-1px);
        }

        /* Container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        /* Welcome Section */
        .welcome {
            margin-bottom: 3rem;
        }

        .welcome h1 {
            font-size: 1.875rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .welcome p {
            color: #718096;
            font-size: 1rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.75rem;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .stat-card:hover {
            border-color: #cbd5e0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-label {
            color: #718096;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 600;
            color: #1a202c;
        }

        /* Menu Section */
        .section {
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 1.5rem;
            letter-spacing: -0.01em;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .menu-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
            display: block;
            position: relative;
        }

        .menu-card:hover {
            border-color: #2d3748;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .menu-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .menu-icon {
            width: 44px;
            height: 44px;
            background: #f7fafc;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .menu-badge {
            background: #edf2f7;
            color: #4a5568;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .menu-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .menu-description {
            font-size: 0.875rem;
            color: #718096;
            line-height: 1.6;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .info-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.75rem;
        }

        .info-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 1.25rem;
        }

        .info-list {
            list-style: none;
        }

        .info-item {
            padding: 0.875rem 0;
            border-bottom: 1px solid #f7fafc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #718096;
            font-size: 0.875rem;
        }

        .info-value {
            font-weight: 500;
            color: #2d3748;
            font-size: 0.875rem;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #2d3748;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #48bb78;
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Quick Links */
        .quick-links {
            list-style: none;
        }

        .quick-link {
            padding: 0.875rem 0;
            border-bottom: 1px solid #f7fafc;
            color: #4a5568;
            font-size: 0.875rem;
            transition: color 0.2s;
        }

        .quick-link:last-child {
            border-bottom: none;
        }

        .quick-link:hover {
            color: #c22323ff;
        }

        .quick-link::before {
            content: '→';
            margin-right: 0.5rem;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .quick-link:hover::before {
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1.5rem 1rem;
            }

            .welcome h1 {
                font-size: 1.5rem;
            }

            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem;
            }

            .navbar-user {
                width: 100%;
                justify-content: space-between;
            }

            .stats-grid,
            .menu-grid,
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">Gaji DPR RI</div>
        <div class="navbar-user">
            <div class="user-info">
                <div class="user-name">Admin DPR</div>
                <div class="user-role">Administrator</div>
            </div>
            <form method="POST" action="/logout" style="display: inline;">
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        
        <!-- Welcome -->
        <div class="welcome">
            <h1>Selamat Datang, Admin</h1>
            <p>Sistem Manajemen Transparansi Gaji DPR RI</p>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Anggota DPR</div>
                <div class="stat-value">6</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Ketua DPR</div>
                <div class="stat-value">1</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Wakil Ketua</div>
                <div class="stat-value">2</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Anggota</div>
                <div class="stat-value">3</div>
            </div>
        </div>

        <!-- Menu Section -->
        <div class="section">
            <h2 class="section-title">Menu Administrasi</h2>
            <div class="menu-grid">
                
                <a href="/admin/anggota" class="menu-card">
                    <div class="menu-card-header">
                        <div class="menu-icon">👥</div>
                        <div class="menu-badge">CRUD</div>
                    </div>
                    <div class="menu-title">Manajemen Anggota DPR</div>
                    <div class="menu-description">
                        Kelola data anggota DPR: Tambah, ubah, hapus, dan lihat detail informasi anggota.
                    </div>
                </a>

                <a href="/admin/salary-components" class="menu-card">
                    <div class="menu-card-header">
                        <div class="menu-icon">💰</div>
                        <div class="menu-badge">CRUD</div>
                    </div>
                    <div class="menu-title">Komponen Gaji & Tunjangan</div>
                    <div class="menu-description">
                        Atur dan kelola komponen gaji pokok, tunjangan melekat, dan tunjangan lain.
                    </div>
                </a>

                <a href="/admin/payrolls" class="menu-card">
                    <div class="menu-card-header">
                        <div class="menu-icon">📊</div>
                        <div class="menu-badge">Laporan</div>
                    </div>
                    <div class="menu-title">Data Penggajian</div>
                    <div class="menu-description">
                        Hitung dan kelola catatan penggajian bulanan/tahunan termasuk Take Home Pay.
                    </div>
                </a>

            </div>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            
            <div class="info-card">
                <h3 class="info-card-title">Informasi Sistem</h3>
                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Framework</span>
                        <span class="info-value">Laravel 9.x</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">PHP Version</span>
                        <span class="info-value">8.1</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Database</span>
                        <span class="info-value">MySQL</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Status</span>
                        <span class="status-indicator">
                            <span class="status-dot"></span>
                            Online
                        </span>
                    </li>
                </ul>
            </div>

            <div class="info-card">
                <h3 class="info-card-title">Quick Access</h3>
                <ul class="quick-links">
                    <li class="quick-link">Tambah Anggota Baru</li>
                    <li class="quick-link">Cari Anggota</li>
                    <li class="quick-link">Pengaturan Profil</li>
                    <li class="quick-link">Laporan Bulanan</li>
                </ul>
            </div>

        </div>

    </div>

</body>
</html>