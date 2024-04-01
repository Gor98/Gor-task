<?php

namespace Tests\Feature;

 use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Services\TelegramService;
 use Illuminate\Foundation\Testing\WithoutMiddleware;
 use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_get_messages_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_reply_messages_response(): void
    {
        $mock = Mockery::mock(TelegramService::class)->makePartial();
        $mock->shouldReceive('sendMessage')->andReturn(true);
        $this->app->bind(TelegramService::class, function () use ($mock) {
            return $mock;
        });
        $id = DB::table('messages')->insertGetId([
            'sender' => 'test',
            'message' => fake()->text,
            'tele_chat_id' => 10,
        ]);

        $response = $this->post('/reply', [
            'parent_id' => $id,
            'tele_chat_id' => 10,
            'message' => fake()->text,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('messages', [
            'parent_id' => $id
        ]);
    }
}
