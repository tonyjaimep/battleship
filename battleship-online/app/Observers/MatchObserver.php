<?php

namespace App\Observers;

use App\Match;

use App\Events\MatchStateUpdated;
use App\Events\MatchWon;

class MatchObserver
{
    public function updated(Match $match)
    {
        if ($match->getOriginal('state') != $match->state) {
            broadcast(new MatchStateUpdated($match));
        }
        if ($match->winner_id && $match->getOriginal('winner_id') == NULL) {
            broadcast(new MatchWon($match));
        }
    }
}
