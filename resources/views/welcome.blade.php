<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - Aplikasi Gaji DPR</title>
    <!-- Memuat Tailwind CSS untuk tampilan -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <div class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
        
        <!-- Navbar/Auth Links -->
        <div class="fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <!-- Jika sudah login, tampilkan tombol ke Dashboard -->
                <a href="{{ url('/admin/dashboard') }}" class="text-sm text-gray-700 underline hover:text-red-600">Dashboard</a>
            @else
                <!-- Jika belum login, tampilkan link Login -->
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline hover:text-red-600">Log in</a>
            @endif
        </div>

        <!-- Main Content Area -->
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <h1 class="text-6xl font-extrabold text-gray-900 leading-none">
                    <span class="text-red-600">Gaji</span> DPR RI
                </h1>
            </div>

            <div class="mt-12 bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                <div class="text-center">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                        Aplikasi Perhitungan &amp; Transparansi Gaji
                    </h2>
                    <p class="text-gray-600 max-w-lg mx-auto">
                        Sistem ini bertujuan untuk menyediakan informasi yang transparan dan akuntabel mengenai komponen penghasilan, tunjangan, dan perhitungan Take Home Pay (THP) anggota DPR RI.
                    </p>
                </div>
                
                <div class="mt-8 text-center">
                    <h3 class="text-xl font-medium text-red-600 mb-4">Akses Aplikasi</h3>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                        Masuk ke Sistem Transparansi
                    </a>
                </div>

                <div class="mt-12 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Informasi Proyek</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><strong>Framework:</strong> Laravel</li>
                        <li><strong>Fokus:</strong> CRUD Anggota, Komponen Gaji, dan Logika Perhitungan THP</li>
                        <li><strong>Stakeholder:</strong> Admin (Full Akses) dan Public/Client (Baca Saja)</li>
                    </ul>
                </div>
            </div>

            <div class="flex justify-center mt-6">
                <div class="text-center text-sm text-gray-500">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </div>
</body>
</html>
