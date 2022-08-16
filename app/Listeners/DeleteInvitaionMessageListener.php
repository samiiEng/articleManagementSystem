<?php

namespace App\Listeners;

use App\Repositories\ArticleRepository;
use App\Repositories\MessageRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DeleteInvitaionMessageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event, MessageRepository $messageRepository, ArticleRepository $articleRepository)
    {
        $i = 0;
        $invitationMessagesIDs = $event->invitationMessagesIDs;
        foreach ($invitationMessagesIDs as $key => $value) {
            $i++;
            if ($key == $event->to) {
                $messageRepository->forceDelete($value);

                //Now delete the contributorID/messageID pair from the articles table
                unset($invitationMessagesIDs[$i]);
                //-------------------------- AT THIS POINT WE NEED A CUSTOMIZED ORM -------------------------
                $articleRepository->update([["invitation_messages_ref_id" => "?"], ["article_id" => "?"], [json_encode($invitationMessagesIDs), $event->articleID]]);

                break;
            }
        }

    }
}
