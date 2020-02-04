<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Piece;

class Board extends Model
{
    public function isHit($x, $y)
    {
        foreach ($this->pieces as $piece)
            if ($piece->hit($x, $y))
                return true;

        return false;
    }

    public function pieces()
    {
        return $this->hasMany(Piece::class);
    }
}
