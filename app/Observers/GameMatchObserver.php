<?php

namespace App\Observers;

use App\GameMatch;

use App\Events\GameMatchStateUpdated;
use App\Events\GameMatchWon;
use App\Events\GameMatchTurn;

class GameMatchObserver
{
    public function updated(GameMatch $gameMatch)
    {
        \Log::debug("Game match updated");
        if ($gameMatch->getOriginal('state') != $gameMatch->state) {
            \Log::debug("state updated: " . $gameMatch->state . "->" . $gameMatch->getOriginal('state'));
            broadcast(new GameMatchStateUpdated($gameMatch));
        }

        if ($gameMatch->getOriginal('turn') != $gameMatch->turn) {
            \Log::debug("turn: " . $gameMatch->turn);
            broadcast(new GameMatchTurn($gameMatch));
        }

        if ($gameMatch->winner_id && $gameMatch->getOriginal('winner_id') == NULL) {
            \Log::debug("winner!");
            broadcast(new GameMatchWon($gameMatch));
        }
    }
}
