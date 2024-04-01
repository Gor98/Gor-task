<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MessageController::class, 'show'])->name('messages');
Route::post('/webhook', [MessageController::class, 'save']);
Route::post('/reply', [MessageController::class, 'reply'])->name('reply');
