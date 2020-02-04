<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    public function hit($x, $y)
    {
        // horizontal
        if ($this->orientation === 'h'
            // ship and attack are in the same row
            && $this->y = $y
            // attack is in the range of the length of this ship
            && ($this->x <= $x && $x < $this->x + $this->length)) {
            return true;
        // vertical
        } else if ($this->orientation === 'v'
            // attack and ship are in the same column
            && $this->x = $x
            // attack is in the range of the length of this ship
            && ($this->y <= $y && $y < $this->y + $this->length)) {
            return true;
        }
        return false;
    }
}
