<?php

namespace App\Http\Controllers;

use App\Http\Services\MessageService;
use App\Http\Services\TelegramService;

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
     *
     */
    public function save(): void
    {
        $message = $this->telegramService->getMessage();
        $this->messageService->save($message);
    }
}
