<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/dashboard', [BookingController::class, 'store'])->name('bookings.store');

Route::post('/admin/dashboard', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'rolemanager:customer'])->name('dashboard');



Route::get('/admin/dashboard', function () {
    return view('admin');
})->middleware(['auth', 'verified', 'rolemanager:admin'])->name('admin');

Route::post('/admin/dashboard/{id}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
Route::post('/admin/dashboard/{id}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/admin/dashboard', [BookingController::class, 'restoreAvailability'])
    ->middleware(['auth', 'rolemanager:admin'])
    ->name('bookings.restore');

require __DIR__.'/auth.php';
