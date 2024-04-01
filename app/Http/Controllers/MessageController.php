<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Services\MessageService;
use App\Http\Services\TelegramService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Telegram\Bot\Exceptions\TelegramSDKException;

class MessageController extends Controller
{
    /**
     * @var MessageService
     */
    protected MessageService $messageService;

    /**
     * @var TelegramService
     */
    protected TelegramService $telegramService;

    /**
     * Create a new controller instance.
     *
     * @param MessageService $messageService
     * @param TelegramService $telegramService
     */
    public function __construct(MessageService $messageService, TelegramService $telegramService)
    {
        $this->messageService = $messageService;
        $this->telegramService = $telegramService;
    }

    /**
     * Show the bot information.
     */
    public function show()
    {
        $messages = $this->messageService->all();

        return view('messages', ['messages' => $messages]);
    }

    /**
     * show messages
     */
    public function save(): void
    {
        $message = $this->telegramService->getMessage();
        $this->messageService->save($message);
    }

    /**
     * @param ReplyRequest $request
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     * @throws TelegramSDKException
     */
    public function reply(ReplyRequest $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        $this->messageService->save(array_merge($request->all(), ['sender' => env('APP_NAME')]));
        $this->telegramService->sendMessage($request);

        return redirect('/');
    }
}
