<?php

namespace App\Policies;

use App\Permission;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy
{
    protected $permission;

    public function before(User $user, $ability)
    {
        $permission = $this->getPermission($ability);

        if(!$user->hasRole($permission->roles))
            return false;
    }

    protected function getPermission($ability)
    {
        if(!$this->permission)
        {
            $this->permission = Permission::with(['roles'])->whereName($ability)->first();
            if(!$this->permission)
                throw new \Exception("permission \"" . $ability . "\" of " . static::class . "  not existed");
        }

        return $this->permission;
    }
}
