<?php

namespace App\Observers;

use App\Piece;
use App\Board;
use App\GameMatch;

use App\Events\PieceDestroyed;

class PieceObserver
{
    public function created(Piece $piece)
    {
        $gameMatch = $piece->board->gameMatch;

        $boardA = $gameMatch->boardA;
        $boardB = $gameMatch->boardB;

        // all pieces have been placed
        if ($boardA->pieces->count() >= 4 && $boardB->pieces->count() >= 4) {
            $gameMatch->state = "attacking";
            $gameMatch->turn = $gameMatch->user_a_id;
            $gameMatch->save();
        }
    }

    public function deleted(Piece $piece)
    {
        broadcast(new PieceDestroyed($piece));
    }
}
