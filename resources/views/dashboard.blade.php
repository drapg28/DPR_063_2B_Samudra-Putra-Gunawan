<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h3>
                    <p class="mb-4">Anda login sebagai: <strong>{{ Auth::user()->role }}</strong></p>
                    <p class="mb-4">Email: {{ Auth::user()->email }}</p>
                    
                    <div class="mt-6">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                            Ke Admin Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>