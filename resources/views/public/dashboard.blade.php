<?php
// File: resources/views/public/dashboard.blade.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Transparansi Publik</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f4f5f7;
            color: #1f2937;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background: #ffffff;
            padding: 1.25rem 2rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: #3b82f6; 
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
            font-weight: 600;
            color: #1f2937;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .btn-logout {
            background: #dc2626; /* Red for Logout */
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
            background: #b91c1c; 
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
            margin-bottom: 2rem; 
            padding: 1.5rem;
            background: #ffffff;
            border-radius: 8px;
            border-left: 5px solid #3b82f6; /* Blue Accent */
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .welcome h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .welcome p {
            color: #6b7280;
            font-size: 1rem;
        }
        
        /* DOM Feedback Style */
        .feedback {
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 6px;
            font-weight: 600;
        }


        .stats-grid {
            /* Display grid of dummy data or remove if not needed */
            display: none; 
        }

        /* Menu Section */
        .section {
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
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
            cursor: pointer;
        }

        .menu-card:hover {
            border-color: #3b82f6; /* Blue Border on hover */
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
            background: #eff6ff; /* Light Blue Background */
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #3b82f6; /* Blue Icon */
        }

        .menu-badge {
            background: #eff6ff;
            color: #3b82f6;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .menu-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .menu-description {
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.6;
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
            .menu-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    @auth
    <nav class="navbar">
        <div class="navbar-content">
            <div class="navbar-brand">TRANSPARANSI GAJI DPR</div>
            <div class="navbar-user">
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Pengguna Publik</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <div class="container">
        
        <div class="welcome">
            <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
            <p>Sistem Informasi Transparansi Gaji DPR RI. Data di bawah adalah akses publik (Read Only).</p>
        </div>

        <div id="action-feedback" class="feedback" style="display: none;"></div>

        <div class="section">
            <h2 class="section-title">Akses Data Transparansi</h2>
            <div class="menu-grid">
                
                <a href="{{ route('public.anggota.index') }}" class="menu-card">
                    <div class="menu-card-header">
                        <div class="menu-icon">👥</div>
                        <div class="menu-badge">DATA ANGGOTA</div>
                    </div>
                    <div class="menu-title">Data Anggota DPR</div>
                    <div class="menu-description">
                        Lihat informasi lengkap Anggota DPR RI sesuai data master (Read Only).
                    </div>
                </a>

                <a href="{{ route('public.payrolls.index') }}" class="menu-card">
                    <div class="menu-card-header">
                        <div class="menu-icon">💰</div>
                        <div class="menu-badge">DATA PENGGAJIAN</div>
                    </div>
                    <div class="menu-title">Penggajian & Take Home Pay</div>
                    <div class="menu-description">
                        Akses ringkasan gaji, komponen tunjangan, dan perhitungan THP per anggota.
                    </div>
                </a>

            </div>
        </div>

    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuCards = document.querySelectorAll('.menu-card');
            const feedbackDiv = document.getElementById('action-feedback');

            menuCards.forEach(card => {
                card.addEventListener('click', function(event) {
                    event.preventDefault(); 
                    
                    const title = card.querySelector('.menu-title').textContent;
                    const href = card.getAttribute('href');
                    
                    // --- DOM MANIPULATION ---
                    
                    feedbackDiv.textContent = 'Membuka modul: "' + title + '". Mohon Tunggu...';
                    
                    feedbackDiv.style.display = 'block';
                    feedbackDiv.style.background = '#eff6ff'; // Light Blue
                    feedbackDiv.style.color = '#1e3a8a'; // Dark Blue Text
                    feedbackDiv.style.borderColor = '#3b82f6'; // Blue Border
                    feedbackDiv.style.border = '1px solid #3b82f6';

                    // Delay navigasi untuk memperlihatkan feedback
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500); 
                });
            });
        });
    </script>
</body>
</html>