<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\GameMatch;
use App\Board;

class GameMatchController extends Controller
{
    public function showGameMatch(Request $request)
    {
        $sessionId = $request->session()->getId();

        if (!$request->session()->has('game_match_id')) {
            $gameMatch = $this->assignGameMatch($sessionId);
            $request->session()->put('game_match_id', $gameMatch->id);
        } else {
            // si no encuentra el match o uno sin ganar
            if (!($gameMatch = GameMatch::find($request->session()->get('game_match_id'))) || $gameMatch->winner_id) {
                $gameMatch = $this->assignGameMatch($sessionId);
                $request->session()->put('game_match_id', $gameMatch->id);
            }
        }


        if ($gameMatch->boardA->user_id == $sessionId) {
            $ownBoard = $gameMatch->boardA;
            $enemyBoard = $gameMatch->boardB;
        } else {
            $ownBoard = $gameMatch->boardB;
            $enemyBoard = $gameMatch->boardA;
        }

        return view('game-match', [
            'user_id' => $sessionId,
            'game_match_id' => $gameMatch->id,
            'own_board' => $ownBoard,
            'enemy_board' => $enemyBoard
        ]);
    }

    public function getState($gameMatchId)
    {
        return GameMatch::findOrFail($gameMatchId)->state;
    }

    public function getWinner($gameMatchId)
    {
        return GameMatch::findOrFail($gameMatchId)->winner_id;
    }

    private function assignGameMatch($userId)
    {
        $availableGameMatches = GameMatch::available();

        if ($availableGameMatches->count()) {
            $gameMatch = $availableGameMatches->first();
            $gameMatch->user_b_id = $userId; // dummy
            $gameMatch->save();
        } else {
            $gameMatch = new GameMatch();
            $gameMatch->state = 'waiting-opponent';
            $gameMatch->user_a_id = $userId;
            $gameMatch->save();

            // board setup
            // board A
            $boardA = new Board();
            $boardA->user_id = $userId;
            $boardA->game_match_id = $gameMatch->id;
            $boardA->save();
            // board B
            $boardB = new Board();
            $boardB->game_match_id = $gameMatch->id;
            $boardB->save();
        }

        return $gameMatch;
    }

    public function getTurn($gameMatchId)
    {
        return GameMatch::findOrFail($gameMatchId)->turn;
    }
}
