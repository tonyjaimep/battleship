<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Board;

class BoardController extends Controller
{
    public function getPieces($board_id)
    {
        return Board::findOrFail($board_id)->pieces;
    }
}
