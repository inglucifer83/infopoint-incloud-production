<?php

namespace App\Listeners;

use App\Models\Inserimenti;
use App\Events\CreazioneStrutture;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreaRecordAddStrutture
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreazioneStrutture  $event
     * @return void
     */
    public function handle(CreazioneStrutture $event)
    {
        $inserimenti = new Inserimenti();

        $inserimenti->user_id = $event->user->id;
        $inserimenti->infopoint_id = $event->user->infopoint_id?$event->user->infopoint_id:0;
        $inserimenti->type_insert = 3;
        $inserimenti->dato_id = $event->strutture->id;
        $inserimenti->comune_id = $event->user->getUserInfopointId()?$event->user->getUserInfopointId() : 0;


        $inserimenti->save();
    }
}
