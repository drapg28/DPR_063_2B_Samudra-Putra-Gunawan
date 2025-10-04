<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AnggotaDPRController; 
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Rute yang membutuhkan autentikasi
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Dashboard default untuk user biasa
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rute Admin (CRUD Penuh) - Membutuhkan 'auth' & 'role:admin'
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin (Tujuan ADMIN_DASHBOARD)
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // CRUD Anggota DPR
    Route::resource('anggota', AnggotaDPRController::class)->names('anggota');
    
    // Placeholder routes untuk salary-components (buat nanti)
    Route::get('salary-components', function() {
        return view('admin.dashboard'); // sementara redirect ke dashboard
    })->name('salary-components.index');
    
    // Placeholder routes untuk payrolls (buat nanti)
    Route::get('payrolls', function() {
        return view('admin.dashboard'); // sementara redirect ke dashboard
    })->name('payrolls.index');
});