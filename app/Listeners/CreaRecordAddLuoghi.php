<?php

namespace App\Listeners;

use App\Models\Inserimenti;
use App\Events\CreazioneLuoghi;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreaRecordAddLuoghi
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
     * @param  CreazioneLuoghi  $event
     * @return void
     */
    public function handle(CreazioneLuoghi $event)
    {
        $inserimenti = new Inserimenti();

        $inserimenti->user_id = $event->user->id;
        $inserimenti->infopoint_id = $event->user->infopoint_id?$event->user->infopoint_id:0;
        $inserimenti->type_insert = 4;
        $inserimenti->dato_id = $event->luoghi->id;
        $inserimenti->comune_id = $event->user->getUserInfopointId()?$event->user->getUserInfopointId() : 0;


        $inserimenti->save();
    }
}
