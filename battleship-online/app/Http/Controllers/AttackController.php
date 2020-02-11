<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attack;

class AttackController extends Controller
{
    public function create(Request $request)
    {
        $attack = new Attack();
        $attack->user_id = $request->user()->id;
        $attack->target_x = $request->target_x;
        $attack->target_y = $request->target_y;
        if ($request->target_board_id) {
            $attack->target_board_id = $request->target_board_id;
        } else if ($request->match_id) {
            $match = Match::find($request->match_id);
            $attack->target_board_id = $match->boards->where('user_id', '!=', $attack->user_id)->first('id')->id;
        }

        $attack->save();

        return response()->json($attack);
    }
}
