<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AnggotaDPRController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - PASTIKAN SEMUA MENGGUNAKAN MIDDLEWARE WEB
|--------------------------------------------------------------------------
*/

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Routes - LOAD DARI auth.php (SUDAH ADA MIDDLEWARE WEB)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Rute yang membutuhkan autentikasi
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
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
| Rute Admin (CRUD Penuh)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::resource('anggota', AnggotaDPRController::class);
    
    // Placeholder routes untuk salary-components
    Route::get('salary-components', function() {
        return view('admin.dashboard');
    })->name('salary-components.index');
    
    // Placeholder routes untuk payrolls
    Route::get('payrolls', function() {
        return view('admin.dashboard');
    })->name('payrolls.index');
});