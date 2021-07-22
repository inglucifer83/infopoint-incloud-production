<?php

namespace App\Events;

use App\Models\Eventi;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreazioneEvento
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $evento;
    public $user;

    /**
     * @var $evento
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Eventi $evento, User $user)
    {
        $this->evento = $evento;
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
