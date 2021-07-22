<?php

namespace App\Listeners;

use App\Events\CreazioneEvento;
use App\Models\Inserimenti;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreaRecordAddEcento
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
     * @param  CreazioneEvento  $event
     * @return void
     */
    public function handle(CreazioneEvento $event)
    {

        $inserimenti = new Inserimenti();

        $inserimenti->user_id = $event->user->id;
        $inserimenti->infopoint_id = $event->user->infopoint_id?$event->user->infopoint_id:0;
        $inserimenti->type_insert = 1;
        $inserimenti->dato_id = $event->evento->id;
        $inserimenti->comune_id = $event->user->getUserInfopointId()?$event->user->getUserInfopointId() : 0;


        $inserimenti->save();
    }
}
