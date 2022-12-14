<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Board;

class Attack extends Model
{
    public $timestamps = false;

    protected $casts = [
        'hit' => 'bool',
        'target_x' => 'integer',
        'target_y' => 'integer',
    ];

    public function targetBoard()
    {
        return $this->belongsTo(Board::class);
    }

    public function setTargetXAttribute($value)
    {
        $this->attributes['target_x'] = $value;
        if (array_key_exists('target_y', $this->attributes))
            $this->calculateIsHit();
    }

    public function setTargetYAttribute($value)
    {
        $this->attributes['target_y'] = $value;
        if (array_key_exists('target_x', $this->attributes))
            $this->calculateIsHit();
    }

    private function calculateIsHit()
    {
        return $this->attributes['hit'] = $this->targetBoard->isHit($this);
    }

    public function piece()
    {
        return $this->belongsTo(Piece::class, 'hit_piece_id');
    }
}
