<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public $timestamps = false;
    protected $hidden = ['user_a_id', 'user_b_id'];

    public function scopeAvailable($query)
    {
        return $query->whereNull('user_b_id');
    }

    public function setUserBIdAttribute($value)
    {
        $board = Board::where('match_id', $this->attributes['id'])->whereNull('user_id')->first();
        $board->user_id = $value;
        $board->save();

        $this->attributes['user_b_id'] = $value;

        if ($this->attributes['state'] === 'waiting-opponent')
            $this->attributes['state'] = 'placing';
    }
}
