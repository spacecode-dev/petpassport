<?php

namespace App\PetPassport\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendshipAccepted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user_id;

    public $user;

    /**
     * FriendshipAccepted constructor.
     * @param $user_id
     * @param $user
     */
    public function __construct($user_id, $user)
    {
        $this->user_id = $user_id;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'friendship.accepted';
    }

    /**
     * @return Channel|Channel[]|PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user_id);
    }
}
