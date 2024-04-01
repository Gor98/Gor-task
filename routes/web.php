<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;


Route::get('/', [MessageController::class, 'show'])->name('messages');
Route::post('/webhook', [MessageController::class, 'save']);
Route::post('/reply', [MessageController::class, 'reply'])->name('reply');

Route::get('/set-webhook', function () {

    // TODO set webhook on service provider or some other location
    // Get ngrok URL from environment variable or configuration
//    $response = Telegram::removeWebhook();

    // Set the webhook URL using the ngrok URL
    $response = Telegram::setWebhook(['url' => env('NGROK_URL').'/webhook']);

    dd(
            Telegram::getMe()
    );

});
