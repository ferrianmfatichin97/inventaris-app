<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DataInventarisMasterController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); 
})->name('logout');

Route::get('/inventaris-master/{inv_rekening}', [DataInventarisMasterController::class, 'show'])
    ->name('inventaris-master.show');

    Route::get('/export-data-inventaris', [App\Http\Controllers\DataInventarisMasterController::class, 'export'])
    ->name('inventaris.export');