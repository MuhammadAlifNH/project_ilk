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
    Route::resource('profile', ProfileController::class);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
    
    Route::resource('fakultas', FakultasController::class);

    Route::resource('users', UsersController::class);
    Route::put('/users/{id}', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        request()->validate(['role' => 'required|string']);
        $user->update(['role' => request('role')]);
        return response()->json(['success' => true]);
    })->name('users.update'); 
    
    Route::resource('lab', LabController::class);

    Route::resource('perlunak', PerlunakController::class);

    Route::resource('perkeras', PerkerasController::class);

    Route::resource('jadwal', JadwalController::class);

    Route::resource('inventaris', 'InventarisController');

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

