<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Match extends Model
{
    public $timestamps = false;

    public function userA()
    {
        return $this->belongsTo(User::class);
    }

    public function userB()
    {
        return $this->belongsTo(User::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAvailable($query)
    {
        return $query->whereNull('user_b_id');
    }

    public function setUserBIdAttribute($value)
    {
        $board = Board::where('match_id', $this->id)->whereNull('user_id');
        $board->user_id = $value;
        $board->save();

        $this->attributes['user_b_id'] = $value;
    }
}
