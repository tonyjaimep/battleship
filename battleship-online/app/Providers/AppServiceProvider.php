<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Match;
use App\Observers\MatchObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Match::observe(MatchObserver::class);
    }
}
