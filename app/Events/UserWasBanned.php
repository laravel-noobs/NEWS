<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserWasBanned extends Event
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var User
     */
    public $staff;

    /**
     * @var
     */
    public $message;

    /**
     * @var string
     */
    public $reason;


    /**
     * UserWasBanned constructor.
     * @param User $user
     * @param User $staff
     * @param string $reason
     * @param string $message
     */
    public function __construct(User $user, User $staff, $reason, $message)
    {
        $this->user = $user;
        $this->staff = $staff;
        $this->reason = $reason;
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
