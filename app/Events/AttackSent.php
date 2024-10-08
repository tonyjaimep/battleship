<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Attack;

class AttackSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attack;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Attack $attack)
    {
        $this->attack = $attack;
        $gameMatch = $attack->targetBoard->gameMatch;

        // toggle turn
        if ($gameMatch->turn == $gameMatch->user_a_id)
            $gameMatch->turn = $gameMatch->user_b_id;
        else
            $gameMatch->turn = $gameMatch->user_a_id;

        $gameMatch->save();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('board.' . $this->attack->target_board_id);
    }
}
