<?php

namespace App\Events;

use App\Models\User;
use App\Models\LuoghiInteresse;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreazioneLuoghi
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $luoghi;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LuoghiInteresse $luoghi, User $user)
    {
        $this->luoghi = $luoghi;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
