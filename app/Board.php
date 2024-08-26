<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Piece;
use App\GameMatch;
use App\Attack;

class Board extends Model
{
    public $timestamps = false;

    protected $hidden = ['user_id'];

    public function isHit(Attack $attack)
    {
        foreach ($this->pieces as $piece) {
            if ($piece->hit($attack->target_x, $attack->target_y)) {
                $attack->hit_piece_id = $piece->id;
                $attack->save();
                $piece->checkHealth();
                return true;
            }
        }

        return false;
    }

    public function pieces()
    {
        return $this->hasMany(Piece::class);
    }

    public function gameMatch()
    {
        return $this->belongsTo(GameMatch::class);
    }

    public function attacks()
    {
        return $this->hasMany(Attack::class, 'target_board_id');
    }
}
