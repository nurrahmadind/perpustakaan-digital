<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\User\KatalogController;
use App\Models\Buku;

// Halaman utama
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

// Dashboard Admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', function () {
        if(auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $bukus = Buku::all();
        $peminjamans = \App\Models\Peminjaman::with(['user', 'buku'])->latest()->get();
        $riwayat = $peminjamans;

        return view('admin.dashboard', compact('bukus', 'peminjamans', 'riwayat'));
    })->name('admin.dashboard');

    // Route resource admin
    Route::resource('/admin/buku', BukuController::class, ['as' => 'admin']);
    Route::resource('/admin/user', UserController::class, ['as' => 'admin']);
    Route::resource('/admin/peminjaman', PeminjamanController::class, ['as' => 'admin']);
    Route::patch('/admin/peminjaman/{peminjaman}/kembali', [PeminjamanController::class, 'updateStatus'])->name('admin.peminjaman.kembali');

    // Route Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard / Katalog Buku untuk Siswa (User)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [KatalogController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/pinjam', [KatalogController::class, 'store'])->name('user.pinjam');
    Route::patch('/dashboard/kembali/{peminjaman}', [KatalogController::class, 'updateStatus'])->name('user.kembali');
});

require __DIR__.'/auth.php';