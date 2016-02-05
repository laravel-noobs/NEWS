<?php

namespace App\Events;

use App\Events\Event;
use App\Feedback;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FeedbackChecked extends Event
{
    use SerializesModels;
    public $feedback;
    public $sender;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Feedback $feedback, User $sender, $message)
    {
        $this->feedback = $feedback;
        $this->sender = $sender;
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
