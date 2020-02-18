<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Piece;

class PieceDestroyed implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $piece;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Piece $piece)
    {
        $this->piece = $piece;
        $board = $this->piece->board;
        $match = $board->match;

        // set winner
        if ($board->pieces->count() == 0) {
            if ($board->id == $match->board_a_id)
                $match->winner_id = $match->boardB->user_id;
            else
                $match->winner_id = $match->boardA->user_id;
            $match->save();
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('match.' . $piece->board->match->id);
    }
}
