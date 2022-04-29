<?php

namespace App\Listeners;

use App\Events\UserSubcribed;
use App\Models\Event;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSubcribe
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
     * @param  object  $event
     * @return void
     */
    public function handle(UserSubcribed $event)
    {
//        throw new Exception('GAGAL');
        Event::create([
            'title' => $event->title
        ]);
    }
}
