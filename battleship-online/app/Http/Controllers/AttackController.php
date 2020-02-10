<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attack;

class AttackController extends Controller
{
    public function create(Request $request)
    {
        $attack = new Attack();
        $attack->user = session()->get('user');
        $attack->target_x = $request->target_x;
        $attack->target_y = $request->target_y;
        $attack->target_board_id = $request->target_board_id;
        $attack->save();
    }
}
