<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SalaryComponentController;
use App\Http\Controllers\PayrollController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute ini dimuat oleh RouteServiceProvider dalam grup middleware "web".
|
*/

// Rute Default / Welcome Page
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Autentikasi (Login & Logout)
|--------------------------------------------------------------------------
*/
// Rute untuk menampilkan form login (diberi nama 'login' untuk redirect/link)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); 
// Rute untuk memproses data login
Route::post('/login', [AuthController::class, 'login']);
// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Rute Admin (CRUD Penuh) - Membutuhkan 'auth' & 'role:admin'
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin (Tujuan utama setelah login berhasil)
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');

    // CRUD Anggota DPR
    Route::resource('members', MemberController::class)->except(['show']);

    // CRUD Komponen Gaji & Tunjangan
    Route::resource('salary-components', SalaryComponentController::class)->except(['show']);

    // CRUD Data Penggajian
    // Kita hapus metode index/show default di sini dan definisikan secara manual
    // di bawah agar bisa menggunakan nama yang sama dengan public
    Route::resource('payrolls', PayrollController::class)->except(['index', 'show']); 
    
    // Rute Tampilan Data Penggajian Admin (index & detail)
    Route::get('/payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
    Route::get('/payrolls/{member}', [PayrollController::class, 'show'])->name('payrolls.show');

});


/*
|--------------------------------------------------------------------------
| Rute Public (Client) - Akses Baca Saja (Read-Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:public'])->group(function () {

    // Read Only Data Anggota
    Route::get('/members', [MemberController::class, 'indexPublic'])->name('members.index.public'); 

    // Read Only Data Penggajian (Ringkasan & Detail)
    Route::get('/payrolls', [PayrollController::class, 'indexPublic'])->name('payrolls.index.public');
    Route::get('/payrolls/{member}', [PayrollController::class, 'showPublic'])->name('payrolls.show.public');
});

Route::middleware('auth')->group(function () {
    // Rute dashboard default untuk pengguna biasa
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard'); // rute HOME

    // Rute Profile (sudah ada di navigation.blade.php dan profile controller)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Rute Admin (CRUD Penuh)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\AnggotaDPRController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Memuat file yang baru kita buat
    })->name('admin.dashboard'); // Rute ADMIN_DASHBOARD

    // Contoh Rute CRUD Anggota DPR
    // Perhatikan bahwa AnggotaDPRController memiliki middleware 'admin' di __construct
    Route::resource('anggota', AnggotaDPRController::class)->names('anggota');
    
    // ... Tambahkan rute CRUD lainnya di sini (salary-components, payrolls)

});