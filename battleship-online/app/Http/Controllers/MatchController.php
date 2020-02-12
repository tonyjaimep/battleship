<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Match;
use App\Board;

class MatchController extends Controller
{
    public function showMatch(Request $request)
    {
        if (!$request->session()->has('match_id')) {
            // TODO: obtener de la sesión
            $match = $this->assignMatch(1);
            $request->session()->put('match_id', $match->id);
        } else {
            if (!Match::find($request->session()->get('match_id'))) {
                // TODO: obtener de la sesión
                $match = $this->assignMatch(1);
                $request->session()->put('match_id', $match->id);
            }
        }

        $matchId = $request->session()->get('match_id');
        return view('match', [
            'match_id' => $matchId,
            // TODO: obtener de la sesión
            'own_board' => Board::where('match_id', $matchId)->where('user_id', 1)->first(),
            // TODO: obtener de la sesión
            'enemy_board' => Board::where('match_id', $matchId)->where('user_id', 1)->first(),
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
