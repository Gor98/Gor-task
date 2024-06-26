<?php

namespace App\Http\Services;

use App\Http\Common\Bases\Service;
use App\Http\Common\Tools\ObjectMerger;
use App\Http\Requests\ReplyRequest;
use App\Http\Schemas\MessageSchema;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;


class TelegramService extends Service
{
    /**
     * @var Api
     */
    private Api $telegram;

    /**
     * MessageService constructor.
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * @return array
     */
    function getMessage(): array
    {
        $newMessage = $this->telegram->getWebhookUpdate();

        return $this->formatMessage($newMessage);
    }

    /**
     * @param $newMessage
     * @return array
     */
    private function formatMessage($newMessage): array
    {
        $schema = new MessageSchema();
        $schema = $schema->get();
        $objectMerger = new ObjectMerger($schema);

        return $objectMerger->merge(reset($newMessage));
    }

    /**
     * @throws TelegramSDKException
     */
    public function sendMessage(ReplyRequest $request)
    {
        $this->telegram->sendMessage([
            'chat_id' => $request->tele_chat_id,
            'text' => $request->message,
        ]);
    }
}