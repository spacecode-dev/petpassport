<?php

namespace App\PetPassport\Observers;

use App\PetPassport\Models\User\UserConversation;
use App\PetPassport\Models\Message;
use App\PetPassport\Events\MessageCreated;

class MessageObserver
{
    /**
     * @param Message $message
     */
    public function created(Message $message)
    {
        if ($message->recipient_type == 'profile') {
            UserConversation::firstOrCreate([
                'user_id' => $message->recipient_id,
                'recipient_id' => $message->sender_id,
                'recipient_type' => $message->sender_type
            ]);
        }
        $message->load('sender');
        broadcast(new MessageCreated($message))->toOthers();
    }
}
