<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Match;
use App\Board;

class MatchController extends Controller
{
    public function showMatch(Request $request)
    {
        $sessionId = $request->session()->getId();

        if (!$request->session()->has('match_id')) {
            $match = $this->assignMatch($sessionId);
            $request->session()->put('match_id', $match->id);
        } else {
            if (!($match = Match::find($request->session()->get('match_id')))) {
                $match = $this->assignMatch($sessionId);
                $request->session()->put('match_id', $match->id);
            }
        }


        if ($match->boardA->user_id == $sessionId) {
            $ownBoard = $match->boardA;
            $enemyBoard = $match->boardB;
        } else {
            $ownBoard = $match->boardB;
            $enemyBoard = $match->boardA;
        }

        return view('match', [
            'match_id' => $match->id,
            'own_board' => $ownBoard,
            'enemy_board' => $enemyBoard
        ]);
    }

    public function getState($matchId)
    {
        return Match::findOrFail($matchId)->state;
    }

    private function assignMatch($userId)
    {
        $availableMatches = Match::available();

        if ($availableMatches->count()) {
            $match = $availableMatches->first();
            $match->user_b_id = $userId; // dummy
            $match->save();
        } else {
            $match = new Match();
            $match->state = 'waiting-opponent';
            $match->user_a_id = $userId;
            $match->save();

            // board setup
            // board A
            $boardA = new Board();
            $boardA->user_id = $userId;
            $boardA->match_id = $match->id;
            $boardA->save();
            // board B
            $boardB = new Board();
            $boardB->match_id = $match->id;
            $boardB->save();
        }

        return $match;
    }
}
