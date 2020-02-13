<?php

namespace App\Observers;

use App\Piece;
use App\Board;
use App\Match;

class PieceObserver
{
    public function created(Piece $piece)
    {
        $match = $piece->board->match;

        $boardA = $match->boardA;
        $boardB = $match->boardB;


        // all pieces have been placed
        if ($boardA->pieces->count() >= 5 && $boardB->pieces->count() >= 5) {
            $match->state = "attacking";
            $match->save();
        }
    }
}
