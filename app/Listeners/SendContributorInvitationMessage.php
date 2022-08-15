<?php

namespace App\Listeners;

use App\Events\StoreArticleEvent;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SendContributorInvitationMessage
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
    public function handle(StoreArticleEvent $event)
    {
        $messages = $event->message;
        $from = $event->author;
        $acceptLink = URL::signedRoute('invitationLink', ['accept']);
        $rejectLink = URL::signedRoute('invitationLink', ['reject']);
        $now = Carbon::now();
        $defaultMessage = DB::select("SELECT * FROM default_messages WHERE type = 'invitation_message'");
        foreach ($messages as $message) {
            $to = $message['contributorID'];
            $title = !empty($message['title']) ? $message['title'] : $defaultMessage[0]->title;
            $body = !empty($message['body']) ? $message['body'] : $defaultMessage[0]->body;
            $body .= "Accept : " . $acceptLink . "<br>Reject: " . $rejectLink . "<br>";

            DB::insert("INSERT INTO messages (title, body, from_ref_id, to_ref_id, status, created_at)
                 VALUES($title, $body, $from, $to, 'waiting', $now)");
        }

    }
}
