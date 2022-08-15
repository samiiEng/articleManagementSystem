<?php

namespace App\Subscribers;

use App\Events\StoreArticleEvent;
use App\Listeners\SendContributorInvitationMessage;

class ArticleSubscriber
{
    public function __construct()
    {
    }

    public function subscribe($events)
    {
        $events->listen(
            StoreArticleEvent::class,
            [SendContributorInvitationMessage::class, 'handle']
        );
    }
}
