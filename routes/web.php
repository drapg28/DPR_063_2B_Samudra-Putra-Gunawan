<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AnggotaDPRController;
use App\Http\Controllers\Admin\SalaryComponentController; // <-- BARIS BARU: Import Controller Komponen Gaji
use App\Http\Controllers\ProfileController;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Load auth routes
require __DIR__.'/auth.php';

// User Dashboard (authenticated users)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        \Log::info('Dashboard accessed', [
            'user' => auth()->user()->email,
            'role' => auth()->user()->role
        ]);
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - PENTING: role harus 'Admin' (case-sensitive sesuai database)
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        \Log::info('Admin dashboard accessed', [
            'user' => auth()->user()->email,
            'role' => auth()->user()->role
        ]);
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Anggota DPR CRUD
    Route::resource('anggota', AnggotaDPRController::class);
    
    // Komponen Gaji CRUD <-- BARIS KOREKSI
    Route::resource('salary-components', SalaryComponentController::class);
    
    // Placeholder routes untuk Penggajian
    Route::get('payrolls', function() {
        return view('admin.dashboard');
    })->name('payrolls.index');
});