<?php

namespace App\Providers;

use App\Support\GravatarDecorator;
use Illuminate\Support\ServiceProvider;

class GravatarServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gravatar',function(){
            return app(GravatarDecorator::class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
