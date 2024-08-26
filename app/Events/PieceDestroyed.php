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
        $gameMatch = $board->gameMatch;

        // set winner
        if ($board->pieces->count() == 0) {
            if ($board->id == $gameMatch->board_a_id)
                $gameMatch->winner_id = $gameMatch->boardB->user_id;
            else
                $gameMatch->winner_id = $gameMatch->boardA->user_id;
            $gameMatch->state = 'finished';
            $gameMatch->save();
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('board.' . $this->piece->board_id);
    }
}
