<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\GameMatch;
use App\Observers\GameMatchObserver;

use App\Piece;
use App\Observers\PieceObserver;

use App\Attack;
use App\Observers\AttackObserver;

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
        Attack::observe(AttackObserver::class);
        GameMatch::observe(GameMatchObserver::class);
        Piece::observe(PieceObserver::class);
    }
}
