<?php

namespace App\Policies;

use App\Permission;
use App\Post;
use App\PostStatus;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy extends Policy
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
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function updateOwnPost(User $user, Post $post)
    {
        return $user->owns($post);
    }

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function trashOwnPost(User $user, Post $post)
    {
        return $user->owns($post);
    }

    /**
     * @param User $user
     * @param Post $post
     * @param null $status
     * @return bool
     */
    public function storeDraftPost(User $user, Post $post, $status = null)
    {
        if($status == null)
            return true;

        if(is_object($status))
            return $status->id == PostStatus::getStatusIdByName('draft');

        return $status == PostStatus::getStatusIdByName('draft');
    }

    /**
     * @param User $user
     * @param Post $post
     * @param null $status
     * @return bool
     */
    public function storePendingPost(User $user, Post $post, $status = null)
    {
        if($status == null)
            return true;

        if(is_object($status))
            return $status->id == PostStatus::getStatusIdByName('pending');

        return $status == PostStatus::getStatusIdByName('pending');
    }

    /**
     * @param User $user
     * @param Post $post
     * @param null $status
     * @return bool
     */
    public function storeApprovedPost(User $user, Post $post, $status = null)
    {
        if($status == null)
            return true;

        if(is_object($status))
            return $status->id == PostStatus::getStatusIdByName('approved');

        return $status == PostStatus::getStatusIdByName('approved');
    }


    /**
     * @param User $user
     * @param Post $post
     * @param null $status
     * @return bool
     */
    public function storeTrashPost(User $user, Post $post, $status = null)
    {
        if($status == null)
            return true;

        if(is_object($status))
            return $status->id == PostStatus::getStatusIdByName('trash');

        return $status == PostStatus::getStatusIdByName('trash');
    }

    /**
     * @param User $user
     * @param Post $post
     * @return mixed
     */
    public function approveDraftPost(User $user, Post $post)
    {
        return  $post->status_id == PostStatus::getStatusIdByName('draft');
    }

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function approveOwnDraftPost(User $user, Post $post)
    {
        return $user->owns($post) && $post->status_id == PostStatus::getStatusIdByName('draft');
    }

    /**
     * @param User $user
     * @param Post $post
     * @return mixed
     */
    public function approvePendingPost(User $user, Post $post)
    {
        return $post->status_id == PostStatus::getStatusIdByName('pending');
    }


    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function approveOwnPendingPost(User $user, Post $post)
    {
        return $user->owns($post) && $post->status_id == PostStatus::getStatusIdByName('pending');
    }

    /**
     * @param User $user
     * @param Post $post
     * @return mixed
     */
    public function approveCollaboratorPost(User $user, Post $post)
    {
        return $post->user->role_id == Role::getRoleIdByName('collaborator');
    }


    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function approveCollaboratorDraftPost(User $user, Post $post)
    {
        return $post->user->role_id == Role::getRoleIdByName('collaborator') && $post->status_id == PostStatus::getStatusIdByName('draft');
    }

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function approveCollaboratorPendingPost(User $user, Post $post)
    {
        return $post->user->role_id == Role::getRoleIdByName('collaborator') && $post->status_id == PostStatus::getStatusIdByName('pending');
    }
}
