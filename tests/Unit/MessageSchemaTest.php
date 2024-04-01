<?php

namespace Tests\Unit;

use App\Http\Common\Tools\ObjectMerger;
use App\Http\Schemas\MessageSchema;
use PHPUnit\Framework\TestCase;


class MessageSchemaTest extends TestCase
{
    public function test_message_schema()
    {
        $message_mock = [
            "update_id" => 64425990,
            "message" => [
                "message_id" => 102,
                "from" => [
                    "id" => 1781663510,
                    "is_bot" => false,
                    "first_name" => "Magic",
                    "last_name" => "Mode",
                    "username" => "MagicModeMe",
                    "language_code" => "en"
                ],
                "chat" => [
                    "id" => 1781663510,
                    "first_name" => "Magic",
                    "last_name" => "Mode",
                    "username" => "MagicModeMe",
                    "type" => "private"
                ],
                "date" => 1711983191,
                "text" => "test"
            ]
        ];

        $contextSchema = new MessageSchema();

        $objectMerger = new ObjectMerger($contextSchema->get());

        $input = $objectMerger->merge($message_mock);

        $this->assertEquals($input,  [
            "tele_message_id" => 102,
            "tele_chat_id" => 1781663510,
            "message" => "test",
            "sender" => "MagicModeMe"
        ]);
    }
}
