<?php

namespace App\Listeners;

use App\AppMailers\AppMailerFacade;
use App\Events\FeedbackChecked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\AppMailers\AppMailerFacade as AppMailer;

class FeedbackCheckedNotification
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
     * @param  FeedbackChecked  $event
     * @return void
     */
    public function handle(FeedbackChecked $event)
    {
        AppMailer::send_feedback_notification_to($event->feedback, $event->sender, $event->message);
    }
}
