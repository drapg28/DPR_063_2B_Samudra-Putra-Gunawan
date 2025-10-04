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


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); 
// Rute untuk memproses data login
Route::post('/login', [AuthController::class, 'login']);
// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');

    Route::resource('members', MemberController::class)->except(['show']);

    Route::resource('salary-components', SalaryComponentController::class)->except(['show']);
    
    Route::resource('payrolls', PayrollController::class)->except(['index', 'show']); 
    
    // Rute Tampilan Data Penggajian Admin (index & detail)
    Route::get('/payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
    Route::get('/payrolls/{member}', [PayrollController::class, 'show'])->name('payrolls.show');

});


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


use App\Http\Controllers\Admin\AnggotaDPRController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Memuat file yang baru kita buat
    })->name('admin.dashboard'); // Rute ADMIN_DASHBOARD

    // Contoh Rute CRUD Anggota DPR
    Route::resource('anggota', AnggotaDPRController::class)->names('anggota');
    

});