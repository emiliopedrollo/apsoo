<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Events\UserSetAsAdmin;
use App\Events\UserUnsetAsAdmin;
use App\Listeners\SendDemoteMail;
use App\Listeners\SendNewAdminMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserSetAsAdmin::class => [
            SendNewAdminMail::class
        ],
        UserUnsetAsAdmin::class => [
            SendDemoteMail::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
