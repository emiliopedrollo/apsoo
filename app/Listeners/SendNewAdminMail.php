<?php

namespace App\Listeners;

use App\Events\UserSetAsAdmin;
use App\Notifications\NewAdminMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewAdminMail implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

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
     * @param  UserSetAsAdmin  $event
     * @return void
     */
    public function handle(UserSetAsAdmin $event)
    {
        $event->user->notify(new NewAdminMail);
    }
}
