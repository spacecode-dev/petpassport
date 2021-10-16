<?php

namespace App\PetPassport\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $channel;

    public $object_id;

    public $object_type;

    public $user;

    /**
     * LikeCreated constructor.
     * @param $channel
     * @param $object_id
     * @param $object_type
     * @param $user
     */
    public function __construct($channel, $object_id, $object_type, $user)
    {
        $this->channel = $channel;
        $this->object_id = $object_id;
        $this->object_type = $object_type;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'like.created';
    }

    /**
     * @return Channel|Channel[]|PrivateChannel
     */
    public function broadcastOn()
    {
        if (strpos($this->channel, 'private-') === 0) {
            return new PrivateChannel(str_replace('private-', '', $this->channel));
        }
        return new Channel($this->channel);
    }
}
