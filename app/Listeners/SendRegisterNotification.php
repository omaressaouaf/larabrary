<?php

namespace App\Listeners;

use App\Notifications\RegisterNotification;
use App\Notifications\UserRegistered;
use App\Role;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendRegisterNotification
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
    public function handle($event)
    {
        $admins = Role::where('name', 'admin')->first()->users;
        Notification::send($admins, new RegisterNotification($event->user));
    }
}
