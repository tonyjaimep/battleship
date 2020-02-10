<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Match extends Model
{
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

    public function create()
    {
    }
}
