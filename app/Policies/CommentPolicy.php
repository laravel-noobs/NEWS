<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy extends Policy
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

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function approveOwnedPostComment(User $user, Comment $comment)
    {
        return $comment->post->user_id == $user->id;
    }

    public function trashOwnedPostComment(User $user, Comment $comment)
    {
        return $comment->post->user_id == $user->id;
    }

}
