<?php

namespace App\Http\Services;

use App\Http\Common\Bases\Service;
use App\Http\Repositories\MessageRepository;
use Illuminate\Support\Collection;

class MessageService extends Service
{
    /**
     * @var MessageRepository
     */
    private MessageRepository $messageRepository;

    /**
     * MessageService constructor.
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param $messages
     * @return Collection
     */
    function eagerLoadNestedMessages($messages): Collection
    {
        $messages->load('replies');

        $nestedMessages = collect();

        foreach ($messages as $message) {
            $nestedReplies = $message->replies;

            // Clear replies for the current message
            $message->unsetRelation('replies');

            if ($nestedReplies->isNotEmpty()) {
                // Recursively load nested messages for replies
                $message->replies = $this->eagerLoadNestedMessages($nestedReplies);
            }

            $nestedMessages->push($message);
        }

        return $nestedMessages;
    }


    /**
     * @return Collection
     */
    public function all()
    {
        $topLevelMessages = $this->messageRepository->getTopLevelMessages();

        return $this->eagerLoadNestedMessages($topLevelMessages);
    }

    public function save($message)
    {
        return $this->messageRepository->create($message);
    }
}