<?php

namespace App\Listeners;

use App\Events\UserUnsetAsAdmin;
use App\Notifications\DemoteMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDemoteMail implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  UserUnsetAsAdmin  $event
     * @return void
     */
    public function handle(UserUnsetAsAdmin $event)
    {
        $event->user->notify(new DemoteMail);
    }
}
