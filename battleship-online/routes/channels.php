<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('match.{match_id}', function ($user, $matchId) {
    $match = Match::findOrFail($matchId);
    return $user->id === $match->user_a_id || $user->id === $match->user_b_id;
});
