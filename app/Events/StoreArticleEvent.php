<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreArticleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $authorID;
    public int $articleID;
    public array $messages;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($authorID, $articleID, $messages)
    {
        $this->authorID = $authorID;
        $this->articleID = $articleID;
        $this->messages = $messages;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
