<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Piece;
use App\Match;

class Board extends Model
{
    public $timestamps = false;

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

    public function match()
    {
        return $this->belongsTo(Match::class);
    }
}
