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

    public $article;
    public array $messages;
    public array $newContributors;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($article, $messages, $newContributors = null)
    {
        $this->article = $article;
        $this->messages = $messages;
        $this->newContributors = $newContributors;
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
