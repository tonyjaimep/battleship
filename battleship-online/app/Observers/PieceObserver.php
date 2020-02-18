<?php

namespace App\Observers;

use App\Piece;
use App\Board;
use App\Match;

use App\Events\PieceDestroyed;

class PieceObserver
{
    public function created(Piece $piece)
    {
        $match = $piece->board->match;

        $boardA = $match->boardA;
        $boardB = $match->boardB;

        // all pieces have been placed
        if ($boardA->pieces->count() >= 4 && $boardB->pieces->count() >= 4) {
            $match->state = "attacking";
            $match->save();
        }
    }

    public function deleted(Piece $piece)
    {
        \Log::debug('Piece ' . $piece->id . 'destroyed');
        broadcast(new PieceDestroyed($piece));
    }
}
