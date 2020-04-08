<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Session;

class UserEventSubscriber
{
    /**
     * Sets user account type on login
     */
    public function onUserLogin($event)
    {
        if (!Session::has('userType')) {
            $userType = $event->user->getUserTypes();
            Session::put('userType', array_shift($userType));
        }
    }

    /**
     * Subscribe to events for user object
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );
    }
}
