<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Fakultas;
use App\Models\Labs;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaboranController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TeknisiController;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\PerkerasController;
use App\Http\Controllers\PerlunakController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return redirect('/');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/get-fakultas', function () {
    return response()->json(Fakultas::all());
});

Route::get('/get-labs/{fakultas_id}', function ($fakultas_id) {
    return response()->json(Labs::where('fakultas_id', $fakultas_id)->get());
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
    Route::get('fakultas', [FakultasController::class, 'index'])->name('fakultas.index');
    Route::post('fakultas', [FakultasController::class, 'store'])->name('fakultas.store');
    Route::delete('fakultas/{fakultas}', [FakultasController::class, 'destroy'])->name('fakultas.destroy');
    
    Route::get('users', [UsersController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        request()->validate(['role' => 'required|string']);
        $user->update(['role' => request('role')]);
        return response()->json(['success' => true]);
    })->name('users.update'); 
    Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::get('labs', [LabController::class, 'index'])->name('labs.index');
    Route::post('labs', [LabController::class, 'store'])->name('labs.store');
    Route::delete('labs/{lab}', [LabController::class, 'destroy'])->name('labs.destroy');

    Route::get('lunak',[PerlunakController::class,'index'])->name('perlunak.index');
    Route::post('lunak',[PerlunakController::class,'store'])->name('perlunak.store');
    Route::delete('lunak/{perlunak}',[PerlunakController::class,'destroy'])->name('perlunak.destroy');

    Route::get('keras',[PerkerasController::class,'index'])->name('perkeras.index');
    Route::post('keras',[PerkerasController::class,'store'])->name('perkeras.store');
    Route::delete('keras/{perkeras}',[PerkerasController::class,'destroy'])->name('perkeras.destroy');

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

});

Route::middleware(['auth', 'teknisi'])->group(function () {
    Route::get('/teknisi',[TeknisiController::class,'index'])->name('teknisi.index');
});

Route::middleware(['auth', 'laboran'])->group(function () {
    Route::get('/laboran',[LaboranController::class,'index'])->name('laboran.index');
});

Route::middleware(['auth', 'pengguna'])->group(function () {
    Route::get('/pengguna',[PenggunaController::class,'index'])->name('pengguna.index');
});

require __DIR__.'/auth.php';

