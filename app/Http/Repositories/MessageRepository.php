<?php


namespace App\Http\Repositories;

use App\Http\Common\Bases\Repository;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserRepository
 * @package App\Modules\Auth\Repositories
 */
class MessageRepository extends Repository
{
    /**
     * @var array
     */
    protected array $fillable = [
        'sender',
        'message',
        'tele_message_id',
        'tele_chat_id',
        'parent_id'
    ];

    /**
     * @return string
     */
    protected function model(): string
    {
        return Message::class;
    }

    public function getTopLevelMessages(): Collection
    {
        return $this->query()->whereNull('parent_id')->get();
    }
}
