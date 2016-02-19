<?php

namespace App\Policies;

use App\Permission;
use App\Post;
use App\PostStatus;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy extends Policy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return parent::before($user, $ability);
    }

    public function updateOwn(User $user, Post $post)
    {
        return $user->owns($post);
    }
    public function trashOwn(User $user, Post $post)
    {
        return $user->owns($post);
    }

    public function storeDraft(User $user, Post $post, $status = null)
    {
        if($status == null)
            return true;

        if(is_object($status))
            return $status->id == PostStatus::getStatusIdByName('draft');

        return $status == PostStatus::getStatusIdByName('draft');
    }

    public function storePending(User $user, Post $post, $status = null)
    {
        if($status == null)
            return true;

        if(is_object($status))
            return $status->id == PostStatus::getStatusIdByName('pending');

        return $status == PostStatus::getStatusIdByName('pending');
    }

    public function storeApproved(User $user, Post $post, $status = null)
    {
        if($status == null)
            return true;

        if(is_object($status))
            return $status->id == PostStatus::getStatusIdByName('approved');

        return $status == PostStatus::getStatusIdByName('approved');
    }


    public function storeTrash(User $user, Post $post, $status = null)
    {
        if($status == null)
            return true;

        if(is_object($status))
            return $status->id == PostStatus::getStatusIdByName('trash');

        return $status == PostStatus::getStatusIdByName('trash');
    }
}
