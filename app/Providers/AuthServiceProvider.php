<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        foreach($this->getPermissions() as $permission)
        {
            if($permission->model && $permission->policy && !isset($this->policies[$permission->model]))
                $this->policies[$permission->model] = $permission->policy;
            else
                $gate->define($permission->name, function($user) use ($permission) {
                   return  $user->hasRole($permission->roles);
                });
        }

        $gate->before(function ($user, $ability) {
            if ($user->isAdministrator()) {
                return true;
            }
        });
    }

    protected function getPermissions()
    {
        return Permission::with(['roles'])->get();
    }
}
