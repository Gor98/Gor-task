<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', function () {

    info('ggg');
    $response = Telegram::bot('mybot')->getMe();


    Telegram::sendMessage([
        'chat_id' => 1781663510,
        'text' => 'sssss',
    ]);
dd($response);
    return view('welcome');
});

Route::get('/get', [MessageController::class, 'show']);
Route::post('/webhook', [MessageController::class, 'save']);

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


Route::post('/', function () {
    info('1111111111111111', ['ss' =>request()->all()]);
//    $response = Telegram::removeWebhook();

    $updates = Telegram::getWebhookUpdate();

    info('--------------', [
        'sss' =>  $updates->getStatus()
    ]);
});