<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attack;

class AttackController extends Controller
{
    public function create(Request $request)
    {
        $attack = new Attack();
        $attack->target_board_id = $request->target_board_id;
        $attack->target_x = $request->x;
        $attack->target_y = $request->y;

        $attack->save();

        return response()->json($attack);
    }
}
