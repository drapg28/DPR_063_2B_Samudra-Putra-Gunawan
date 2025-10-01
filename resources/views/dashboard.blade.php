<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gaji DPR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="antialiased h-screen flex items-center justify-center">

    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-xl shadow-2xl transition duration-500 hover:shadow-3xl">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Aplikasi Gaji DPR</h1>
            <p class="text-gray-600 text-sm">Masuk untuk melanjutkan ke sistem.</p>
        </div>

        <form class="space-y-6" method="POST" action="{{ url('/login') }}">
            @csrf

            {{-- PERBAIKAN: Cek apakah variabel $errors tersedia sebelum memanggil $errors->any() --}}
            @if (isset($errors) && $errors->any())
                <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                    Mohon periksa kembali input Anda.
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" autocomplete="email" required 
                       value="{{ old('email') }}"
                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm 
                              {{-- PERBAIKAN: Cek apakah $errors tersedia sebelum memanggil $errors->has('email') --}}
                              @if (isset($errors) && $errors->has('email')) border-red-500 @endif"
                       placeholder="Masukkan email Anda">
                
                {{-- PERBAIKAN: Cek apakah $errors tersedia sebelum menggunakan @error --}}
                @if (isset($errors))
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
                @endif
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                       placeholder="Masukkan kata sandi">
                
                {{-- PERBAIKAN: Cek apakah $errors tersedia sebelum menggunakan @error --}}
                @if (isset($errors))
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
                @endif
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-4a3 3 0 013-3h12"></path></svg>
                    Masuk ke Sistem
                </button>
            </div>
        </form>
    </div>

    </body>
</html>