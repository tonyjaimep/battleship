<?php

namespace App\Observers;

use App\Attack;

class AttackObserver
{
    /**
     * Handle the attack "created" event.
     *
     * @param  \App\Attack  $attack
     * @return void
     */
    public function created(Attack $attack)
    {
        broadcast(new AttackSent($attack));
    }
}
