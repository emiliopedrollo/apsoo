<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user)
    {
        $nick = Str::snake($user->name);
        $count = 1;
        while(User::where('nick','=', $nick) ->exists()){
            $nick = Str::snake($user->name) . $count++;
        }
        $user->nick = $nick;
    }
}
