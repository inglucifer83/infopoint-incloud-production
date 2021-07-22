<?php

namespace App\Providers;

use App\Events\CreazioneNews;
use App\Events\CreazioneEvento;
use App\Events\CreazioneLuoghi;
use App\Events\CreazioneStrutture;
use Illuminate\Support\Facades\Event;
use App\Listeners\CreaRecordAddEcento;
use App\Listeners\CreaRecordAddNews;
use App\Listeners\CreaRecordAddStrutture;
use App\Listeners\CreaRecordAddLuoghi;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreazioneEvento::class => [
            CreaRecordAddEcento::class,
        ],
        CreazioneNews::class => [
            CreaRecordAddNews::class,
        ],
        CreazioneStrutture::class => [
            CreaRecordAddStrutture::class,
        ],
        CreazioneLuoghi::class => [
            CreaRecordAddLuoghi::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
