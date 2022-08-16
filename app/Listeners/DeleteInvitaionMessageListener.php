<?php

namespace App\Listeners;

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
    public function handle($event)
    {
        foreach ($event->invitationMessagesIDs as $key => $value) {
            if ($key == $event->to){
                DB::delete("DELETE FROM messages WHERE message_id = ?", [$value]);
                return "The invitation message sent to the contributor is successfully deleted!";
            }
        }

    }
}
