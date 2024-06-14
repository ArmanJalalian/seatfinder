<?php

use App\Http\Controllers\ScreenController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ScreenController::class, 'index']);
Route::post('/screen', [ScreenController::class, 'show'])->name('screen.show');
Route::get('/store/screen/{id}', [ScreenController::class, 'store'])->name('screen.store');

require __DIR__.'/auth.php';
