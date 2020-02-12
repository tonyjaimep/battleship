<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Match;

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
        return view('match', ['match_id' => $request->session()->get('match_id')]);
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
            // TODO: obtener esto de la sesión
            $match->user_b_id = $userId; // dummy
        } else {
            $match = new Match();
            // TODO: obtener esto de la sesión
            $match->state = 'waiting-opponent';
            $match->user_a_id = $userId; // este wey es dummy
        }

        $match->save();

        return $match;
    }
}
