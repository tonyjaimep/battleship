<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Board;

class Attack extends Model
{
    public $timestamps = false;

    public function targetBoard()
    {
        return $this->belongsTo(Board::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function targetUser()
    {
        return $this->targetBoard->user;
    }

    public function setXAttribute($value)
    {
        $this->attributes['x'] = $value;
        if (isset($this->y))
            $this->calculateIsHit();
    }

    public function setYAttribute($value)
    {
        $this->attributes['y'] = $value;
        if (isset($this->x))
            $this->calculateIsHit();
    }

    private function calculateIsHit()
    {
        return $this->attributes['hit'] = $this->targetBoard->isHit($this->x, $this->y);
    }
}
