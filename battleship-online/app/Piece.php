<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Board;
use App\Attack;

class Piece extends Model
{
    public $timestamps = false;

    protected $appends = ['position'];
    protected $hidden = ['x', 'y'];

    protected $casts = [
        'length' => 'integer',
        'x' => 'integer',
        'y' => 'integer',
    ];

    public function hit($x, $y)
    {
        // horizontal
        if ($this->orientation === 'h'
            // ship and attack are in the same row
            && $this->y == $y
            // attack is in the range of the length of this ship
            && ($this->x <= $x && $x < $this->x + $this->length)) {
            $this->checkHealth();
            return true;
        // vertical
        } else if ($this->orientation === 'v'
            // attack and ship are in the same column
            && $this->x == $x
            // attack is in the range of the length of this ship
            && ($this->y <= $y && $y < $this->y + $this->length)) {
            $this->checkHealth();
            return true;
        }
        return false;
    }

    public function getPositionAttribute()
    {
        return ['x' => $this->x, 'y' => $this->y];
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function attacks()
    {
        return $this->hasMany(Attack::class, 'hit_piece_id');
    }

    public function checkHealth()
    {
        if ($this->length <= $this->attacks->count())
            $this->delete();
    }
}
