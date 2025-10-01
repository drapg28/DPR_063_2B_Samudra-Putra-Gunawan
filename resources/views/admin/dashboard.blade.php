<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                
                {{-- Bagian Selamat Datang --}}
                <div class="flex flex-col md:flex-row items-center justify-between border-b pb-4 mb-6">
                    <h3 class="text-3xl font-bold text-gray-900">👋 Selamat Datang, Admin!</h3>
                    {{-- Asumsi Auth::user() tersedia karena ada middleware 'auth' --}}
                    <p class="text-gray-600 mt-2 md:mt-0 text-sm">Anda memiliki akses penuh untuk mengelola sistem. Peran: <span class="font-semibold text-red-600">{{ Auth::user()->role ?? 'Admin' }}</span></p>
                </div>

                <h4 class="text-xl font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-2">Menu Utama Administrasi</h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Merujuk pada route resource AnggotaDPRController yang bernama 'anggota' --}}
                    <a href="{{ route('anggota.index') }}" class="block p-6 bg-red-50 hover:bg-red-100 rounded-lg shadow-md transition duration-150 ease-in-out border-l-4 border-red-600 hover:shadow-lg">
                        <div class="flex items-center space-x-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.656-.126-1.283-.356-1.857M9 20l-4-4m0 0l-4-4m4 4v-4m0 4h4m-4 0v-4m0 4h4"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.222.608 3.218 0z"></path></svg>
                            <h4 class="text-xl font-semibold text-red-700">Manajemen Anggota DPR</h4>
                        </div>
                        <p class="text-gray-600 text-sm mt-2">Kelola data Anggota DPR: Tambah, Ubah, Hapus anggota, dan lihat detail.</p>
                    </a>

                    {{-- Merujuk pada resource 'salary-components' (asumsi Anda telah membuatnya) --}}
                    <a href="{{ route('salary-components.index') }}" class="block p-6 bg-blue-50 hover:bg-blue-100 rounded-lg shadow-md transition duration-150 ease-in-out border-l-4 border-blue-600 hover:shadow-lg">
                        <div class="flex items-center space-x-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-6 6h4m0 0h-4m0 4l-3 3m3-3v3m0 0h4m-4 0v-3"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M3 13V6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v2M8 11h2l-2 3"></path></svg>
                            <h4 class="text-xl font-semibold text-blue-700">Komponen Gaji & Tunjangan</h4>
                        </div>
                        <p class="text-gray-600 text-sm mt-2">Atur dan kelola komponen dasar (Gaji Pokok, Tunjangan, dll.) untuk perhitungan gaji.</p>
                    </a>

                    {{-- Merujuk pada rute 'payrolls.index' (asumsi Anda telah membuatnya) --}}
                    <a href="{{ route('payrolls.index') }}" class="block p-6 bg-green-50 hover:bg-green-100 rounded-lg shadow-md transition duration-150 ease-in-out border-l-4 border-green-600 hover:shadow-lg">
                        <div class="flex items-center space-x-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V9a2 2 0 00-2-2h-4a2 2 0 00-2 2v8a2 2 0 002 2h4a2 2 0 002-2v-1M12 8v1m0 0h4m0 0h-4m4 0l-3 3m3-3l-3 3"></path></svg>
                            <h4 class="text-xl font-semibold text-green-700">Data Penggajian (Payroll)</h4>
                        </div>
                        <p class="text-gray-600 text-sm mt-2">Hitung dan kelola catatan penggajian bulanan/tahunan (termasuk pemotongan/pajak).</p>
                    </a>

                </div>

                {{-- Informasi Tambahan/Peringatan --}}
                <div class="mt-10 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg">
                    <p class="font-medium">Perhatian:</p>
                    <p class="text-sm">Pastikan rute dan kontroler untuk `salary-components` dan `payrolls` telah didefinisikan dengan benar di `routes/web.php` agar tautan di atas berfungsi.</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>