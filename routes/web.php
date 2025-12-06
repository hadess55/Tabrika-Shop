<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;

Route::get('/', [LandingController::class, 'index'])->name('shop');
Route::get('/produk', [ProductController::class, 'index'])->name('product.page');
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('product.show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('barang', BarangController::class);
    Route::patch('barang/{barang}/jumlah', [BarangController::class, 'updateJumlah'])
        ->name('barang.updateJumlah');

});

require __DIR__.'/auth.php';
