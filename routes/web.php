<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\AttendanceController;

Route::get('/', [AttendanceController::class, 'index'])->name('home.index');
Route::get('/rekap-absensi', [AttendanceController::class, 'indexRekap'])->name('rekap.index');
Route::post('/api/mark-attendance', [AttendanceController::class, 'markAttendance']);
Route::post('/rekap-absensi/filter', [AttendanceController::class, 'filterRekap'])->name('rekap.filter');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
