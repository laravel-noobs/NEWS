<?php

namespace App\Listeners;

use App\AppMailers\AppMailerFacade as AppMailer;
use App\Events\UserWasBanned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserBannedNotification
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
     * @param  UserWasBanned  $event
     * @return void
     */
    public function handle(UserWasBanned $event)
    {
        AppMailer::send_user_banned_notification_to($event->user, $event->staff, $event->reason, $event->message);
    }
}
