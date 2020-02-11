<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Piece;

class PieceController extends Controller
{
    public function place(Request $request)
    {
        $ship = new Piece();
        $ship->board_id = $request->board_id;
        $ship->x = $request->x;
        $ship->y = $request->y;
        $ship->orientation = $request->orientation;
        $ship->type = 'x';

        $ship->save();

        return response()->json($ship);
    }
}
