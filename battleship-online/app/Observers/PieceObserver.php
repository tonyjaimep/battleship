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
        $boardA = Board::where('match_id', $match->id)->where('user_id', $match->user_a_id)->first();
        $boardB = Board::where('match_id', $match->id)->where('user_id', $match->user_b_id)->first();

        // all pieces have been placed
        if (count($boardA->pieces) >= 4 && count($boardB->pieces) >= 4) {
            if ($match->state = "attacking")
            $match->save();
        }
    }
}
