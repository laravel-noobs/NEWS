<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Post' => 'App\Policies\PostPolicy',
        'App\Feedback' => 'App\Policies\FeedbackPolicy',
        'App\Comment' => 'App\Policies\CommentPolicy',
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

        if(Schema::hasTable('role') && Schema::hasTable('permission') && Schema::hasTable('role_permission'))
        {

            foreach($this->getPermissions() as $permission)
            {
                $gate->define($permission->name, function($user) use ($permission) {
                    return $user->hasRole($permission->roles);
                });
            }

            $gate->before(function ($user, $ability) {
                if ($user->isAdministrator()) {
                    return true;
                }
            });
        }
    }

    protected function getPermissions()
    {
        return Permission::with(['roles'])->get();
    }
}
