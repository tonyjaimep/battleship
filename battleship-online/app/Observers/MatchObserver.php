<?php

namespace App\Observers;

use App\Match;

use App\Events\MatchStateUpdated;

class MatchObserver
{
    public function updated(Match $match)
    {
        if ($match->getOriginal('state') != $match->state) {
            broadcast(new MatchStateUpdated($match));
        }
    }
}
