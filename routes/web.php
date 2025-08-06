<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataInventarisMasterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inventaris-master/{inv_rekening}', [DataInventarisMasterController::class, 'show'])
    ->name('inventaris-master.show');