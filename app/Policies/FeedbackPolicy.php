<?php

namespace App\Policies;

use App\Feedback;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedbackPolicy extends Policy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        return parent::before($user, $ability);
    }
}
