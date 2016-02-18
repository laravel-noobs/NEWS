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
    protected $policies = [
        'App\Post' => 'App\Policies\PostPolicy'
    ];

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
            if($permission->model && $permission->policy)
                $this->policies[$permission->model] = $permission->policy;

            else
                $gate->define($permission->name, function($user) use ($permission) {
                   return  $user->hasRole($permission->roles);
                });
        }
    }

    protected function getPermissions()
    {
        return Permission::with(['roles'])->get();
    }
}
