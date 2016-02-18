<?php

namespace App\Policies;

use App\Permission;
use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy extends Policy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        parent::before($user, $ability);
    }

    public function update(User $user, Post $post)
    {
        return $user->owns($post);
    }
}
