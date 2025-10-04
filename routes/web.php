<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AnggotaDPRController;
use App\Http\Controllers\Admin\SalaryComponentController; 
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\AnggotaController as PublicAnggotaController;
use App\Http\Controllers\Public\PayrollController as PublicPayrollController;

Route::get('/', function () {
    return view('welcome');
});

// Load auth routes
require __DIR__.'/auth.php';

// User Group (authenticated users)
Route::middleware(['auth'])->group(function () {
    // Profile routes (tetap)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Public/Client Routes - Read Only Access
Route::middleware(['auth', 'role:Public'])->group(function () {
  
    Route::get('/public/dashboard', function () {
        return view('public.dashboard');
    })->name('public.dashboard'); 
    
    // Mengakses Data Anggota DPR (Read Only)
    Route::get('/members', [PublicAnggotaController::class, 'index'])->name('public.anggota.index');
    
    // Mengakses Data Penggajian (Read Only)
    Route::get('/payrolls', [PublicPayrollController::class, 'index'])->name('public.payrolls.index');
    Route::get('/payrolls/{id_anggota}', [PublicPayrollController::class, 'show'])->name('public.payrolls.show');
});


// Admin Routes 
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        \Log::info('Admin dashboard accessed', [
            'user' => auth()->user()->email,
            'role' => auth()->user()->role
        ]);
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::resource('anggota', AnggotaDPRController::class);
    Route::resource('salary-components', SalaryComponentController::class);
    Route::resource('payrolls', PayrollController::class)->only(['index', 'create', 'store']);
    Route::get('/payrolls/{id_anggota}', [PayrollController::class, 'show'])->name('payrolls.show');
    Route::get('/payrolls/{id_anggota}/edit', [PayrollController::class, 'edit'])->name('payrolls.edit');
    Route::put('/payrolls/{id_anggota}', [PayrollController::class, 'update'])->name('payrolls.update');
    Route::delete('/payrolls/{id_anggota}', [PayrollController::class, 'destroy'])->name('payrolls.destroy');
});