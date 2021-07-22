<?php

namespace App\Events;

use App\Models\User;
use App\Models\StruttureRicettive;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreazioneStrutture
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $strutture;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(StruttureRicettive $strutture, User $user)
    {
        $this->strutture = $strutture;
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
