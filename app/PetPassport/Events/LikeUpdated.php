<?php

namespace App\PetPassport\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $channel;

    public $object_id;

    public $object_type;

    public $count;

    /**
     * LikeUpdated constructor.
     * @param $channel
     * @param $object_id
     * @param $object_type
     * @param $count
     */
    public function __construct($channel, $object_id, $object_type, $count)
    {
        $this->channel = $channel;
        $this->object_id = $object_id;
        $this->object_type = $object_type;
        $this->count = $count;
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'like.updated';
    }

    /**
     * @return Channel|Channel[]
     */
    public function broadcastOn()
    {
        return new Channel($this->channel);
    }
}
