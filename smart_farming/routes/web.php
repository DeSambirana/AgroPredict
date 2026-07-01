<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CropPredictionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Crop Prediction Routes
    Route::get('/rekomendasi', [CropPredictionController::class, 'index'])->name('crop.form');
    Route::post('/prediksi', [CropPredictionController::class, 'predict'])->name('crop.predict');
    
    Route::get('/riwayat', [CropPredictionController::class, 'history'])->name('crop.history');
    Route::get('/riwayat/{id}/edit', [CropPredictionController::class, 'edit'])->name('crop.edit');
    Route::put('/riwayat/{id}', [CropPredictionController::class, 'update'])->name('crop.update');
    Route::delete('/riwayat/{id}', [CropPredictionController::class, 'destroy'])->name('crop.destroy');
    
    Route::get('/dashboard', [CropPredictionController::class, 'dashboard'])->name('dashboard');
    Route::post('/prediksi/simpan', [CropPredictionController::class, 'store'])->name('crop.store');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
