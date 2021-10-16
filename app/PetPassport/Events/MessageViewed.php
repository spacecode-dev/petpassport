<?php

namespace App\PetPassport\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageViewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * MessageViewed constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
